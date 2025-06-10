<?php

namespace App\Http\Controllers;

use Exception;
use ZipArchive;
use Carbon\Carbon;
use App\Models\Implant;
use App\Models\Hospital;
use App\Models\Generator;
use App\Models\AbbottModel;
use Illuminate\Support\Str;
use App\Models\ApprovalType;
use App\Models\ImplantModel;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use App\Exports\ImplantsExport;
use App\Mail\PatientIDCardMail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ProductGroupList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\SalesBillingController;

class ImplantController extends Controller
{
    // ADD IMPLANT - FUNCTION
    public function addImplant(Request $req)
    {
        // dd($req->all());
        $validator = Validator::make($req->all(), [
            'implant_refno' => 'nullable|string',
            'implant_date' => 'required|date',
            'implant_pt_name' => 'required|string',
            'implant_pt_icno' => 'required|min:7|max:15|string',
            'implant_pt_address' => 'nullable|string',
            'implant_pt_mrn' => 'nullable|string',
            'implant_pt_email' => 'nullable|email',
            'implant_pt_phoneno' => 'nullable|string',
            'implant_pt_dob' => 'nullable|string',
            'implant_pt_directory' => 'nullable|string',
            'implant_generator_sn' => 'required|string',
            'implant_generator_qty' => 'nullable|integer|min:1',
            'implant_generator_itemPrice' => 'nullable|decimal:0,2',
            'implant_sales_total_price' => 'required|decimal:0,2',
            'generator_id' => 'required|integer',
            'region_id' => 'required|integer',
            'hospital_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'stock_location_id' => 'required|integer',
            'approval_type_id' => 'required|integer',
            'product_groups' => 'required|array',
            'model_ids' => 'nullable|array',
            'model_sns' => 'nullable|array',
            'model_price' => 'nullable|array',
            'model_qty' => 'nullable|array',
            'stock_location_ids' => 'nullable|array',
        ], [], [
            'implant_refno' => 'implant code',
            'implant_date' => 'implant date',
            'implant_pt_name' => 'patient name',
            'implant_pt_icno' => 'patient ic number',
            'implant_pt_address' => 'patient address',
            'implant_pt_mrn' => 'patient mrn',
            'implant_pt_email' => 'patient email',
            'implant_pt_phoneno' => 'patient phone number',
            'implant_pt_dob' => 'patient date of birth',
            'implant_pt_directory' => 'patient directory',
            'implant_generator_sn' => 'generator serial number',
            'implant_generator_qty' => 'generator quantity',
            'implant_generator_itemPrice' => 'generator price',
            'implant_sales_total_price' => 'implant sales',
            'generator_id' => 'generator',
            'region_id' => 'region',
            'hospital_id' => 'hospital',
            'doctor_id' => 'doctor',
            'stock_location_id' => 'stock location',
            'approval_type_id' => 'approval type',
            'product_groups' => 'product group',
            'model_ids' => 'model',
            'model_sns' => 'model serial number',
            'model_price' => 'model price',
            'model_qty' => 'model quantity',
            'stock_location_ids' => 'model stock location',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        try {
            $validated = $validator->validated();

            /**** 01 - Implants ****/
            $implantcode = 'IMP' . str_pad(Implant::count() + 1, 3, '0', STR_PAD_LEFT) . Carbon::parse($validated['implant_date'])->format('dmY');

            // Create Directory
            $sequenceNumber = str_pad(Implant::count() + 1, 3, '0', STR_PAD_LEFT);
            $hospital_code = optional(Hospital::find($validated['hospital_id']))->hospital_code ?? 'H0000';
            $implantdirectory = "{$sequenceNumber}_" . Carbon::parse($validated['implant_date'])->format('d.m.Y') . '_' . strtoupper(preg_replace('/[^A-Za-z0-9]/', '_', $validated['implant_pt_name'])) . "_{$hospital_code}";

            Storage::makeDirectory("public/implants/{$implantdirectory}");

            // Assign Values
            $validated['implant_refno'] = $implantcode;
            $validated['implant_pt_directory'] = $implantdirectory;

            // Store Implant
            $implant = Implant::create($validated);

            /**** 02 - Product Groups ****/
            if (!empty($validated['product_groups'])) {
                foreach ($validated['product_groups'] as $product_group) {
                    $pg = ProductGroup::where('product_group_name', trim($product_group))->first();
                    if ($pg) {
                        ProductGroupList::firstOrCreate([
                            'implant_id' => $implant->id,
                            'product_group_id' => $pg->id
                        ]);
                    }
                }
            }

            /**** 03 - Implants X Model ****/
            if (!empty($validated['model_ids']) && !empty($validated['model_sns']) && !empty($validated['model_price']) && !empty($validated['model_qty']) && !empty($validated['stock_location_ids'])) {
                foreach ($validated['model_ids'] as $index => $model) {
                    if (!isset($validated['model_sns'][$index], $validated['model_price'][$index], $validated['model_qty'][$index], $validated['stock_location_ids'][$index])) {
                        continue;
                    }

                    $modelID = optional(AbbottModel::find($model))->id;
                    $stockLocationID = $validated['stock_location_ids'][$index] ?? null;
                    $modelSN = $validated['model_sns'][$index] ?? null;
                    $modelPrice = $validated['model_price'][$index] ?? null;
                    $modelQty = $validated['model_qty'][$index] ?? null;

                    if ($modelID && $stockLocationID && $modelSN) {
                        ImplantModel::firstOrCreate([
                            'implant_id' => $implant->id,
                            'model_id' => $modelID,
                            'stock_location_id' => $stockLocationID,
                            'implant_model_sn' => $modelSN,
                            'implant_model_itemPrice' => $modelPrice,
                            'implant_model_qty' => $modelQty

                        ]);
                    }
                }
            }

            /**** 04 - Implants Registration Form Generation ****/
            $this->generateIRF(Crypt::encrypt($implant->id));

            /**** 05 - Inventory Consumption Form Generation ****/
            $sbc = new SalesBillingController();
            $sbc->generatePreviewDownloadICF(Crypt::encrypt($implant->id), 2);

            return redirect()->route('manage-implant-page')->with('success', 'Implant added successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // UPDATE IMPLANT - FUNCTION
    public function updateImplant(Request $req, $id)
    {
        $id = Crypt::decrypt($id);
        $validator = Validator::make($req->all(), [
            'implant_refno' => 'nullable|string',
            'implant_date' => 'required|date',
            'implant_pt_name' => 'required|string',
            'implant_pt_icno' => 'required|min:7|max:15|string',
            'implant_pt_address' => 'nullable|string',
            'implant_pt_mrn' => 'nullable|string',
            'implant_pt_email' => 'nullable|email',
            'implant_pt_phoneno' => 'nullable|string',
            'implant_pt_dob' => 'nullable|string',
            'implant_pt_directory' => 'nullable|string',
            'implant_generator_sn' => 'required|string',
            'implant_generator_qty' => 'nullable|integer|min:1',
            'implant_generator_itemPrice' => 'nullable|decimal:0,2',
            'implant_sales_total_price' => 'required|decimal:0,2',
            'generator_id' => 'required|integer',
            'region_id' => 'required|integer',
            'hospital_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'stock_location_id' => 'required|integer',
            'approval_type_id' => 'required|integer',
            'product_groups' => 'required|array',
            'model_ids' => 'nullable|array',
            'model_sns' => 'nullable|array',
            'model_price' => 'nullable|array',
            'model_qty' => 'nullable|array',
            'stock_location_ids' => 'nullable|array',
        ], [], [
            'implant_refno' => 'implant code',
            'implant_date' => 'implant date',
            'implant_pt_name' => 'patient name',
            'implant_pt_icno' => 'patient ic number',
            'implant_pt_address' => 'patient address',
            'implant_pt_mrn' => 'patient mrn',
            'implant_pt_email' => 'patient email',
            'implant_pt_phoneno' => 'patient phone number',
            'implant_pt_dob' => 'patient date of birth',
            'implant_pt_directory' => 'patient directory',
            'implant_generator_sn' => 'generator serial number',
            'implant_generator_qty' => 'generator quantity',
            'implant_generator_itemPrice' => 'generator price',
            'implant_sales_total_price' => 'implant sales',
            'generator_id' => 'generator',
            'region_id' => 'region',
            'hospital_id' => 'hospital',
            'doctor_id' => 'doctor',
            'stock_location_id' => 'stock location',
            'approval_type_id' => 'approval type',
            'product_groups' => 'product group',
            'model_ids' => 'model',
            'model_sns' => 'model serial number',
            'model_price' => 'model price',
            'model_qty' => 'model quantity',
            'stock_location_ids' => 'model stock location',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $validated = $validator->validated();
            $implant = Implant::whereId($id)->first();

            /**** 01 - Update Implant Code & Directory ****/
            $oldDirectory = $implant->implant_pt_directory;
            $newImplantCode = 'IMP' . str_pad($implant->id, 3, '0', STR_PAD_LEFT) . Carbon::parse($validated['implant_date'])->format('dmY');
            $sequenceNumber = str_pad($implant->id, 3, '0', STR_PAD_LEFT);
            $hospital_code = Hospital::find($validated['hospital_id'])->hospital_code ?? 'H0000';
            $newDirectory = $sequenceNumber . '_' . Carbon::parse($validated['implant_date'])->format('d.m.Y') . '_' . strtoupper(preg_replace('/[^A-Za-z0-9]/', '_', $validated['implant_pt_name'])) . '_' . strtoupper($hospital_code);

            if ($oldDirectory !== $newDirectory) {
                Storage::move('public/implants/' . $oldDirectory, 'public/implants/' . $newDirectory);
            } else {
                Storage::makeDirectory('public/implants/' . $newDirectory);
            }

            $implant->update([
                'implant_refno' => $newImplantCode,
                'implant_pt_directory' => $newDirectory,
                'implant_date' => $validated['implant_date'],
                'implant_pt_name' => $validated['implant_pt_name'],
                'implant_pt_icno' => $validated['implant_pt_icno'],
                'implant_pt_mrn' => $validated['implant_pt_mrn'],
                'implant_pt_address' => $validated['implant_pt_address'],
                'implant_pt_email' => $validated['implant_pt_email'],
                'implant_pt_phoneno' => $validated['implant_pt_phoneno'],
                'implant_pt_dob' => $validated['implant_pt_dob'],
                'implant_generator_sn' => $validated['implant_generator_sn'],
                'implant_generator_itemPrice' => $validated['implant_generator_itemPrice'],
                'implant_generator_qty' => $validated['implant_generator_qty'],
                'implant_sales_total_price' => $validated['implant_sales_total_price'],
                'generator_id' => $validated['generator_id'],
                'region_id' => $validated['region_id'],
                'hospital_id' => $validated['hospital_id'],
                'doctor_id' => $validated['doctor_id'],
                'stock_location_id' => $validated['stock_location_id'],
                'approval_type_id' => $validated['approval_type_id'],
            ]);

            /**** 02 - Update / Add Product Groups ****/
            $existingPGs = ProductGroupList::where('implant_id', $id)->pluck('product_group_id')->toArray();
            foreach ($validated['product_groups'] as $pgID) {
                if (!in_array($pgID, $existingPGs)) {
                    ProductGroupList::create([
                        'implant_id' => $id,
                        'product_group_id' => $pgID
                    ]);
                }
            }

            ProductGroupList::where('implant_id', $id)->whereNotIn('product_group_id', $validated['product_groups'])->delete();

            /**** 03 - Update / Add Implant Models ****/
            if (isset($validated['model_ids'], $validated['model_sns'],  $validated['model_price'], $validated['model_qty'], $validated['stock_location_ids'])) {
                foreach ($validated['model_ids'] as $index => $modelID) {
                    if (isset($validated['model_sns'][$index], $validated['model_price'][$index], $validated['model_qty'][$index], $validated['stock_location_ids'][$index])) {
                        $modelSN = $validated['model_sns'][$index];
                        $stockLocationID = $validated['stock_location_ids'][$index];
                        $modelPrice = $validated['model_price'][$index];
                        $modelQty = $validated['model_qty'][$index];

                        $existingIM = ImplantModel::where('implant_id', $id)->where('model_id', $modelID)->first();

                        if ($existingIM) {
                            $existingIM->update([
                                'implant_model_sn' => $modelSN,
                                'stock_location_id' => $stockLocationID,
                                'implant_model_itemPrice' => $modelPrice,
                                'implant_model_qty' => $modelQty
                            ]);
                        } else {
                            ImplantModel::create([
                                'implant_id' => $id,
                                'model_id' => $modelID,
                                'implant_model_sn' => $modelSN,
                                'stock_location_id' => $stockLocationID,
                                'implant_model_itemPrice' => $modelPrice,
                                'implant_model_qty' => $modelQty
                            ]);
                        }
                    }
                }
            }

            $updatedModelIDs = isset($validated['model_ids'])
                ? array_filter($validated['model_ids'], fn($id) => !is_null($id))
                : [];

            ImplantModel::where('implant_id', $id)->whereNotIn('model_id', $updatedModelIDs)->delete();

            DB::commit();

            /**** 04 - Implants Registration Form Generation ****/
            $this->generateIRF(Crypt::encrypt($implant->id));

            /**** 05 - Inventory Consumption Form Generation ****/
            $sbc = new SalesBillingController();
            $sbc->generatePreviewDownloadICF(Crypt::encrypt($implant->id), 2);

            return redirect()->route('manage-implant-page')->with('success', 'Implant updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating implant: ' . $e->getMessage());
        }
    }

    // GET APPROVAL TYPE - FUNCTION
    public function getApprovalType()
    {
        try {
            $approvalType = ApprovalType::all();
            return response()->json([
                'success' => true,
                'approvalType' => $approvalType
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error fetching approval type: ' . $e->getMessage()
            ], 500);
        }
    }

    // ADD APPROVAL TYPE - FUNCTION
    public function addApprovalType(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'approval_type_name' => 'required|string|unique:approval_types,approval_type_name',
        ], [], [
            'approval_type_name' => 'approval type name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $validated = $validator->validated();

            $type = ApprovalType::create([
                'approval_type_name' => $validated['approval_type_name'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Approval type added successfully.',
                'data' => $type
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding approval type: ' . $e->getMessage()
            ], 500);
        }
    }

    // DELETE APPROVAL TYPE - FUNCTION
    public function deleteApprovalType(Request $req)
    {
        try {
            $id = $req->input('id');

            ApprovalType::where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Approval type deleted successfully.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting approval type: ' . $e->getMessage()
            ], 500);
        }
    }

    // UPLOAD IRF - FUNCTION
    public function uploadBackupForm(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'implant_backup_form' => 'required|mimes:pdf',
        ], [], [
            'implant_backup_form' => 'implant backup form',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'uploadBackupModal-' . $id);
        }

        try {
            $implant = Implant::find($id);

            $hospital = Hospital::find($implant->hospital_id);
            $generator = Generator::find($implant->generator_id);

            if ($req->hasFile('implant_backup_form')) {
                $file = $req->file('implant_backup_form');
                $filename = $hospital->hospital_code . '_' . $generator->generator_code . '_' . strtoupper(Carbon::parse($implant->implant_date)->format('dMY')) . '_' .  strtoupper(preg_replace('/[^A-Za-z0-9]/', '_', $implant->implant_pt_name)) . '_BACKUP_IRF' . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('implants/' . $implant->implant_pt_directory, $filename, 'public');

                Implant::find($id)->update([
                    'implant_backup_form' => $path
                ]);

                return back()->with('success', 'File uploaded successfully!');
            }
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // GENERATE IRF - FUNCTION
    public function generateIRF($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $modelCategories = DB::table('model_categories')
                ->select('id as model_category_id', 'mcategory_name as model_category')
                ->where('mcategory_ismorethanone', 0)
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
                    'c.region_name',
                    DB::raw("GROUP_CONCAT(DISTINCT h.product_group_name ORDER BY h.id ASC SEPARATOR ', ') as product_groups"),
                    'e.doctor_name',
                    'e.doctor_phoneno',
                    'b.generator_name',
                    'b.generator_code',
                    'a.implant_generator_sn',
                    'a.implant_pt_name',
                    'a.implant_pt_directory',
                    'a.implant_sales_total_price',
                    'a.implant_pt_mrn',
                    'a.implant_pt_icno',
                    'a.implant_pt_address',
                    'a.implant_pt_phoneno',
                    'a.implant_pt_email',
                    'a.implant_pt_dob',
                ])
                ->groupBy(
                    'a.id',
                    'a.implant_date',
                    'a.implant_refno',
                    'd.hospital_name',
                    'd.hospital_phoneno',
                    'd.hospital_code',
                    'c.region_name',
                    'e.doctor_name',
                    'e.doctor_phoneno',
                    'b.generator_name',
                    'b.generator_code',
                    'a.implant_generator_sn',
                    'a.implant_pt_name',
                    'a.implant_pt_directory',
                    'a.implant_sales_total_price',
                    'a.implant_pt_mrn',
                    'a.implant_pt_icno',
                    'a.implant_pt_address',
                    'a.implant_pt_phoneno',
                    'a.implant_pt_email',
                    'a.implant_pt_dob',
                )
                ->first();

            $models = DB::table('implant_models as i')
                ->join('abbott_models as j', 'i.model_id', '=', 'j.id')
                ->join('model_categories as k', 'j.mcategory_id', '=', 'k.id')
                ->where('i.implant_id', $id)
                ->where('k.mcategory_ismorethanone', 0)
                ->select([
                    'k.id as model_category_id',
                    'k.mcategory_name as model_category',
                    'j.model_code',
                    'i.implant_model_sn'
                ])
                ->get();

            $mergedModels = [];
            foreach ($modelCategories as $category) {
                $foundModel = $models->firstWhere('model_category_id', $category->model_category_id);

                $mergedModels[] = [
                    'model_category_id' => $category->model_category_id,
                    'model_category' => $category->model_category,
                    'model_code' => $foundModel->model_code ?? '-',
                    'implant_model_sn' => $foundModel->implant_model_sn ?? '-'
                ];
            }

            $formattedData = [
                'id' => $implant->id ?? '-',
                'implant_date' => Carbon::parse($implant->implant_date)->format('d M Y') ?? '-',
                'today_date' => Carbon::now()->format('d M Y') ?? '-',
                'implant_refno' => $implant->implant_refno ?? '-',
                'hospital_name' => $implant->hospital_name ?? '-',
                'hospital_phoneno' => $implant->hospital_phoneno ?? '-',
                'hospital_code' => $implant->hospital_code ?? '-',
                'region_name' => $implant->region_name ?? '-',
                'product_groups' => $implant->product_groups ?? '-',
                'doctor_name' => $implant->doctor_name ?? '-',
                'doctor_phoneno' => $implant->doctor_phoneno ?? '-',
                'generator_name' => $implant->generator_name ?? '-',
                'generator_code' => $implant->generator_code ?? '-',
                'implant_generator_sn' => $implant->implant_generator_sn ?? '-',
                'implant_pt_name' => $implant->implant_pt_name ?? '-',
                'implant_pt_directory' => $implant->implant_pt_directory ?? '-',
                'implant_sales_total_price' => $implant->implant_sales_total_price ?? '-',
                'implant_pt_mrn' => $implant->implant_pt_mrn ?? '-',
                'implant_pt_icno' => $implant->implant_pt_icno ?? '-',
                'implant_pt_address' => $implant->implant_pt_address ?? '-',
                'implant_pt_phoneno' => $implant->implant_pt_phoneno ?? '-',
                'implant_pt_email' => $implant->implant_pt_email ?? '-',
                'implant_pt_dob' => Carbon::parse($implant->implant_pt_dob)->format('d M Y') ?? '-',
                'models' => $mergedModels,
            ];

            $title =  $formattedData['hospital_code'] . '_' . $formattedData['generator_code'] . '_' . strtoupper(Carbon::parse($formattedData['implant_date'])->format('dMY')) . '_' .  strtoupper(preg_replace('/[^A-Za-z0-9]/', '_', $formattedData['implant_pt_name'])) . '_SYS_IRF';

            $pdf = Pdf::loadView('crmd-system.implant-management.irf-template-doc', [
                'title' =>  $title ?? 'CRMD System | View Implant Registration Form',
                'im' => $formattedData

            ]);


            $filePath = 'storage/implants/' . $formattedData['implant_pt_directory'] . '/' . $title . '.pdf';
            return $pdf->save(public_path($filePath));
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // EXPORT EXCEL - FUNCTION
    public function exportExcelImplantData(Request $req)
    {
        try {
            $selectedIds = $req->query('ids');
            return Excel::download(new ImplantsExport($selectedIds), 'Implants_Data' . '_' . date('dMY') . '.xlsx');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // DOWNLOAD PATIENT DIRECTORY - FUNCTION
    public function downloadImplantDirectory($id)
    {
        try {
            $implant = Implant::find(Crypt::decrypt($id));

            if (!$implant || empty($implant->implant_pt_directory)) {
                return back()->with('error', 'Invalid implant directory.');
            }

            $imdir = public_path("storage/implants/" . $implant->implant_pt_directory);
            $zipFile = public_path("storage/implants/" . $implant->implant_pt_directory . ".zip");

            // Check if directory exists
            if (!File::exists($imdir) || !is_dir($imdir)) {
                return back()->with('error', 'Folder not found: ' . $imdir);
            }

            // Delete existing ZIP file if it exists
            if (File::exists($zipFile)) {
                File::delete($zipFile);
            }

            $zip = new ZipArchive;
            if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                return back()->with('error', 'Failed to create ZIP file.');
            }

            // Fetch all files in the directory
            $files = File::allFiles($imdir);

            if (empty($files)) {
                $zip->close();
                return back()->with('error', 'Folder is empty. No files to zip.');
            }

            foreach ($files as $file) {
                $relativePath = substr($file->getPathname(), strlen($imdir) + 1);
                $zip->addFile($file->getPathname(), $relativePath);
            }

            $zip->close();

            // Check if ZIP was created properly
            if (!File::exists($zipFile) || filesize($zipFile) === 0) {
                return back()->with('error', 'ZIP file is empty or corrupt.');
            }

            return response()->download($zipFile)->deleteFileAfterSend(true);
        } catch (Exception $e) {
            return back()->with('error', 'Error downloading implant directory: ' . $e->getMessage());
        }
    }

    // DOWNLOAD MULTIPLE PATIENT DIRECTORY - FUNCTION
    public function downloadMultipleImplantDirectory(Request $req)
    {
        try {
            $implantIds = json_decode($req->query('ids'), true);

            if (!$implantIds || count($implantIds) === 0) {
                return back()->with('error', 'No implants selected.');
            }

            // Create ZIP file
            $zipFile = storage_path('app/public/implants/CRMD_SELECTED_IMPLANTS.zip');

            if (File::exists($zipFile)) {
                File::delete($zipFile);
            }

            $zip = new ZipArchive;
            if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                return back()->with('error', 'Failed to create ZIP file.');
            }

            // Add each implant directory to the ZIP
            foreach ($implantIds as $id) {
                $implant = Implant::find($id);

                if (!$implant || empty($implant->implant_pt_directory)) {
                    continue;
                }

                $folderPath = public_path("storage/implants/" . $implant->implant_pt_directory);

                if (!File::exists($folderPath)) {
                    continue;
                }

                $files = File::allFiles($folderPath);

                foreach ($files as $file) {
                    $relativePath = $implant->implant_pt_directory . '/' . $file->getFilename();
                    $zip->addFile($file->getPathname(), $relativePath);
                }
            }

            $zip->close();

            return response()->download($zipFile)->deleteFileAfterSend(true);
        } catch (Exception $e) {
            return back()->with('error', 'Error generating ZIP: ' . $e->getMessage());
        }
    }

    // PREVIEW PATIENT ID CARD - FUNCTION
    public function previewPatientIDCard(Request $request, $id)
    {
        try {
            $modelCategories = DB::table('model_categories')
                ->select('id as model_category_id', 'mcategory_abbreviation as model_category')
                ->where('mcategory_isappear_incard', 1)
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
                    'b.generator_code',
                    'a.implant_generator_sn',
                    'a.implant_pt_name',
                    'a.implant_pt_directory',
                    'a.implant_pt_mrn',
                    'a.implant_pt_icno',
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
                    'b.generator_code',
                    'a.implant_generator_sn',
                    'a.implant_pt_name',
                    'a.implant_pt_directory',
                    'a.implant_pt_mrn',
                    'a.implant_pt_icno',
                )
                ->first();

            $models = DB::table('implant_models as i')
                ->join('abbott_models as j', 'i.model_id', '=', 'j.id')
                ->join('model_categories as k', 'j.mcategory_id', '=', 'k.id')
                ->where('i.implant_id', $id)
                ->where('k.mcategory_ismorethanone', 0)
                ->select([
                    'k.id as model_category_id',
                    'k.mcategory_name as model_category',
                    'j.model_code',
                    'i.implant_model_sn'
                ])
                ->get();

            $mergedModels = [];
            foreach ($modelCategories as $category) {
                $foundModel = $models->firstWhere('model_category_id', $category->model_category_id);

                $mergedModels[] = [
                    'model_category_id' => $category->model_category_id,
                    'model_category' => $category->model_category,
                    'model_code' => $foundModel->model_code ?? '-',
                    'implant_model_sn' => $foundModel->implant_model_sn ?? '-'
                ];
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
                'generator_code' => Str::upper($implant->generator_code) ?? '-',
                'implant_generator_sn' => $implant->implant_generator_sn ?? '-',
                'implant_pt_name' => Str::upper($implant->implant_pt_name) ?? '-',
                'implant_pt_directory' => $implant->implant_pt_directory ?? '-',
                'implant_pt_mrn' => $implant->implant_pt_mrn ?? '-',
                'implant_pt_icno' => $implant->implant_pt_icno ?? '-',
                'models' => $mergedModels,
            ];
            $opt = $request->opt ?? 0;
            $html = view('crmd-system.implant-management.card-generator', [
                'data' => $formattedData,
                'opt' => $opt
            ])->render();
            return response()->json(['html' => $html]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // SEND EMAIL - STRUCTURE
    private function sendPatientIDCardMail($data)
    {
        Mail::to($data['implant_pt_email'])->send(new PatientIDCardMail([
            'patient_name' => $data['implant_pt_name'],
            'implant_id' => $data['id'],
            'opt' => $data['opt'],
        ]));
    }

    // SEND PATIENT ID CARD VIA EMAIL - FUNCTION
    public function sendPatientIDCard(Request $req, $id)
    {
        $id = Crypt::decrypt($id);
        $validator = Validator::make($req->all(), [
            'implant_pt_email' => 'required|email',
            'card_type' => 'required|integer',

        ], [], [
            'implant_pt_email' => 'patient email',
            'card_type' => 'card type',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $validated = $validator->validated();
            $implant = Implant::find($id);

            $data = [
                'id' => $implant->id,
                'implant_date' => Carbon::parse($implant->implant_date)->format('d M Y') ?? '-',
                'implant_pt_name' => Str::headline($implant->implant_pt_name) ?? '-',
                'implant_pt_email' => $validated['implant_pt_email'],
                'opt' => $validated['card_type'],
            ];

            Implant::find($id)->update([
                'implant_pt_email' => $validated['implant_pt_email'],
                'implant_pt_id_card_design' => $validated['card_type']
            ]);

            $this->sendPatientIDCardMail($data);

            return redirect()->route('manage-implant-page')->with('success', 'Patient ID Card has been sent successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Oops! Something went wrong. Please try again.' . $e->getMessage());
        }
    }
}
