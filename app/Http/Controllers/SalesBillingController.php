<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Implant;
use App\Models\Document;
use App\Models\Generator;
use App\Models\ImplantLog;
use App\Models\AbbottModel;
use Illuminate\Support\Str;
use App\Models\ApprovalType;
use App\Models\ImplantModel;
use Illuminate\Http\Request;
use App\Models\StockLocation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SalesBillingController extends Controller
{
    // CONFIRM & UPDATE ICF - FUNCTION 
    public function confirmICFData(Request $req, $id)
    {
        $id = Crypt::decrypt($id);

        /**** 01 - Validate Incoming Request ****/
        $validator = Validator::make($req->all(), [
            'implant_pt_address' => 'nullable|string',
            'implant_generator_sn' => 'required|string',
            'implant_generator_itemPrice' => 'nullable|decimal:0,2',
            'implant_generator_qty' => 'nullable|integer|min:1',
            'implant_sales_total_price' => 'nullable|decimal:0,2',
            'generator_id' => 'required|integer',
            'stock_location_id' => 'required|integer',
            'approval_type_id' => 'required|integer',
            'model_ids' => 'nullable|array',
            'model_sns' => 'nullable|array',
            'model_price' => 'nullable|array',
            'model_qty' => 'nullable|array',
            'stock_location_ids' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $validated = $validator->validated();
            $implant = Implant::findOrFail($id);
            $changes = [];
            $modelChanges = [];

            /**** 02 - Load Old & New Relations for Comparison Logging ****/
            $oldGenerator = Generator::find($implant->generator_id);
            $newGenerator = Generator::find($validated['generator_id']);

            $oldStockLocation = StockLocation::find($implant->stock_location_id);
            $newStockLocation = StockLocation::find($validated['stock_location_id']);

            $oldApprovalType = ApprovalType::find($implant->approval_type_id);
            $newApprovalType = ApprovalType::find($validated['approval_type_id']);

            /**** 03 - Compare & Collect Changes for Logging (Implant Fields) ****/
            if ($implant->generator_id != $validated['generator_id']) {
                $changes[] = "Generator changed from \"{$oldGenerator?->generator_code}\" to \"{$newGenerator?->generator_code}\"";
            }
            if ($implant->stock_location_id != $validated['stock_location_id']) {
                $changes[] = "Stock Location changed from \"{$oldStockLocation?->stock_location_name}\" to \"{$newStockLocation?->stock_location_name}\"";
            }
            if ($implant->approval_type_id != $validated['approval_type_id']) {
                $changes[] = "Approval Type changed from \"{$oldApprovalType?->approval_type_name}\" to \"{$newApprovalType?->approval_type_name}\"";
            }
            if ($implant->implant_generator_sn != $validated['implant_generator_sn']) {
                $changes[] = "Generator SN changed from \"{$implant->implant_generator_sn}\" to \"{$validated['implant_generator_sn']}\"";
            }
            if ($implant->implant_generator_itemPrice != $validated['implant_generator_itemPrice']) {
                $changes[] = "Generator Price changed from \"{$implant->implant_generator_itemPrice}\" to \"{$validated['implant_generator_itemPrice']}\"";
            }
            if ($implant->implant_generator_qty != $validated['implant_generator_qty']) {
                $changes[] = "Generator Quantity changed from \"{$implant->implant_generator_qty}\" to \"{$validated['implant_generator_qty']}\"";
            }
            if ($implant->implant_sales_total_price != $validated['implant_sales_total_price']) {
                $changes[] = "Sales Total Price changed from \"{$implant->implant_sales_total_price}\" to \"{$validated['implant_sales_total_price']}\"";
            }
            if ($implant->implant_pt_address != $validated['implant_pt_address']) {
                $changes[] = "Patient Address changed from \"{$implant->implant_pt_address}\" to \"{$validated['implant_pt_address']}\"";
            }

            /**** 04 - Update Implant Details ****/
            $implant->update([
                'implant_pt_address' => $validated['implant_pt_address'],
                'implant_generator_sn' => $validated['implant_generator_sn'],
                'implant_generator_itemPrice' => $validated['implant_generator_itemPrice'],
                'implant_generator_qty' => $validated['implant_generator_qty'],
                'implant_sales_total_price' => $validated['implant_sales_total_price'],
                'generator_id' => $validated['generator_id'],
                'stock_location_id' => $validated['stock_location_id'],
                'approval_type_id' => $validated['approval_type_id']
            ]);

            /**** 05 - Handle Associated Implant Models ****/
            $existingModels = ImplantModel::where('implant_id', $id)->get()->keyBy('model_id');
            $processedModels = [];

            if (!empty($validated['model_ids'])) {
                foreach ($validated['model_ids'] as $index => $modelID) {
                    $sn = $validated['model_sns'][$index] ?? '';
                    if (!$sn) continue;

                    $qty = $validated['model_qty'][$index] ?? 1;
                    $price = $validated['model_price'][$index] ?? 0;
                    $stockLocID = $validated['stock_location_ids'][$index] ?? null;

                    $model = AbbottModel::find($modelID);
                    $modelCode = $model?->model_code ?? "Model-$modelID";
                    $stockLocName = StockLocation::find($stockLocID)?->stock_location_name;

                    $data = [
                        'implant_model_sn' => $sn,
                        'implant_model_qty' => $qty,
                        'implant_model_itemPrice' => $price,
                        'stock_location_id' => $stockLocID,
                    ];

                    if (isset($existingModels[$modelID])) {
                        // Update existing model and log changes
                        $existing = $existingModels[$modelID];

                        if ($existing->implant_model_sn != $sn) {
                            $modelChanges[] = "$modelCode: SN changed from \"{$existing->implant_model_sn}\" to \"$sn\"";
                        }
                        if ($existing->implant_model_qty != $qty) {
                            $modelChanges[] = "$modelCode: Qty changed from \"{$existing->implant_model_qty}\" to \"$qty\"";
                        }
                        if ($existing->implant_model_itemPrice != $price) {
                            $modelChanges[] = "$modelCode: Price changed from \"{$existing->implant_model_itemPrice}\" to \"$price\"";
                        }
                        if ($existing->stock_location_id != $stockLocID) {
                            $oldLoc = StockLocation::find($existing->stock_location_id)?->stock_location_name;
                            $modelChanges[] = "$modelCode: Stock Location changed from \"$oldLoc\" to \"$stockLocName\"";
                        }

                        $existing->update($data);
                    } else {
                        // Add new model
                        ImplantModel::create([
                            'implant_id' => $implant->id,
                            'model_id' => $modelID,
                            ...$data
                        ]);
                        $modelChanges[] = "$modelCode: model added";
                    }

                    $processedModels[] = $modelID;
                }
            }

            /**** 06 - Handle Removed Models ****/
            foreach ($existingModels as $mid => $mdata) {
                if (!in_array($mid, $processedModels)) {
                    $modelCode = AbbottModel::find($mid)?->model_code ?? "Model-$mid";
                    $modelChanges[] = "$modelCode: model removed";
                    $mdata->delete();
                }
            }

            DB::commit();

            /**** 07 - Regenerate ICF Documents ****/
            (new ImplantController())->generateIRF(Crypt::encrypt($implant->id));
            $this->generatePreviewDownloadICF(Crypt::encrypt($implant->id), 2);

            /**** 08 - Record Implant Update Log ****/
            ImplantLog::create([
                'user_id' => auth()->user()->id,
                'staff_id' => auth()->user()->id,
                'implant_id' => $implant->id,
                'log_datetime' => Carbon::now(),
                'log_activity' =>
                "Implant record updated by " . auth()->user()->staff_name .
                    " — Patient: {$implant->implant_pt_name} (IC: {$implant->implant_pt_icno}, Ref No: {$implant->implant_refno})<br><br>" .
                    "<strong>Changes:</strong><br>" . (count($changes) ? implode('<br>', $changes) : 'No implant field changes.') . "<br><br>" .
                    "<strong>Model Changes:</strong><br>" . (count($modelChanges) ? implode('<br>', $modelChanges) : 'No implant model changes.')
            ]);

            return back()->with('success', 'Inventory Consumption Form updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            /**** 09 - Handle Exceptions ****/
            return back()->with('error', 'Failed to update ICF: ' . $e->getMessage());
        }
    }

    // ICF HANDLER - FUNCTION
    // NOTES : [1] -> VIEW [2] -> GENERATE [3] -> DOWNLOAD
    public function generatePreviewDownloadICF($id, $opt)
    {
        try {
            $id = Crypt::decrypt($id);
            $modelCategories = DB::table('model_categories')
                ->select('id as model_category_id', 'mcategory_abbreviation as model_category')
                ->where('mcategory_abbreviation', '!=', null)
                ->get();

            $implant = DB::table('implants as a')
                ->join('generators as b', 'a.generator_id', '=', 'b.id')
                ->join('regions as c', 'a.region_id', '=', 'c.id')
                ->join('hospitals as d', 'a.hospital_id', '=', 'd.id')
                ->join('doctors as e', 'a.doctor_id', '=', 'e.id')
                ->leftJoin('stock_locations as f', 'a.stock_location_id', '=', 'f.id')
                ->leftJoin('product_group_lists as g', 'a.id', '=', 'g.implant_id')
                ->leftJoin('product_groups as h', 'g.product_group_id', '=', 'h.id')
                ->where('a.id', $id)
                ->select([
                    'a.id',
                    'a.implant_date',
                    'a.implant_refno',
                    'd.hospital_name',
                    'd.hospital_phoneno',
                    'd.hospital_code',
                    'e.doctor_name',
                    'e.doctor_phoneno',
                    'b.generator_name',
                    'b.generator_code',
                    'a.implant_generator_sn',
                    'a.implant_generator_qty',
                    'a.implant_generator_itemPrice',
                    'a.implant_pt_name',
                    'a.implant_pt_address',
                    'a.implant_pt_directory',
                    'a.implant_pt_mrn',
                    'a.implant_pt_icno',
                    'a.approval_type_id',
                    'f.stock_location_name',
                    'f.stock_location_code',
                ])
                ->groupBy(
                    'a.id',
                    'a.implant_date',
                    'a.implant_refno',
                    'd.hospital_name',
                    'd.hospital_phoneno',
                    'd.hospital_code',
                    'e.doctor_name',
                    'e.doctor_phoneno',
                    'b.generator_name',
                    'b.generator_code',
                    'a.implant_generator_sn',
                    'a.implant_generator_qty',
                    'a.implant_generator_itemPrice',
                    'a.implant_pt_name',
                    'a.implant_pt_address',
                    'a.implant_pt_directory',
                    'a.implant_pt_mrn',
                    'a.implant_pt_icno',
                    'a.approval_type_id',
                    'f.stock_location_name',
                    'f.stock_location_code',
                )
                ->first();

            $models = DB::table('implant_models as i')
                ->join('abbott_models as j', 'i.model_id', '=', 'j.id')
                ->join('model_categories as k', 'j.mcategory_id', '=', 'k.id')
                ->join('stock_locations as l', 'i.stock_location_id', '=', 'l.id')
                ->where('i.implant_id', $id)
                ->select([
                    'k.id as model_category_id',
                    'k.mcategory_name as model_category',
                    'j.model_name',
                    'j.model_code',
                    'i.implant_model_sn',
                    'i.implant_model_qty',
                    'i.implant_model_itemPrice',
                    'l.stock_location_name',
                    'l.stock_location_code'
                ])
                ->get();

            $mergedModels = [];

            foreach ($modelCategories as $category) {
                // Get all models that belong to this category
                $matchedModels = $models->where('model_category_id', $category->model_category_id);

                // If no models found, you can optionally add a default/empty row
                if ($matchedModels->isEmpty()) {
                    $mergedModels[] = [
                        'model_category_id' => $category->model_category_id,
                        'model_category' => $category->model_category,
                        'model_name' => '-',
                        'model_code' => '-',
                        'implant_model_sn' => '-',
                        'implant_model_qty' => 0,
                        'implant_model_itemPrice' => 0,
                        'stock_location_name' => '-',
                        'stock_location_code' => '-',
                    ];
                    continue;
                }

                // Loop through each matched model
                foreach ($matchedModels as $model) {
                    $mergedModels[] = [
                        'model_category_id' => $category->model_category_id,
                        'model_category' => $category->model_category,
                        'model_name' => $model->model_name ?? '-',
                        'model_code' => $model->model_code ?? '-',
                        'implant_model_sn' => $model->implant_model_sn ?? '-',
                        'implant_model_qty' => $model->implant_model_qty ?? 0,
                        'implant_model_itemPrice' => $model->implant_model_itemPrice ?? 0,
                        'stock_location_name' => $model->stock_location_name ?? '-',
                        'stock_location_code' => $model->stock_location_code ?? '-',
                    ];
                }
            }

            $formattedData = [
                'id' => $implant->id ?? '-',
                'implant_date' => Carbon::parse($implant->implant_date)->format('d M Y') ?? '-',
                'implant_refno' => $implant->implant_refno ?? '-',
                'hospital_name' => Str::upper($implant->hospital_name) ?? '-',
                'hospital_phoneno' => $implant->hospital_phoneno ?? '-',
                'hospital_code' => $implant->hospital_code ?? '-',
                'doctor_name' => Str::upper($implant->doctor_name) ?? '-',
                'doctor_phoneno' => $implant->doctor_phoneno ?? '-',
                'generator_name' => Str::upper($implant->generator_name) ?? '-',
                'generator_code' => Str::upper($implant->generator_code) ?? '-',
                'implant_generator_sn' => $implant->implant_generator_sn ?? '-',
                'implant_generator_qty' => $implant->implant_generator_qty ?? 0,
                'implant_generator_itemPrice' => $implant->implant_generator_itemPrice ?? 0,
                'implant_pt_name' => Str::upper($implant->implant_pt_name) ?? '-',
                'implant_pt_address' => $implant->implant_pt_address ?? '-',
                'implant_pt_directory' => $implant->implant_pt_directory ?? '-',
                'implant_pt_mrn' => $implant->implant_pt_mrn ?? '-',
                'implant_pt_icno' => $implant->implant_pt_icno ?? '-',
                'implant_approval_type' => ApprovalType::whereId($implant->approval_type_id)->first()->approval_type_name ?? '-',
                'stock_location_name' => Str::upper($implant->stock_location_name) ?? '-',
                'stock_location_code' => $implant->stock_location_code ?? '-',
                'models' => $mergedModels,
            ];

            $title =  $formattedData['hospital_code'] . '_' . $formattedData['generator_code'] . '_' . strtoupper(Carbon::parse($formattedData['implant_date'])->format('dMY')) . '_' .  strtoupper(preg_replace('/[^A-Za-z0-9]/', '_', $formattedData['implant_pt_name'])) . '_ICF';
            $pdf = Pdf::loadView('crmd-system.sales-billing.icf-template-doc-v2', [
                'title' => $title,
                'data' => $formattedData,
                'stocklocations' => StockLocation::all(),
            ])
                ->setOption('isRemoteEnabled', true)
                ->setOption('defaultPaperSize', 'a4')
                ->setOption('isPhpEnabled', true)
                ->setPaper('a4', 'landscape');

            $implant = Implant::where('id', $id)->first();

            if ($opt == 1) {
                // VIEW PDF
                ImplantLog::create([
                    'log_activity' => 'Inventory consumption form viewed by ' . auth()->user()->staff_name . ' — Patient: ' . $implant->implant_pt_name . ' (IC: ' . $implant->implant_pt_icno . ', Ref No: ' . $implant->implant_refno . ')',
                    'log_datetime' => now(),
                    'staff_id' => auth()->user()->id,
                    'implant_id' => $implant->id,
                ]);
                return $pdf->stream($title . '.pdf');
            } elseif ($opt == 2) {
                // SAVE TO STORAGE
                $filePath = 'implants/' . $formattedData['implant_pt_directory'] . '/' . $title . '.pdf';

                $implant->implant_pt_icf = $filePath;
                $implant->save();

                return $pdf->save(public_path("storage/{$filePath}"));
            } elseif ($opt == 3) {
                // DOWNLOAD
                return $pdf->download($title . '.pdf');
            } else {
                return back()->with('error', 'Opps! Invalid option.');
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // UPLOAD FILE - AJAX FUNCTION
    public function uploadDocument(Request $req, $id)
    {
        $id = Crypt::decrypt($id);

        $validator = Validator::make($req->all(), [
            'sb_approval'      => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,xls,xlsx,csv|max:10240',
            'sb_borangG'       => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,xls,xlsx,csv|max:10240',
            'sb_do'            => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,xls,xlsx,csv|max:10240',
            'sb_borangF'       => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,xls,xlsx,csv|max:10240',
            'sb_receipt'       => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,xls,xlsx,csv|max:10240',
            'sb_other_one'     => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,xls,xlsx,csv|max:10240',
            'sb_other_two'     => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,xls,xlsx,csv|max:10240',
            'sb_other_three'   => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,xls,xlsx,csv|max:10240',
            'sb_other_four'    => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,xls,xlsx,csv|max:10240',
        ], [], [
            'sb_approval'      => 'Approval Form',
            'sb_borangG'       => 'Borang G',
            'sb_do'            => 'DO',
            'sb_borangF'       => 'Borang F',
            'sb_receipt'       => 'Receipt',
            'sb_other_one'     => 'Document',
            'sb_other_two'     => 'Document',
            'sb_other_three'   => 'Document',
            'sb_other_four'    => 'Document',

        ]);

        if ($validator->fails()) {
            if ($req->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
        }

        try {
            $implant = DB::table('implants as a')
                ->join('generators as b', 'a.generator_id', '=', 'b.id')
                ->join('hospitals as c', 'a.hospital_id', '=', 'c.id')
                ->where('a.id', $id)
                ->select('a.*', 'b.generator_code', 'c.hospital_code')
                ->first();

            if (!$implant) {
                return response()->json(['success' => false, 'message' => 'Oops! Implant not found.']);
            }

            $hospitalCode = $implant->hospital_code;
            $generatorCode = $implant->generator_code;
            $implantDate = strtoupper(Carbon::parse($implant->implant_date)->format('dMY'));
            $patientName = strtoupper(preg_replace('/[^A-Za-z0-9]/', '_', $implant->implant_pt_name));
            $targetFolder = 'public/implants/' . $implant->implant_pt_directory;

            Storage::makeDirectory($targetFolder);

            $fileLabelMap = [
                'sb_approval'      => 'APPROVAL',
                'sb_borangG'       => 'BORANG_G',
                'sb_do'            => 'DO',
                'sb_borangF'       => 'BORANG_F',
                'sb_receipt'       => 'RECEIPT',
                'sb_other_one'     => 'OTHERS_1',
                'sb_other_two'     => 'OTHERS_2',
                'sb_other_three'   => 'OTHERS_3',
                'sb_other_four'    => 'OTHERS_4',
            ];

            $filePaths = [];

            $existing = Document::where('implant_id', $id)->first();

            foreach ($fileLabelMap as $field => $label) {
                if ($req->hasFile($field)) {
                    if (!empty($existing->$field) && Storage::exists($existing->$field)) {
                        Storage::delete($existing->$field);
                    }

                    $file = $req->file($field);
                    $extension = $file->getClientOriginalExtension();
                    $fileName = "{$hospitalCode}_{$generatorCode}_{$implantDate}_{$patientName}_{$label}.{$extension}";
                    $path = $file->storeAs($targetFolder, $fileName);

                    $filePaths[$field] = $path;
                }
            }


            Document::updateOrCreate(
                ['implant_id' => $id],
                [
                    'sb_approval'    => $filePaths['sb_approval'] ?? $existing->sb_approval ?? null,
                    'sb_borangG'     => $filePaths['sb_borangG'] ?? $existing->sb_borangG ?? null,
                    'sb_do'          => $filePaths['sb_do'] ?? $existing->sb_do ?? null,
                    'sb_borangF'     => $filePaths['sb_borangF'] ?? $existing->sb_borangF ?? null,
                    'sb_receipt'     => $filePaths['sb_receipt'] ?? $existing->sb_receipt ?? null,
                    'sb_other_one'   => $filePaths['sb_other_one'] ?? $existing->sb_other_one ?? null,
                    'sb_other_two'   => $filePaths['sb_other_two'] ?? $existing->sb_other_two ?? null,
                    'sb_other_three' => $filePaths['sb_other_three'] ?? $existing->sb_other_three ?? null,
                    'sb_other_four'  => $filePaths['sb_other_four'] ?? $existing->sb_other_four ?? null,
                ]
            );

            foreach ($fileLabelMap as $field => $label) {
                if ($req->hasFile($field)) {

                    $file = $req->file($field);
                    $extension = $file->getClientOriginalExtension();
                    $fileName = "{$hospitalCode}_{$generatorCode}_{$implantDate}_{$patientName}_{$label}.{$extension}";

                    ImplantLog::create([
                        'log_activity' => 'File uploaded (' . $fileName . ') by ' . auth()->user()->staff_name .
                            ' — Patient: ' . $implant->implant_pt_name .
                            ' (IC: ' . $implant->implant_pt_icno . ', Ref No: ' . $implant->implant_refno . ')',
                        'log_datetime' => now(),
                        'staff_id' => auth()->user()->id,
                        'implant_id' => $id,
                    ]);
                }
            }

            return response()->json(['success' => true, 'message' => 'Documents uploaded and saved successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error uploading documents: ' . $e->getMessage()]);
        }
    }

    // DELETE UPLOADED FILE - AJAX FUNCTION
    public function deleteUploadedFile(Request $req)
    {
        try {
            $docId = Crypt::decrypt($req->doc_id);
            $field = $req->field;

            $doc = Document::whereId($docId)->first();

            if (!empty($doc->$field) && Storage::exists($doc->$field)) {
                $deletedFileName = basename($doc->$field);

                $implant = Implant::find($doc->implant_id);

                if ($implant) {
                    ImplantLog::create([
                        'log_activity' => 'File deleted (' . $deletedFileName . ') by ' . auth()->user()->staff_name .
                            ' — Patient: ' . $implant->implant_pt_name .
                            ' (IC: ' . $implant->implant_pt_icno . ', Ref No: ' . $implant->implant_refno . ')',
                        'log_datetime' => now(),
                        'staff_id' => auth()->user()->id,
                        'implant_id' => $implant->id,
                    ]);
                }

                Storage::delete($doc->$field);
            }

            $doc->$field = null;
            $doc->save();

            return response()->json(['success' => true, 'message' => 'File deleted successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting file: ' . $e->getMessage()]);
        }
    }

    // VIEW UPLOADED FILE
    public function viewUploadedDocument($path)
    {
        try {
            $path = Crypt::decrypt($path);
            $path = storage_path("app/{$path}");
            
            if (!file_exists($path)) {
                abort(404, 'File not found.');
            }

            return response()->file($path);
        } catch (Exception $e) {
            return back()->with('error', 'Oops! Error loading documents: ' . $e->getMessage());
        }
    }


    // CONFIRM & UPDATE ICF - FUNCTION [NOT IN USE]
    // public function confirmICFData(Request $req, $id)
    // {
    //     $id = Crypt::decrypt($id);
    //     $validator = Validator::make($req->all(), [
    //         'implant_pt_address' => 'nullable|string',
    //         'implant_generator_sn' => 'required|string',
    //         'implant_generator_itemPrice' => 'nullable|decimal:0,2',
    //         'implant_generator_qty' => 'nullable|integer|min:1',
    //         'implant_sales_total_price' => 'nullable|decimal:0,2',
    //         'generator_id' => 'required|integer',
    //         'stock_location_id' => 'required|integer',
    //         'approval_type_id' => 'required|integer',
    //         'model_ids' => 'nullable|array',
    //         'model_sns' => 'nullable|array',
    //         'model_price' => 'nullable|array',
    //         'model_qty' => 'nullable|array',
    //         'stock_location_ids' => 'nullable|array',
    //     ], [], [
    //         'implant_pt_address' => 'patient address',
    //         'implant_generator_sn' => 'generator serial number',
    //         'implant_generator_itemPrice' => 'generator price',
    //         'implant_generator_qty' => 'generator quantity',
    //         'implant_sales_total_price' => 'implant sales',
    //         'generator_id' => 'generator',
    //         'stock_location_id' => 'stock location',
    //         'approval_type_id' => 'payment method / approval type',
    //         'model_ids' => 'model',
    //         'model_sns' => 'model serial number',
    //         'model_price' => 'model price',
    //         'model_qty' => 'model quantity',
    //         'stock_location_ids' => 'model stock location',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     try {
    //         DB::beginTransaction();

    //         $validated = $validator->validated();

    //         /**** 01 - Update Implant Details ****/
    //         $implant = Implant::whereId($id)->first();

    //         $implant->update([
    //             'implant_pt_address' => $validated['implant_pt_address'],
    //             'implant_generator_sn' => $validated['implant_generator_sn'],
    //             'implant_generator_itemPrice' => $validated['implant_generator_itemPrice'],
    //             'implant_generator_qty' => $validated['implant_generator_qty'],
    //             'implant_sales_total_price' => $validated['implant_sales_total_price'],
    //             'generator_id' => $validated['generator_id'],
    //             'stock_location_id' => $validated['stock_location_id'],
    //             'approval_type_id' => $validated['approval_type_id']
    //         ]);

    //         /**** 02 - Update / Add Implant Models ****/
    //         if (isset($validated['model_ids'], $validated['model_sns'],  $validated['model_price'], $validated['model_qty'], $validated['stock_location_ids'])) {
    //             foreach ($validated['model_ids'] as $index => $modelID) {
    //                 if (isset($validated['model_sns'][$index], $validated['model_price'][$index], $validated['model_qty'][$index], $validated['stock_location_ids'][$index])) {
    //                     $modelSN = $validated['model_sns'][$index];
    //                     $stockLocationID = $validated['stock_location_ids'][$index];
    //                     $modelPrice = $validated['model_price'][$index];
    //                     $modelQty = $validated['model_qty'][$index];

    //                     $existingIM = ImplantModel::where('implant_id', $id)->where('model_id', $modelID)->first();

    //                     if ($existingIM) {
    //                         $existingIM->update([
    //                             'implant_model_sn' => $modelSN,
    //                             'stock_location_id' => $stockLocationID,
    //                             'implant_model_itemPrice' => $modelPrice,
    //                             'implant_model_qty' => $modelQty
    //                         ]);
    //                     } else {
    //                         ImplantModel::create([
    //                             'implant_id' => $id,
    //                             'model_id' => $modelID,
    //                             'implant_model_sn' => $modelSN,
    //                             'stock_location_id' => $stockLocationID,
    //                             'implant_model_itemPrice' => $modelPrice,
    //                             'implant_model_qty' => $modelQty
    //                         ]);
    //                     }
    //                 }
    //             }
    //         }

    //         $updatedModelIDs = isset($validated['model_ids'])
    //             ? array_filter($validated['model_ids'], fn($id) => !is_null($id))
    //             : [];

    //         ImplantModel::where('implant_id', $id)->whereNotIn('model_id', $updatedModelIDs)->delete();

    //         DB::commit();

    //         /**** 03 - Implants Registration Form Generation ****/
    //         $imc = new ImplantController();
    //         $imc->generateIRF(Crypt::encrypt($implant->id));

    //         /**** 04 - Inventory Consumption Form Generation ****/
    //         $this->generatePreviewDownloadICF(Crypt::encrypt($implant->id), 2);

    //         return back()->with('success', 'Inventory Consumption Form updated successfully.');
    //     } catch (Exception $e) {
    //         return back()->with('error', 'Opps!, Error updating ICF: ' . $e->getMessage());
    //     }
    // }
}
