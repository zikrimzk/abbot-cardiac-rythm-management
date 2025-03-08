<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Implant;
use App\Models\Hospital;
use App\Models\AbbottModel;
use App\Models\ImplantModel;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use App\Models\ProductGroupList;
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
            'implant_pt_icno' => 'required|min:12|max:15|string',
            'implant_pt_mrn' => 'nullable|string',
            'implant_pt_directory' => 'nullable|string',
            'implant_generator_sn' => 'required|string',
            'implant_invoice_no' => 'nullable|string',
            'implant_sales' => 'required|integer',
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
            //Create Custom Implant Code
            $implantcode = Carbon::parse($validated['implant_date'])->format('dmY') . '_' . strtoupper(str_replace(' ', '_', $validated['implant_pt_name']));

            //Create Directory
            $sequenceNumber = str_pad(Implant::count() + 1, 3, '0', STR_PAD_LEFT);
            $hospital_code = Hospital::find($validated['hospital_id'])->hospital_code ?? 'H0000';
            $implantdirectory = $sequenceNumber . '_' . Carbon::parse($validated['implant_date'])->format('d.m.Y') . '_' . strtoupper(str_replace(' ', '_', $validated['implant_pt_name'])) . '_' . strtoupper($hospital_code);
            Storage::makeDirectory('implants/' . $implantdirectory);

            //Assign Values
            $validated['implant_code'] = $implantcode;
            $validated['implant_pt_directory'] = $implantdirectory;

            //Store Implant
            Implant::create($validated);

            //Get Implant ID
            $implantID = Implant::where('implant_code', $validated['implant_code'])->first()->id;

            /**** 02 - Product Groups ****/
            //Store Each Product Groups
            if (isset($validated['product_groups'])) {
                foreach ($validated['product_groups'] as $product_group) {
                    $pgID = ProductGroup::where('product_group_name', $product_group)->first()->id;
                    ProductGroupList::create([
                        'implant_id' => $implantID,
                        'product_group_id' => $pgID
                    ]);
                }
            }

            /**** 03 - Implants X Model ****/
            //Store Each Model
            if (isset($validated['model_ids'], $validated['model_sns'], $validated['stock_location_ids'])) {
                foreach ($validated['model_ids'] as $index => $model) {
                    
                    if (isset($validated['model_sns'][$index], $validated['stock_location_ids'][$index])) {

                        $modelID = AbbottModel::where('id', $model)->first()->id ?? null;
                        $stockLocationID = $validated['stock_location_ids'][$index] ?? null;
                        $modelSN = $validated['model_sns'][$index] ?? null;

                        ImplantModel::create([
                            'implant_id' => $implantID,
                            'model_id' => $modelID,
                            'stock_location_id' => $stockLocationID,
                            'implant_model_sn' => $modelSN
                        ]);
                    }
                }
            }


            return redirect()->route('manage-implant-page')->with('success', 'Implant added successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
