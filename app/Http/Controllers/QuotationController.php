<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use App\Models\Hospital;
use App\Models\Generator;
use App\Models\Quotation;
use App\Models\AbbottModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\QuoteGeneratorModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\Extension\SmartPunct\Quote;

class QuotationController extends Controller
{
    public function addAssignGeneratorModel(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'generator_id' => 'required|integer',
            'model_ids' => 'nullable|array',
        ], [], [
            'generator_id' => 'generator',
            'model_ids' => 'model',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addAssignmentModal');
        }

        try {

            $validated = $validator->validated();

            /**** 01 - Validate Generator & Model ****/
            $exist = QuoteGeneratorModel::where('generator_id', $validated['generator_id'])->first();
            if ($exist) {
                return redirect()->back()->with('error', 'Generator has already assigned.');
            }

            /**** 02 - Insert Generator and Model ****/
            if (!empty($validated['model_ids'])) {
                foreach ($validated['model_ids'] as $model_id) {
                    $am = AbbottModel::where('id', trim($model_id))->first();
                    if ($am) {
                        QuoteGeneratorModel::firstOrCreate([
                            'generator_id' => $validated['generator_id'],
                            'model_id' => $am->id
                        ]);
                    }
                }
            }

            return back()->with('success', 'Successfully assign generator and model.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to add assignment: ' . $e->getMessage());
        }
    }

    public function updateAssignGeneratorModel(Request $req, $generator_id)
    {
        $generator_id = Crypt::decrypt($generator_id);

        $validator = Validator::make($req->all(), [
            'model_ids' => 'nullable|array',
        ], [], [
            'model_ids' => 'model',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateAssignmentModal-' . $generator_id);
        }

        try {
            $validated = $validator->validated();

            /**** 01 - Validate Generator Exists ****/
            $exist = QuoteGeneratorModel::where('generator_id', $generator_id)->first();
            if (!$exist) {
                return redirect()->back()->with('error', 'Generator does not exist.');
            }

            /**** 02 - Delete Old Assignments ****/
            QuoteGeneratorModel::where('generator_id', $generator_id)->delete();

            /**** 03 - Insert New Assignments ****/
            if (!empty($validated['model_ids'])) {
                foreach ($validated['model_ids'] as $model_id) {
                    $am = AbbottModel::where('id', trim($model_id))->first();
                    if ($am) {
                        QuoteGeneratorModel::firstOrCreate([
                            'generator_id' => $generator_id,
                            'model_id' => $am->id,
                        ]);
                    }
                }
            }

            return back()->with('success', 'Successfully updated generator and model assignment.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update assignment: ' . $e->getMessage());
        }
    }

    public function deleteAssignGeneratorModel($generator_id)
    {
        $generator_id = Crypt::decrypt($generator_id);

        try {

            /**** 01 - Validate Generator Exists ****/
            $exist = QuoteGeneratorModel::where('generator_id', $generator_id)->first();
            if (!$exist) {
                return redirect()->back()->with('error', 'Generator does not exist.');
            }

            /**** 02 - Delete Old Assignments ****/
            QuoteGeneratorModel::where('generator_id', $generator_id)->delete();

            return back()->with('success', 'Successfully deleted generator and model assignment.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update assignment: ' . $e->getMessage());
        }
    }

    public function addCompany(Request $req)
    {
        // 1. Validate inputs
        $validator = Validator::make($req->all(), [
            'company_name'     => 'required|string',
            'company_code'     => 'required|string|unique:companies,company_code',
            'company_ssm'      => 'required|string',
            'company_address'  => 'required|string',
            'company_phoneno'  => 'nullable|string',
            'company_fax'      => 'nullable|string',
            'company_website'  => 'nullable|string',
            'company_email'    => 'nullable|string|email',
            'company_logo'     => 'required',
        ], [], [
            'company_name'     => 'company name',
            'company_code'     => 'company code',
            'company_ssm'      => 'company registration no',
            'company_address'  => 'company address',
            'company_phoneno'  => 'company phone number',
            'company_fax'      => 'company fax',
            'company_website'  => 'company website',
            'company_email'    => 'company email',
            'company_logo'     => 'company logo',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addCompanyModal');
        }

        try {
            $validated = $validator->validated();

            // 2. Handle logo upload
            if ($req->hasFile('company_logo')) {
                $file = $req->file('company_logo');
                $filename = Str::lower($validated['company_code']) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('public/quotation/company', $filename);

                $validated['company_logo'] = $path;
            }


            // 3. Save to database
            Company::create($validated);

            return back()->with('success', 'Successfully added company.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to add company: ' . $e->getMessage());
        }
    }

    public function updateCompany(Request $req, $id)
    {
        $id = Crypt::decrypt($id);

        $company = Company::findOrFail($id);

        // Validation
        $validator = Validator::make($req->all(), [
            'company_name_up'     => 'required|string',
            'company_code_up'     => 'required|string|unique:companies,company_code,' . $id,
            'company_ssm_up'      => 'required|string',
            'company_address_up'  => 'required|string',
            'company_phoneno_up'  => 'nullable|string',
            'company_fax_up'      => 'nullable|string',
            'company_website_up'  => 'nullable|string',
            'company_email_up'    => 'nullable|string|email',
            'company_logo_up'     => 'nullable',
        ], [], [
            'company_name_up'     => 'company name',
            'company_code_up'     => 'company code',
            'company_ssm_up'      => 'company registration no',
            'company_address_up'  => 'company address',
            'company_phoneno_up'  => 'company phone number',
            'company_fax_up'      => 'company fax',
            'company_website_up'  => 'company website',
            'company_email_up'    => 'company email',
            'company_logo_up'     => 'company logo',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateCompanyModal-' . $id);
        }

        try {
            $validated = $validator->validated();

            // Handle logo upload if present
            if ($req->hasFile('company_logo_up')) {
                $file = $req->file('company_logo_up');
                $filename = Str::lower($validated['company_code_up']) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('public/quotation/company', $filename);

                $company->company_logo = $path;
            }

            // Update company details
            $company->company_name     = $validated['company_name_up'];
            $company->company_code     = $validated['company_code_up'];
            $company->company_ssm      = $validated['company_ssm_up'];
            $company->company_address  = $validated['company_address_up'] ?? null;
            $company->company_phoneno  = $validated['company_phoneno_up'] ?? null;
            $company->company_fax      = $validated['company_fax_up'] ?? null;
            $company->company_website  = $validated['company_website_up'] ?? null;
            $company->company_email    = $validated['company_email_up'] ?? null;

            $company->save();

            return back()->with('success', 'Successfully updated company.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update company: ' . $e->getMessage());
        }
    }

    public function deleteCompany($id)
    {
        try {
            $id = Crypt::decrypt($id);

            $company = Company::findOrFail($id);

            if ($company->company_logo && Storage::exists($company->company_logo)) {
                Storage::delete($company->company_logo);
            }

            $company->delete();

            return redirect()->back()->with('success', 'Company deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the company: ' . $e->getMessage());
        }
    }

    public function getModelList($generatorid)
    {
        try {
            $data = DB::table('quote_generator_models as qgm')
                ->join('abbott_models as am', 'qgm.model_id', '=', 'am.id')
                ->select('qgm.generator_id', 'am.*')
                ->where('qgm.generator_id', $generatorid)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error getting model list:' . $e->getMessage()], 500);
        }
    }

    public function viewEditableQuotation(Request $req)
    {
        try {
            $quotation = null;
            $company = $req->input('company');
            $generatorid = $req->input('generatorid');
            $hospitalid = $req->input('hospitalid');
            $refno = $req->input('refno');


            if ($req->has('quotationid')) {
                $quotation = Quotation::where('id', $req->input('quotationid'))->first();
                if ($quotation) {
                    $metadata = json_decode($quotation->quotation_metadata, true) ?? [];

                    // Override company and IDs from metadata if available
                    $company = $quotation->quotation_template ?? $company;
                    $generatorid = $metadata['generator_id'] ?? $generatorid;
                    $hospitalid = $quotation->hospital_id ?? $hospitalid;
                    $refno = $quotation->quotation_refno ?? $refno;
                }
            }

            // Ensure generatorid is present before querying
            if (!$generatorid) {
                return response()->json(['error' => 'Missing generator ID'], 400);
            }

            $generatorModel = DB::table('quote_generator_models as qgm')
                ->join('abbott_models as am', 'qgm.model_id', '=', 'am.id')
                ->where('qgm.generator_id', $generatorid)
                ->select('am.*')
                ->get();

            $generator = Generator::find($generatorid);
            $hospital = Hospital::find($hospitalid);

            $html = view('crmd-system.quotation.quotation-editable-doc', [
                'title' => 'Quotation-Document',
                'company' => $company,
                'generatorModel' => $generatorModel,
                'generator' => $generator,
                'hospital' => $hospital,
                'hospitals' => Hospital::all(),
                'generators' => Generator::all(),
                'refno' => $refno,
                'quotation' => $quotation
            ])->render();

            return response()->json(['html' => $html]);
        } catch (Exception $e) {
            report($e);
            return response()->json(['error' => 'Failed to load editable quotation: ' . $e->getMessage()], 500);
        }
    }

    public function addQuotation(Request $req)
    {
        DB::beginTransaction();

        try {
            // Extract main fields
            $quotation = new Quotation();
            $quotation->quotation_date = Carbon::parse($req->quotation_date)->format('Y-m-d');
            $quotation->quotation_price = (float) $req->quotation_totalprice;
            $quotation->quotation_pt_name = $req->quotation_pt_name;
            $quotation->quotation_pt_icno = $req->quotation_pt_icno;
            $quotation->company_id = $req->company_id;
            $quotation->hospital_id = $req->hospital_id;
            $quotation->staff_id = auth()->user()->id;

            // Remove known fields and _token to get the rest for JSON
            $excluded = [
                '_token',
                'quotation_date',
                'quotation_totalprice',
                'quotation_pt_name',
                'quotation_pt_icno',
                'quotation_template',
                'quotation_refno',
                'hospital_id',
                'staff_id',
            ];

            $metadata = collect($req->except($excluded));
            $quotation->quotation_metadata = $metadata;


            $company = Company::where('id', $req->company_id)->first();
            $hospital = Hospital::where('id', $req->hospital_id)->first();
            $generator = Generator::where('id', $req->generator_id)->first();
            $year = date('Y');

            $refno = null;

            if ($company && $hospital && $generator) {
                // 1. Build prefix
                $refPrefix = $company->company_code . '/' . $hospital->hospital_code . '/' . $generator->generator_code . '/' . $year;

                // 2. Query for the latest refno with that prefix
                $latest = DB::table('quotations')
                    ->where('quotation_refno', 'LIKE', $refPrefix . '/%')
                    ->orderBy('quotation_refno', 'desc')
                    ->first();

                // 3. Extract sequence number
                if ($latest) {
                    // Extract last 3 digits from the refno (sequence)
                    $parts = explode('/', $latest->quotation_refno);
                    $lastSequence = intval(end($parts));
                    $newSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
                } else {
                    $newSequence = '001';
                }

                // 4. Final refno
                $refno = $refPrefix . '/' . $newSequence;
            }

            $quotation->quotation_refno = $refno;
            $quotation->save();

            DB::commit();

            return redirect()->route('manage-quotation-page')
                ->with('success', 'Successfully added quotation.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to add quotation: ' . $e->getMessage());
        }
    }

    public function updateQuotation(Request $req, $id)
    {
        DB::beginTransaction();

        $id = Crypt::decrypt($id);

        try {
            // Find the existing quotation
            $quotation = Quotation::where('id', $id)->firstOrFail();

            // Update standard fields
            $quotation->quotation_date = Carbon::parse($req->quotation_date)->format('Y-m-d');
            $quotation->quotation_price = (float) $req->quotation_totalprice;
            $quotation->quotation_pt_name = $req->quotation_pt_name;
            $quotation->quotation_pt_icno = $req->quotation_pt_icno;
            $quotation->quotation_template = $req->quotation_template;
            $quotation->quotation_refno = $req->quotation_refno;
            $quotation->hospital_id = $req->hospital_id;
            $quotation->staff_id = $req->staff_id;

            // Remove known fields and _token to capture metadata
            $excluded = [
                '_token',
                'quotation_date',
                'quotation_totalprice',
                'quotation_pt_name',
                'quotation_pt_icno',
                'quotation_template',
                'quotation_refno',
                'hospital_id',
                'staff_id',
            ];

            // Extract remaining fields as metadata
            $metadata = collect($req->except($excluded));
            $quotation->quotation_metadata = $metadata;

            $quotation->save();
            DB::commit();

            return redirect()->back()
                ->with('success', 'Successfully updated quotation.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update quotation: ' . $e->getMessage());
        }
    }

    // QUOTATION HANDLER - FUNCTION [WIP]
    // NOTES : [1] -> VIEW [2] -> GENERATE [3] -> DOWNLOAD
    public function generatePreviewDownloadQuoatation($id, $opt)
    {
        try {
            $id = Crypt::decrypt($id);

            $quotation = Quotation::where('id', $id)->first();
            $hospital = Hospital::where('id', $quotation->hospital_id)->first();
            $company = Company::where('id', $hospital->company_id)->first();
            $user = User::where('id', $quotation->staff_id)->first();

            $metadata = json_decode($quotation->quotation_metadata);
            $generator = Generator::where('id', $metadata->generator_id)->first();
            $modellist = DB::table('quote_generator_models as qgm')
                ->join('abbott_models as am', 'qgm.model_id', '=', 'am.id')
                ->select('qgm.generator_id', 'am.model_code', 'am.model_name')
                ->where('qgm.generator_id', $generator->id)
                ->get();


            $formattedData = [
                'quotation_date' => $quotation->quotation_date,
                'quotation_totalprice' => $quotation->quotation_price,
                'quotation_pt_name' => $quotation->quotation_pt_name,
                'quotation_pt_icno' => $quotation->quotation_pt_icno,
                'quotation_refno' => $quotation->quotation_refno,
                'quotation_unitprice' => $metadata->quotation_unitprice,
                'quotation_qty' => $metadata->quotation_qty,
                'quotation_subject' => $metadata->quotation_subject,
                'quotation_attn' => $metadata->quotation_attn,
                'company_name' => $company->company_name,
                'company_ssm' => $company->company_ssm,
                'company_address' => $company->company_address,
                'company_website' => $company->company_website,
                'company_phoneno' => $company->company_phoneno,
                'company_fax' => $company->company_fax,
                'company_email' => $company->company_email,
                'company_logo' => $company->company_logo,
                'hospital_name' => $hospital->hospital_name,
                'hospital_address' => $hospital->hospital_address,
                'user_name' => $user->staff_name,
            ];

            $title = $quotation->quotation_refno;


            $pdf = Pdf::loadView('crmd-system.quotation.quotation-template-doc', [
                'title' => $formattedData['quotation_refno'],
                'data' => $formattedData,
            ])
                ->setOption('isRemoteEnabled', true)
                ->setOption('defaultPaperSize', 'a4')
                ->setOption('isPhpEnabled', true)
                ->setPaper('a4', 'landscape');

            if ($opt == 1) {
                // VIEW PDF
                return $pdf->stream($title . '.pdf');
            } elseif ($opt == 2) {
                // SAVE TO STORAGE
                // $filePath = 'quotation/document/' . $formattedData['implant_pt_directory'] . '/' . $title . '.pdf';


                // return $pdf->save(public_path("storage/{$filePath}"));
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
}
