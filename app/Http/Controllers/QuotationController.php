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
use App\Models\Designation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\QuoteGeneratorModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\Extension\SmartPunct\Quote;

class QuotationController extends Controller
{

    // ADD ASSIGN GENERATOR MODEL - FUNCTION
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

    // UPDATE ASSIGNMENT GENERATOR MODEL - FUNCTION
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

    // DELETE ASSIGNMENT GENERATOR MODEL - FUNCTION
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

    // ADD COMPANY - FUNCTION
    public function addCompany(Request $req)
    {
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

            /**** 01 - Handle Logo Upload ****/
            if ($req->hasFile('company_logo')) {
                $file = $req->file('company_logo');
                $filename = Str::lower($validated['company_code']) . '.' . $file->getClientOriginalExtension();

                // Move file directly into public/uploads/company-logo
                $file->move(public_path('uploads/company-logo'), $filename);

                // Save relative path for later use
                $validated['company_logo'] = 'uploads/company-logo/' . $filename;
            }

            /**** 02 - Insert Data Into Company ****/
            Company::create($validated);

            return back()->with('success', 'Successfully added company.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to add company: ' . $e->getMessage());
        }
    }

    // UPDATE COMPANY - FUNCTION
    public function updateCompany(Request $req, $id)
    {

        /**** 01 - Decrypt ID & Get Company ****/
        $id = Crypt::decrypt($id);
        $company = Company::findOrFail($id);
        if (!$company) {
            return abort(404, 'Company not found');
        }

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

            /**** 02 - Handle Logo Upload ****/
            if ($req->hasFile('company_logo_up')) {
                $file = $req->file('company_logo_up');
                $filename = Str::lower($validated['company_code_up']) . '.' . $file->getClientOriginalExtension();

                // Move file directly into public/uploads/company-logo
                $file->move(public_path('uploads/company-logo'), $filename);

                // Save relative path for later use
                $company->company_logo = 'uploads/company-logo/' . $filename;
            }

            /**** 03 - Assign Company Data ****/
            $company->company_name     = $validated['company_name_up'];
            $company->company_code     = $validated['company_code_up'];
            $company->company_ssm      = $validated['company_ssm_up'];
            $company->company_address  = $validated['company_address_up'] ?? null;
            $company->company_phoneno  = $validated['company_phoneno_up'] ?? null;
            $company->company_fax      = $validated['company_fax_up'] ?? null;
            $company->company_website  = $validated['company_website_up'] ?? null;
            $company->company_email    = $validated['company_email_up'] ?? null;

            /**** 04 - Update Company Data ****/
            $company->save();

            return back()->with('success', 'Successfully updated company.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update company: ' . $e->getMessage());
        }
    }

    // DELETE COMPANY - FUNCTION
    public function deleteCompany($id)
    {
        try {
            /**** 01 - Decrypt ID & Get Company ****/
            $id = Crypt::decrypt($id);
            $company = Company::findOrFail($id);
            if (!$company) {
                return abort(404, 'Company not found');
            }

            /**** 02 - Delete Company Logo ****/
            if ($company->company_logo) {
                $logoPath = public_path($company->company_logo);

                if (file_exists($logoPath)) {
                    unlink($logoPath); // delete file physically
                }
            }


            /**** 03 - Delete Company Data ****/
            $company->delete();

            return redirect()->back()->with('success', 'Company deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the company: ' . $e->getMessage());
        }
    }

    // ADD QUOTATION - FUNCTION
    public function addQuotation(Request $req)
    {
        DB::beginTransaction();

        try {

            /**** 01 - Assign Data ****/
            $quotation = new Quotation();
            $quotation->quotation_date = Carbon::parse($req->quotation_date)->format('Y-m-d');
            $quotation->quotation_price = (float) $req->quotation_totalprice;
            $quotation->quotation_pt_name = $req->quotation_pt_name;
            $quotation->quotation_pt_icno = $req->quotation_pt_icno;
            $quotation->approver_id = $req->approver_id;
            $quotation->company_id = $req->company_id;
            $quotation->hospital_id = $req->hospital_id;
            $quotation->staff_id = auth()->user()->id;

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


            /**** 02 - Handle Quotation Refno ****/
            $company = Company::where('id', $req->company_id)->first();
            $hospital = Hospital::where('id', $req->hospital_id)->first();
            $generator = Generator::where('id', $req->generator_id)->first();
            $year = date('Y');

            $refno = null;

            if ($company && $hospital && $generator) {

                $refPrefix = $company->company_code . '/' . $hospital->hospital_code . '/' . $generator->generator_code . '/' . $year;

                $latest = DB::table('quotations')
                    ->where('quotation_refno', 'LIKE', $refPrefix . '/%')
                    ->orderBy('quotation_refno', 'desc')
                    ->first();

                if ($latest) {
                    $parts = explode('/', $latest->quotation_refno);
                    $lastSequence = intval(end($parts));
                    $newSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
                } else {
                    $newSequence = '001';
                }

                $refno = $refPrefix . '/' . $newSequence;
            }

            $quotation->quotation_refno = $refno;

            /**** 03 - Insert Data Into Quotation ****/
            $quotation->save();

            /**** 04 - Save Generated Quotation ****/
            $this->generatePreviewDownloadQuotation(Crypt::encrypt($quotation->id), 2);

            DB::commit();

            return redirect()->route('view-quotation-get', ['id' => Crypt::encrypt($quotation->id)])
                ->with('success', 'Successfully saved quotation details. Please review the quotation.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to add quotation: ' . $e->getMessage());
        }
    }

    // UPDATE QUOTATION - FUNCTION
    public function updateQuotation(Request $req, $id)
    {
        DB::beginTransaction();

        try {

            /**** 01 - Decrypt ID & Get Quotation ****/
            $id = Crypt::decrypt($id);
            $quotation = Quotation::findOrFail($id);

            if (!$quotation) {
                return abort(404, 'Quotation not found');
            }

            /**** 02 - Assign Data ****/
            $quotation->quotation_date = Carbon::parse($req->quotation_date)->format('Y-m-d');
            $quotation->quotation_price = (float) $req->quotation_totalprice;
            $quotation->quotation_pt_name = $req->quotation_pt_name;
            $quotation->quotation_pt_icno = $req->quotation_pt_icno;
            $quotation->company_id = $req->company_id;
            $quotation->hospital_id = $req->hospital_id;
            $quotation->approver_id = $req->approver_id;

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

            /**** 03 - Handle Quotation Refno [NOT IN USE] ****/
            // $company = Company::find($req->company_id);
            // $hospital = Hospital::find($req->hospital_id);
            // $generator = Generator::find($req->generator_id);
            // $year = date('Y');

            // if ($company && $hospital && $generator) {
            //     $refPrefix = $company->company_code . '/' . $hospital->hospital_code . '/' . $generator->generator_code . '/' . $year;

            //     $latest = DB::table('quotations')
            //         ->where('quotation_refno', 'LIKE', $refPrefix . '/%')
            //         ->where('id', '!=', $quotation->id) // exclude current
            //         ->orderBy('quotation_refno', 'desc')
            //         ->first();

            //     if ($latest) {
            //         $parts = explode('/', $latest->quotation_refno);
            //         $lastSequence = intval(end($parts));
            //         $newSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
            //     } else {
            //         $newSequence = '001';
            //     }
            //     $quotation->quotation_refno = $refPrefix . '/' . $newSequence;
            // }

            /**** 04 - Insert Data Into Quotation ****/
            $quotation->save();

            /**** 05 - Save Generated Quotation ****/
            $this->generatePreviewDownloadQuotation(Crypt::encrypt($quotation->id), 2);

            DB::commit();

            return redirect()->route('view-quotation-get', ['id' => Crypt::encrypt($quotation->id)])
                ->with('success', 'Quotation details updated successfully. Please review the quotation.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to update quotation: ' . $e->getMessage());
        }
    }

    // DELETE QUOTATION - FUNCTION
    public function deleteQuotation($id)
    {
        try {
            /**** 01 - Decrypt ID & Get Quotation ****/
            $id = Crypt::decrypt($id);
            $quotation = Quotation::findOrFail($id);
            if (!$quotation) {
                return abort(404, 'Quotation not found');
            }

            /**** 02 - Find and Delete Quotation File ****/
            $pdfPath = public_path('storage/' . $quotation->quotation_directory);

            if (File::exists($pdfPath)) {
                File::delete($pdfPath);
            }

            /**** 03 - Delete Quotation ****/
            $quotation->delete();

            return redirect()->back()->with('success', 'Quotation and associated PDF deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete quotation: ' . $e->getMessage());
        }
    }

    // GET MODEL LIST - AJAX
    public function getModelList($generatorid)
    {
        try {
            /**** 01 - Get Model List ****/
            $data = DB::table('quote_generator_models as qgm')
                ->join('abbott_models as am', 'qgm.model_id', '=', 'am.id')
                ->select('qgm.generator_id', 'am.*')
                ->where('qgm.generator_id', $generatorid)
                ->get();

            /**** 02 - Return Model List ****/
            return response()->json([
                'success' => true,
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error getting model list:' . $e->getMessage()
            ], 500);
        }
    }

    // PREVIEW QUOTATION - FUNCTION
    public function viewPreviewQuotation($id)
    {
        try {
            /**** 01 - Decrypt ID & Get Quotation ****/
            $id = Crypt::decrypt($id);
            $quotation = Quotation::findOrFail($id);

            if (!$quotation) {
                return abort(404, 'Quotation not found');
            }

            /**** 02 - Return Template ****/
            return view('crmd-system.quotation.quotation-preview', [
                'title' => 'Quotation Preview',
                'id' => $id,
                'quotation' => $quotation

            ]);
        } catch (Exception $e) {
            return abort(500, $e->getMessage());
        }
    }

    // QUOTATION HANDLER - FUNCTION [WIP]
    // NOTES : [1] -> VIEW [2] -> GENERATE [3] -> DOWNLOAD
    public function generatePreviewDownloadQuotation($id, $opt)
    {
        try {
            /**** 01 - Decrypt ID & Get Quotation ****/
            $id = Crypt::decrypt($id);
            $quotation = Quotation::findOrFail($id);

            if (!$quotation) {
                return abort(404, 'Quotation not found');
            }

            /**** 02 - Retrieve All Model ****/
            $hospital = Hospital::findOrFail($quotation->hospital_id);

            if (!$hospital) {
                return abort(404, 'Hospital not found');
            }

            $company = Company::findOrFail($quotation->company_id);

            if (!$company) {
                return abort(404, 'Company not found');
            }

            $user = User::findOrFail($quotation->staff_id);

            if (!$user) {
                return abort(404, 'Staff not found');
            }

            $designation = Designation::where('id', $user->designation_id)->first();

            if (!$designation) {
                return abort(404, 'Designation not found');
            }

            $approver = User::findOrFail($quotation->approver_id);

            if (!$approver) {
                return abort(404, 'Approver not found');
            }

            $approverDesignation = Designation::where('id', $approver->designation_id)->first();

            if (!$approverDesignation) {
                return abort(404, 'Approver designation not found');
            }

            /**** 03 - Decode JSON Format ****/
            $metadata = json_decode($quotation->quotation_metadata);
            if (!$metadata || !isset($metadata->generator_id)) {
                return response()->json(['error' => 'Invalid quotation metadata']);
            }

            $generator = Generator::findOrFail($metadata->generator_id);

            /**** 04 -Retrieve Model List ****/
            $modellist = DB::table('quote_generator_models as qgm')
                ->join('abbott_models as am', 'qgm.model_id', '=', 'am.id')
                ->select('am.model_code', 'am.model_name')
                ->where('qgm.generator_id', $generator->id)
                ->get();

            /**** 05 - Group All In Array ****/
            $formattedData = [
                'quotation_date'       => $quotation->quotation_date ?? '-',
                'quotation_totalprice' => $quotation->quotation_price ?? '-',
                'quotation_pt_name'    => $quotation->quotation_pt_name ?? '-',
                'quotation_pt_icno'    => $quotation->quotation_pt_icno ?? '-',
                'quotation_refno'      => $quotation->quotation_refno ?? '-',
                'quotation_unitprice'  => $metadata->quotation_unitprice ?? '-',
                'quotation_qty'        => $metadata->quotation_qty ?? '-',
                'quotation_subject'    => $metadata->quotation_subject ?? '-',
                'quotation_attn'       => $metadata->quotation_attn ?? '-',
                'company_name'         => $company->company_name ?? '-',
                'company_ssm'          => $company->company_ssm ?? '-',
                'company_address'      => $company->company_address ?? '-',
                'company_website'      => $company->company_website ?? '-',
                'company_phoneno'      => $company->company_phoneno ?? '-',
                'company_fax'          => $company->company_fax ?? '-',
                'company_email'        => $company->company_email ?? '-',
                'company_logo'         => $company->company_logo ?? '-',
                'sender_email'         => $metadata->sender_email ?? '-',
                'sender_telno'         => $metadata->sender_telno ?? '-',
                'sender_fax'           => $metadata->sender_fax ?? '-',
                'hospital_name'        => $hospital->hospital_name ?? '-',
                'hospital_address'     => $hospital->hospital_address ?? '-',
                'generator_name'       => $generator->generator_name ?? '-',
                'generator_code'       => $generator->generator_code ?? '-',
                'generator_model'      => $modellist,
                'user_name'            => $user->staff_name ?? '-',
                'designation_name'     => $designation->designation_name ?? '-',
                'approver_name'        => $approver->staff_name ?? '-',
                'approver_designation' => $approverDesignation->designation_name ?? '-',
            ];

            /**** 06 - Prepare Quotation Title ****/
            $sanitizedRefNo = preg_replace('/[^A-Za-z0-9]/', '', $formattedData['quotation_refno']);

            $pdf = Pdf::loadView('crmd-system.quotation.quotation-template-doc', [
                'title' => $sanitizedRefNo,
                'data'  => $formattedData,
            ])
                ->setOption('isRemoteEnabled', true)
                ->setOption('defaultPaperSize', 'a4')
                ->setOption('isPhpEnabled', true)
                ->setPaper('a4', 'portrait');

            /**** 07 - Option ****/

            switch ($opt) {
                case 1:
                    return $pdf->stream($sanitizedRefNo . '.pdf'); // View
                    break;
                case 2:
                    $filePath = 'quotation/document/' . $sanitizedRefNo . '.pdf';
                    $fullPath = public_path("storage/quotation/document");

                    if (!File::exists($fullPath)) {
                        File::makeDirectory($fullPath, 0755, true); // Create directory recursively
                    }

                    $pdf->save($fullPath . '/' . $sanitizedRefNo . '.pdf');

                    $quotation->quotation_directory = 'quotation/document/' . $sanitizedRefNo . '.pdf';
                    $quotation->save();
                    break;
                case 3:
                    return $pdf->download($sanitizedRefNo . '.pdf'); // Download
                    break;
                default:
                    return back()->with('error', 'Oops! Invalid option.');
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to generate quotation. Please try again later.' . $e->getMessage()]);
        }
    }
}
