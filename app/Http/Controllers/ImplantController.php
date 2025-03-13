<?php

namespace App\Http\Controllers;

use Exception;
use ZipArchive;
use Carbon\Carbon;
use App\Models\Implant;
use App\Models\Hospital;
use App\Models\Generator;
use App\Models\AbbottModel;
use App\Models\ImplantModel;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use App\Exports\ImplantsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ProductGroupList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImplantController extends Controller
{
    //Manage Implant Function
    public function addImplant(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'implant_code' => 'nullable|string',
            'implant_date' => 'required|date',
            'implant_pt_name' => 'required|string',
            'implant_pt_icno' => 'required|min:7|max:15|string',
            'implant_pt_mrn' => 'nullable|string',
            'implant_pt_address' => 'nullable|string',
            'implant_pt_email' => 'nullable|email',
            'implant_pt_phoneno' => 'nullable|string',
            'implant_pt_dob' => 'nullable|string',
            'implant_pt_directory' => 'nullable|string',
            'implant_generator_sn' => 'required|string',
            'implant_invoice_no' => 'nullable|string',
            'implant_sales' => 'required|numeric',
            'implant_remark' => 'nullable|string',
            'implant_note' => 'nullable|string',
            'implant_approval_type' => 'nullable|string',
            'generator_id' => 'required|integer',
            'region_id' => 'required|integer',
            'hospital_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'stock_location_id' => 'required|integer',
            'product_groups' => 'required|array',
            'model_ids' => 'nullable|array',
            'model_sns' => 'nullable|array',
            'stock_location_ids' => 'nullable|array',
        ], [], [
            'implant_code' => 'implant code',
            'implant_date' => 'implant date',
            'implant_pt_name' => 'patient name',
            'implant_pt_icno' => 'patient ic number',
            'implant_pt_mrn' => 'patient mrn',
            'implant_pt_address' => 'patient address',
            'implant_pt_email' => 'patient email',
            'implant_pt_phoneno' => 'patient phone number',
            'implant_pt_dob' => 'patient date of birth',
            'implant_pt_directory' => 'patient directory',
            'implant_generator_sn' => 'generator serial number',
            'implant_invoice_no' => 'implant invoice number',
            'implant_sales' => 'implant sales',
            'implant_remark' => 'remarks',
            'implant_note' => 'notes',
            'implant_approval_type' => 'implant approval type',
            'generator_id' => 'generator',
            'region_id' => 'region',
            'hospital_id' => 'hospital',
            'doctor_id' => 'doctor',
            'stock_location_id' => 'stock location',
            'product_groups' => 'product group',
            'model_ids' => 'model',
            'model_sns' => 'model serial number',
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
            $implantdirectory = "{$sequenceNumber}_" . Carbon::parse($validated['implant_date'])->format('d.m.Y') . '_' . strtoupper(str_replace(' ', '_', $validated['implant_pt_name'])) . "_{$hospital_code}";

            Storage::makeDirectory("public/implants/{$implantdirectory}");

            // Assign Values
            $validated['implant_code'] = $implantcode;
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
            if (!empty($validated['model_ids']) && !empty($validated['model_sns']) && !empty($validated['stock_location_ids'])) {
                foreach ($validated['model_ids'] as $index => $model) {
                    if (!isset($validated['model_sns'][$index], $validated['stock_location_ids'][$index])) {
                        continue;
                    }

                    $modelID = optional(AbbottModel::find($model))->id;
                    $stockLocationID = $validated['stock_location_ids'][$index] ?? null;
                    $modelSN = $validated['model_sns'][$index] ?? null;

                    if ($modelID && $stockLocationID && $modelSN) {
                        ImplantModel::firstOrCreate([
                            'implant_id' => $implant->id,
                            'model_id' => $modelID,
                            'stock_location_id' => $stockLocationID,
                            'implant_model_sn' => $modelSN
                        ]);
                    }
                }
            }

            /**** 04 - Implants Registration Form Generation ****/
            $this->generateIRF(Crypt::encrypt($implant->id));

            return redirect()->route('manage-implant-page')->with('success', 'Implant added successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateImplant(Request $req, $id)
    {
        $id = Crypt::decrypt($id);
        $validator = Validator::make($req->all(), [
            'implant_code' => 'nullable|string',
            'implant_date' => 'required|date',
            'implant_pt_name' => 'required|string',
            'implant_pt_icno' => 'required|min:7|max:15|string',
            'implant_pt_mrn' => 'nullable|string',
            'implant_pt_address' => 'nullable|string',
            'implant_pt_email' => 'nullable|email',
            'implant_pt_phoneno' => 'nullable|string',
            'implant_pt_dob' => 'nullable|string',
            'implant_pt_directory' => 'nullable|string',
            'implant_generator_sn' => 'required|string',
            'implant_invoice_no' => 'nullable|string',
            'implant_sales' => 'required||numeric',
            'implant_remark' => 'nullable|string',
            'implant_note' => 'nullable|string',
            'implant_approval_type' => 'nullable|string',
            'generator_id' => 'required|integer',
            'region_id' => 'required|integer',
            'hospital_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'stock_location_id' => 'required|integer',
            'product_groups' => 'nullable|array',
            'model_ids' => 'nullable|array',
            'model_sns' => 'nullable|array',
            'stock_location_ids' => 'nullable|array',
        ], [], [
            'implant_code' => 'implant code',
            'implant_date' => 'implant date',
            'implant_pt_name' => 'patient name',
            'implant_pt_icno' => 'patient ic number',
            'implant_pt_mrn' => 'patient mrn',
            'implant_pt_address' => 'patient address',
            'implant_pt_email' => 'patient email',
            'implant_pt_phoneno' => 'patient phone number',
            'implant_pt_dob' => 'patient date of birth',
            'implant_pt_directory' => 'patient directory',
            'implant_generator_sn' => 'generator serial number',
            'implant_invoice_no' => 'implant invoice number',
            'implant_sales' => 'implant sales',
            'implant_remark' => 'remarks',
            'implant_note' => 'notes',
            'implant_approval_type' => 'implant approval type',
            'generator_id' => 'generator',
            'region_id' => 'region',
            'hospital_id' => 'hospital',
            'doctor_id' => 'doctor',
            'stock_location_id' => 'stock location',
            'product_groups' => 'product group',
            'model_ids' => 'model',
            'model_sns' => 'model serial number',
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
            $implant = Implant::findOrFail($id);

            /**** 01 - Update Implant Code & Directory ****/
            $oldDirectory = $implant->implant_pt_directory;
            $newImplantCode = 'IMP' . str_pad($implant->id, 3, '0', STR_PAD_LEFT) . Carbon::parse($validated['implant_date'])->format('dmY');
            $sequenceNumber = str_pad($implant->id, 3, '0', STR_PAD_LEFT);
            $hospital_code = Hospital::find($validated['hospital_id'])->hospital_code ?? 'H0000';
            $newDirectory = $sequenceNumber . '_' . Carbon::parse($validated['implant_date'])->format('d.m.Y') . '_' . strtoupper(str_replace(' ', '_', $validated['implant_pt_name'])) . '_' . strtoupper($hospital_code);

            if ($oldDirectory !== $newDirectory) {
                Storage::move('public/implants/' . $oldDirectory, 'public/implants/' . $newDirectory);
            } else {
                Storage::makeDirectory('public/implants/' . $newDirectory);
            }

            $implant->update([
                'implant_code' => $newImplantCode,
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
                'implant_invoice_no' => $validated['implant_invoice_no'],
                'implant_sales' => $validated['implant_sales'],
                'implant_remark' => $validated['implant_remark'],
                'implant_note' => $validated['implant_note'],
                'implant_approval_type' => $validated['implant_approval_type'],
                'generator_id' => $validated['generator_id'],
                'region_id' => $validated['region_id'],
                'hospital_id' => $validated['hospital_id'],
                'doctor_id' => $validated['doctor_id'],
                'stock_location_id' => $validated['stock_location_id']
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
            if (isset($validated['model_ids'], $validated['model_sns'], $validated['stock_location_ids'])) {
                foreach ($validated['model_ids'] as $index => $modelID) {
                    if (isset($validated['model_sns'][$index], $validated['stock_location_ids'][$index])) {
                        $modelSN = $validated['model_sns'][$index];
                        $stockLocationID = $validated['stock_location_ids'][$index];

                        $existingIM = ImplantModel::where('implant_id', $id)->where('model_id', $modelID)->first();

                        if ($existingIM) {
                            $existingIM->update([
                                'implant_model_sn' => $modelSN,
                                'stock_location_id' => $stockLocationID
                            ]);
                        } else {
                            ImplantModel::create([
                                'implant_id' => $id,
                                'model_id' => $modelID,
                                'implant_model_sn' => $modelSN,
                                'stock_location_id' => $stockLocationID
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

            return redirect()->route('manage-implant-page')->with('success', 'Implant updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating implant: ' . $e->getMessage());
        }
    }

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

        $implant = Implant::find($id);

        $hospital = Hospital::find($implant->hospital_id);
        $generator = Generator::find($implant->generator_id);

        if ($req->hasFile('implant_backup_form')) {
            $file = $req->file('implant_backup_form');
            $filename = $hospital->hospital_code . '_' . $generator->generator_code . '_' . strtoupper(Carbon::parse($implant->implant_date)->format('dMY')) . '_' .  strtoupper(str_replace(' ', '_', $implant->implant_pt_name)) . '_BACKUP_IRF' . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('implants/' . $implant->implant_pt_directory, $filename, 'public');

            Implant::find($id)->update([
                'implant_backup_form' => $path
            ]);

            return back()->with('success', 'File uploaded successfully!');
        }
    }

    public function generateIRF($id)
    {
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
                'a.implant_code',
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
                'a.implant_invoice_no',
                'a.implant_sales',
                'a.implant_quantity',
                'a.implant_remark',
                'a.implant_pt_mrn',
                'a.implant_pt_icno',
                'a.implant_pt_address',
                'a.implant_pt_phoneno',
                'a.implant_pt_email',
                'a.implant_pt_dob',
                'a.implant_note'
            ])
            ->groupBy(
                'a.id',
                'a.implant_date',
                'a.implant_code',
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
                'a.implant_invoice_no',
                'a.implant_sales',
                'a.implant_quantity',
                'a.implant_remark',
                'a.implant_pt_mrn',
                'a.implant_pt_icno',
                'a.implant_pt_address',
                'a.implant_pt_phoneno',
                'a.implant_pt_email',
                'a.implant_pt_dob',
                'a.implant_note'
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
            'implant_code' => $implant->implant_code ?? '-',
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
            'implant_invoice_no' => $implant->implant_invoice_no ?? '-',
            'implant_sales' => $implant->implant_sales ?? '-',
            'implant_quantity' => $implant->implant_quantity ?? '-',
            'implant_remark' => $implant->implant_remark ?? '-',
            'implant_pt_mrn' => $implant->implant_pt_mrn ?? '-',
            'implant_pt_icno' => $implant->implant_pt_icno ?? '-',
            'implant_pt_address' => $implant->implant_pt_address ?? '-',
            'implant_pt_phoneno' => $implant->implant_pt_phoneno ?? '-',
            'implant_pt_email' => $implant->implant_pt_email ?? '-',
            'implant_pt_dob' => Carbon::parse($implant->implant_pt_dob)->format('d M Y') ?? '-',
            'implant_note' => $implant->implant_note ?? '-',
            'models' => $mergedModels,
        ];

        $title =  $formattedData['hospital_code'] . '_' . $formattedData['generator_code'] . '_' . strtoupper(Carbon::parse($formattedData['implant_date'])->format('dMY')) . '_' .  strtoupper(str_replace(' ', '_', $formattedData['implant_pt_name'])) . '_SYS_IRF';

        $pdf = Pdf::loadView('crmd-system.implant-management.view-irf-document', [
            'title' =>  $title ?? 'CRMD System | View Implant Registration Form',
            'im' => $formattedData

        ]);


        $filePath = 'storage/implants/' . $formattedData['implant_pt_directory'] . '/' . $title . '.pdf';
        return $pdf->save(public_path($filePath));
    }

    public function exportExcelImplantData()
    {
        return Excel::download(new ImplantsExport, 'Implants_Data' . '_' . date('dMY') . '.xlsx');
    }

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
}
