<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Region;
use App\Models\Implant;
use App\Models\Document;
use App\Models\Hospital;
use App\Models\Generator;
use App\Models\AbbottModel;
use App\Models\Designation;
use Illuminate\Support\Str;
use App\Models\ImplantModel;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use App\Models\ModelCategory;
use App\Models\StockLocation;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ProductGroupList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class RouteController extends Controller
{
    // LOGIN PAGE - ROUTE
    public function loginpage()
    {
        if (!Auth::check()) {
            return view('crmd-system.login-page', [
                'title' => 'CRMD System | Login'
            ]);
        } else {
            return redirect()->route('staff-dashboard-page');
        }
    }

    // STAFF DASHBOARD - ROUTE
    public function staffDashboard()
    {
        try {
            return view('crmd-system.staff.staff-dashboard', [
                'title' => 'CRMD System | Staff Dashboard'
            ]);
        } catch (Exception $e) {
            return abort(500, $e->getMessage());
        }
    }

    // STAFF PROFILE - ROUTE
    public function staffAccount()
    {
        try {
            return view('crmd-system.staff.staff-account', [
                'title' => 'CRMD System | My Profile'
            ]);
        } catch (Exception $e) {
            return abort(500, $e->getMessage());
        }
    }

    // MANAGE IMPLANT - ROUTE
    public function manageImplant(Request $req)
    {
        try {
            if ($req->ajax()) {

                $data = DB::table('implants')
                    ->select(
                        'id',
                        'implant_refno',
                        'implant_date',
                        'implant_pt_name',
                        'implant_pt_icno',
                        'implant_pt_directory',
                        'implant_backup_form',
                        'region_id',
                        'hospital_id',
                        'generator_id',
                        'region_id',
                        'doctor_id',
                    );

                if ($req->has('date_range') && !empty($req->input('date_range'))) {
                    $dates = explode(' to ', $req->date_range);
                    $startdate = Carbon::parse($dates[0])->format('Y-m-d');
                    $enddate = Carbon::parse($dates[1])->format('Y-m-d');
                    $data->whereBetween('implant_date', [$startdate, $enddate]);
                }

                if ($req->has('hospital') && !empty($req->input('hospital'))) {
                    $data->where('hospital_id', $req->input('hospital'));
                }

                if ($req->has('generator') && !empty($req->input('generator'))) {
                    $data->where('generator_id', $req->input('generator'));
                }

                if ($req->has('region') && !empty($req->input('region'))) {
                    $data->where('region_id', $req->input('region'));
                }

                $data = $data->get();

                $table = DataTables::of($data)->addIndexColumn();

                $table->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="implant-checkbox form-check-input" value="' . $row->id . '">';
                });

                $table->addColumn('implant_date', function ($row) {
                    $date = Carbon::parse($row->implant_date)->format('d M Y');
                    return $date;
                });

                $table->addColumn('implant_refno', function ($row) {
                    $code =
                        '
                    <a href="' . route('view-irf-document', ['id' => Crypt::encrypt($row->id), 'option' => 2]) . '" class="link-primary" target="_blank">
                        ' . $row->implant_refno . '
                    </a>
                
                ';
                    return $code;
                });

                $table->addColumn('implant_backup_form', function ($row) {
                    if ($row->implant_backup_form == null) {
                        $directory =
                            '
                        <div class="d-block mb-3 mt-3">
                            <a href="' . route('view-irf-document', ['id' => Crypt::encrypt($row->id), 'option' => 2]) . '" target="_blank" class="link-dark">
                                <i class="fas fa-file-pdf f-20 text-danger me-2"></i>
                                    Generated IRF
                            </a>
                        </div>

                    ';
                        return $directory;
                    }
                    $directory =
                        '
                    <div class="d-block mb-3 mt-3">
                        <a href="' . route('view-irf-document', ['id' => Crypt::encrypt($row->id), 'option' => 2]) . '" target="_blank" class="link-dark">
                            <i class="fas fa-file-pdf f-20 text-danger me-2"></i>
                                 Generated IRF
                        </a>
                    </div>

                    <div class="d-block mb-3">
                        <a href="' . URL::signedRoute('view-imbackupform', ['filename' => Crypt::encrypt($row->implant_backup_form)]) . '" target="_blank" class="link-dark">
                            <i class="fas fa-file-pdf f-20 text-danger me-2"></i>
                                Uploaded IRF
                        </a>
                    </div>
                ';
                    return $directory;
                });

                $table->addColumn('action', function ($row) {

                    $button =
                        '
                        <a href="' . route('update-implant-page', Crypt::encrypt($row->id)) . '" class="avtar avtar-xs btn-light-primary">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                         <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-info" data-bs-toggle="modal"
                            data-bs-target="#uploadBackupFormModal-' . $row->id . '">
                            <i class="ti ti-file-upload f-20"></i>
                        </a>
                        <a href="' . route('download-implant-directory', Crypt::encrypt($row->id)) . '" class="avtar avtar-xs  btn-light-warning">
                            <i class="ti ti-download f-20"></i>
                        </a>
                        <a href="' . route('generate-patient-id-card-page', Crypt::encrypt($row->id)) . '" class="avtar avtar-xs  btn-light-success">
                            <i class="ti ti-id f-20"></i>
                        </a>
                         <a href="' . route('view-patient-id-card-page', ['id' => $row->id, 'opt' => 1, 'type' => '1']) . '" class="avtar avtar-xs  btn-light-danger d-none">
                            <i class="ti ti-id f-20"></i>
                        </a>
                    ';
                    return $button;
                });

                $table->rawColumns(['checkbox', 'implant_date', 'implant_backup_form', 'implant_refno', 'action']);

                return $table->make(true);
            }
            return view('crmd-system.implant-management.manage-implant', [
                'title' => 'CRMD System | Manage Implant',
                'ims' => Implant::all(),
                'hosp' => Hospital::all(),
                'gene' => Generator::all(),
                'region' => Region::all(),
            ]);
        } catch (Exception $e) {
            return abort(500, $e->getMessage());
        }
    }

    // ADD IMPLANT - ROUTE
    public function addImplant()
    {
        try {
            return view('crmd-system.implant-management.add-implant-new-design', [
                'title' => 'CRMD System | Add Implant',
                'regions' => Region::all(),
                'hospitals' => Hospital::all(),
                'doctors' => Doctor::all(),
                'pgs' => ProductGroup::all(),
                'mcs' => ModelCategory::all(),
                'generators' => Generator::all(),
                'abbottmodels' => AbbottModel::all(),
                'stocklocations' => StockLocation::all(),
            ]);
        } catch (Exception $e) {
            return abort(500, $e->getMessage());
        }
    }

    // UPDATE IMPLANT - ROUTE
    public function updateImplant($id)
    {
        try {
            return view('crmd-system.implant-management.update-implant-new-design', [
                'title' => 'CRMD System | Update Implant',
                'im' => Implant::where('id', Crypt::decrypt($id))->first(),
                'pgslist' => ProductGroupList::where('implant_id', Crypt::decrypt($id))->get(),
                'ims' => ImplantModel::where('implant_id', Crypt::decrypt($id))->get(),
                'regions' => Region::all(),
                'hospitals' => Hospital::all(),
                'doctors' => Doctor::all(),
                'pgs' => ProductGroup::all(),
                'mcs' => ModelCategory::all(),
                'generators' => Generator::all(),
                'abbottmodels' => AbbottModel::all(),
                'stocklocations' => StockLocation::all(),
            ]);
        } catch (Exception $e) {
            return abort(500, $e->getMessage());
        }
    }

    // VIEW BACKUP FORM - ROUTE
    public function viewBackupForm($filename)
    {
        try {
            $filename = Crypt::decrypt($filename);
            $path = storage_path("app/public/{$filename}");

            if (!file_exists($path)) {
                abort(404, 'File not found.');
            }

            return response()->file($path);
        } catch (Exception $e) {
            return abort(500, $e->getMessage());
        }
    }

    // IRF HANDLER - FUNCTION
    // NOTES : [1] -> GENERATE [2] -> VIEW [3] -> DOWNLOAD 
    public function viewGenerateDownloadIRF($id, $option)
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
                'implant_pt_mrn' => $implant->implant_pt_mrn ?? '-',
                'implant_pt_icno' => $implant->implant_pt_icno ?? '-',
                'implant_pt_address' => $implant->implant_pt_address ?? '-',
                'implant_pt_phoneno' => $implant->implant_pt_phoneno ?? '-',
                'implant_pt_email' => $implant->implant_pt_email ?? '-',
                'implant_pt_dob' => Carbon::parse($implant->implant_pt_dob)->format('d M Y') ?? '-',
                'models' => $mergedModels,
            ];

            $title = $formattedData['hospital_code'] . '_' . $formattedData['generator_code'] . '_' . strtoupper(preg_replace('/[^A-Za-z0-9]/', '_', $formattedData['implant_pt_name'])) . '_SYS_IRF';

            $pdf = Pdf::loadView('crmd-system.implant-management.irf-template-doc', [
                'title' =>  $title ?? 'CRMD System | View Implant Registration Form',
                'im' => $formattedData

            ]);

            if ($option == 1) { // Save PDF
                $filePath = 'storage/implants/' . $formattedData['implant_pt_directory'] . '/' . $title . '.pdf';
                $pdf->save(public_path($filePath));
                return back();
            } elseif ($option == 2) // Show PDF
            {
                return $pdf->stream($title . '.pdf');
            } elseif ($option == 3) // Download PDF
            {
                return $pdf->download($title . '.pdf');
            } else {
                return back()->with('error', 'Invalid option selected.');
            }
        } catch (Exception $e) {
            return abort(404, $e->getMessage());
        }
    }

    // GENERATE PATIENT ID CARD - ROUTE
    public function generatePatientIdCard($id)
    {
        try {
            $id = Crypt::decrypt($id);
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
                    'a.implant_pt_id_card_design',
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
                    'a.implant_pt_email',
                ])
                ->groupBy(
                    'a.id',
                    'a.implant_date',
                    'a.implant_refno',
                    'a.implant_pt_id_card_design',
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
                    'a.implant_pt_email',
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
                'implant_pt_id_card_design' => $implant->implant_pt_id_card_design ?? '',
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
                'implant_pt_email' => $implant->implant_pt_email,
                'models' => $mergedModels,
            ];

            $title = $formattedData['implant_pt_name'];

            return view('crmd-system.implant-management.generate-patient-id-card', [
                'title' => 'CRMD System | ' . $title,
                'data' => $formattedData
            ]);
        } catch (Exception $e) {
            return abort(500, $e->getMessage());
        }
    }

    // ID CARD HANDLER - FUNCTION
    // NOTES : [1] -> VIEW [2] -> DOWNLOAD
    public function viewDownloadPatientIdCard($id, $opt, $type)
    {
        try {
            $id = Crypt::decrypt($id);
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

            $title =  $formattedData['hospital_code'] . '_' . $formattedData['generator_code'] . '_' . strtoupper(Carbon::parse($formattedData['implant_date'])->format('dMY')) . '_' .  strtoupper(preg_replace('/[^A-Za-z0-9]/', '_', $formattedData['implant_pt_name'])) . '_PATIENT_ID_CARD';

            $pdf = Pdf::loadView('crmd-system.implant-management.view-pt-id-card', [
                'title' => $title,
                'data' => $formattedData,
                'opt' => $opt
            ]);

            $pdf->setPaper([0, 0, 252, 144], 'portrait');

            if ($type == 1) // Show PDF
            {
                return $pdf->stream($title . '.pdf');
            } elseif ($type == 2) // Download PDF
            {
                return $pdf->download($title . '.pdf');
            } else // 404
            {
                return abort(404);
            }

            return $pdf->stream($title . '.pdf');
        } catch (Exception $e) {
            return abort(500, $e->getMessage());
        }
    }

    // MANAGE SALES BILLING - ROUTE
    public function manageSalesBilling(Request $req)
    {
        try {
            if ($req->ajax()) {
                $data = DB::table('implants')
                    ->select(
                        'id',
                        'implant_refno',
                        'implant_date',
                        'implant_pt_name',
                        'implant_pt_icno',
                        'implant_pt_directory',
                        'implant_pt_icf',
                        'region_id',
                        'hospital_id',
                        'generator_id',
                        'region_id',
                        'doctor_id',
                    );

                if ($req->has('date_range') && !empty($req->input('date_range'))) {
                    $dates = explode(' to ', $req->date_range);
                    $startdate = Carbon::parse($dates[0])->format('Y-m-d');
                    $enddate = Carbon::parse($dates[1])->format('Y-m-d');
                    $data->whereBetween('implant_date', [$startdate, $enddate]);
                }

                if ($req->has('hospital') && !empty($req->input('hospital'))) {
                    $data->where('hospital_id', $req->input('hospital'));
                }

                if ($req->has('generator') && !empty($req->input('generator'))) {
                    $data->where('generator_id', $req->input('generator'));
                }

                if ($req->has('region') && !empty($req->input('region'))) {
                    $data->where('region_id', $req->input('region'));
                }

                $data = $data->get();

                $table = DataTables::of($data)->addIndexColumn();

                $table->addColumn('implant_date', function ($row) {
                    $date = Carbon::parse($row->implant_date)->format('d M Y');
                    return $date;
                });

                $table->addColumn('implant_pt_name', function ($row) {
                    $name =
                        '
                    <a href="' . route('view-irf-document', ['id' => Crypt::encrypt($row->id), 'option' => 2]) . '" class="link-primary" target="_blank">
                        ' . $row->implant_pt_name . '
                    </a>
                
                ';
                    return $name;
                });

                $table->addColumn('inventory_consumption_form', function ($row) {
                    if ($row->implant_pt_icf == null) {
                        $directory =
                            '
                        <div class="d-block mb-3 mt-3">
                           <p class="text-muted fst-italic">No ICF Generated</p>
                        </div>

                    ';
                        return $directory;
                    }
                    $directory =
                        '
                    <div class="d-block mb-3 mt-3">
                        <a href="' . route('icf-document-get', ['id' => Crypt::encrypt($row->id), 'opt' => 1]) . '" target="_blank" class="link-dark">
                            <i class="fas fa-file-pdf f-20 text-danger me-2"></i>
                                 Generated ICF
                        </a>
                    </div>
                ';
                    return $directory;
                });


                $table->addColumn('action', function ($row) {

                    $button =
                        '
                        <a href="' . route('view-editable-icf-page', Crypt::encrypt($row->id)) . '" class="avtar avtar-xs btn-light-primary">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                         <a href="' . route('upload-document-area-page', Crypt::encrypt($row->id)) . '" class="avtar avtar-xs btn-light-info">
                            <i class="ti ti-file-upload f-20"></i>
                        </a>
                    ';
                    return $button;
                });

                $table->rawColumns(['implant_date', 'implant_pt_name', 'inventory_consumption_form', 'action']);

                return $table->make(true);
            }
            return view('crmd-system.sales-billing.manage-sales-billing', [
                'title' => 'CRMD System | Manage Sales Billing',
                'ims' => Implant::all(),
                'hosp' => Hospital::all(),
                'gene' => Generator::all(),
                'region' => Region::all(),
            ]);
        } catch (Exception $e) {
            return abort(500, $e->getMessage());
        }
    }

    // VIEW OR UPDATE ICF DATA - ROUTE
    public function viewInventoryConsumptionFormEditable($id)
    {
        try {
            $id = Crypt::decrypt($id);

            return view('crmd-system.sales-billing.view-editable-icf', [
                'title' => 'CRMD System | View Inventory Consumption Form (ICF)',
                'im' => Implant::where('id', $id)->first(),
                'ims' => ImplantModel::where('implant_id', $id)->get(),
                'mcs' => ModelCategory::all(),
                'generators' => Generator::all(),
                'abbottmodels' => AbbottModel::all(),
                'stocklocations' => StockLocation::all(),
            ]);
        } catch (Exception $e) {
            return abort(500, $e->getMessage());
        }
    }

    // UPLOAD SALES BILLING AREA - ROUTE
    public function uploadDocumentArea($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $implant = Implant::where('id', $id)->first();

            return view('crmd-system.sales-billing.upload-area', [
                'title' => 'CRMD System | ' . $implant->implant_pt_name . '- Document Upload',
                'im' => $implant,
                'ims' => ImplantModel::where('implant_id', $id)->get(),
                'mcs' => ModelCategory::all(),
                'generators' => Generator::all(),
                'abbottmodels' => AbbottModel::all(),
                'stocklocations' => StockLocation::all(),
                'docs' => Document::where('implant_id', $id)->first(),
            ]);
        } catch (Exception $e) {
            return abort(500, $e->getMessage());
        }
    }

    // MANAGE QUOTATION - ROUTE
    public function manageQuotation(Request $req)
    {
        try {
            return view('crmd-system.quotation.manage-quotation', [
                'title' => 'CRMD System | Manage Quotation',
            ]);
        } catch (Exception $e) {
            dd($e->getMessage());
            return abort(500, $e->getMessage());
        }
    }

    // GENERATE QUOTATION - ROUTE
    public function generateQuotation()
    {
        try {
            return view('crmd-system.quotation.generate-quotation', [
                'title' => 'CRMD System | Generate Quotation',
            ]);
        } catch (Exception $e) {
            dd($e->getMessage());
            return abort(500, $e->getMessage());
        }
    }


    // ASSIGN MODEL & GENERATOR - ROUTE
    public function assignGeneratorModel(Request $req)
    {
        try {
            if ($req->ajax()) {
                // Get the generator and its models grouped together
                $data = DB::table('quote_generator_models as qgm')
                    ->join('generators as g', 'qgm.generator_id', '=', 'g.id')
                    ->join('abbott_models as am', 'qgm.model_id', '=', 'am.id')
                    ->select(
                        'g.id as generator_id',
                        'g.generator_name',
                        DB::raw('GROUP_CONCAT(am.model_name SEPARATOR ", ") as model_names'),
                        DB::raw('MAX(qgm.updated_at) as updated_at')
                    )
                    ->groupBy('qgm.generator_id')
                    ->get();


                $table = DataTables::of($data)->addIndexColumn();

                // generator_name column already selected
                $table->addColumn('generator_name', function ($row) {
                    return '<div>' . e($row->generator_name) . '</div>';
                });

                // model_name column - already grouped
                $table->addColumn('model_name', function ($row) {
                    $models = explode(',', $row->model_names);
                    $html = '';
                    foreach ($models as $model) {
                        $html .= '<div class="mb-1">' . e(trim($model)) . '</div>';
                    }
                    return $html;
                });

                $table->addColumn('updated_at', function ($row) {
                    return Carbon::parse($row->updated_at)->format('d M Y g:i A');
                });

                $table->addColumn('action', function ($row) {
                    // Use generator_id only since all models are grouped under it
                    return '
                    <a href="javascript:void(0)" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                        data-bs-target="#updateGeneratorModelModal-' . $row->generator_id . '">
                        <i class="ti ti-edit f-20"></i>
                    </a>
                    <a href="javascript:void(0)" class="avtar avtar-xs btn-light-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteGeneratorModelModal-' . $row->generator_id . '">
                        <i class="ti ti-trash f-20"></i>
                    </a>
                ';
                });

                $table->rawColumns(['generator_name', 'model_name', 'updated_at', 'action']);

                return $table->make(true);
            }

            $data = DB::table('quote_generator_models as qgm')
                ->select(
                    'qgm.generator_id',
                    DB::raw('GROUP_CONCAT(qgm.model_id) as model_ids')
                )
                ->groupBy('qgm.generator_id')
                ->get()
                ->map(function ($item) {
                    // Convert CSV string to array
                    $item->model_ids = array_filter(explode(',', $item->model_ids));
                    return $item;
                });

            $qgmtwo = DB::table('quote_generator_models as qgm')
                ->join('abbott_models as am', 'qgm.model_id', '=', 'am.id')
                ->select('qgm.generator_id', 'qgm.model_id', 'am.mcategory_id')
                ->get();

            return view('crmd-system.quotation.assign-generator-model', [
                'title' => 'CRMD System | Assign Generator & Model',
                'ims' => ImplantModel::all(),
                'mcs' => ModelCategory::all(),
                'generators' => Generator::all(),
                'abbottmodels' => AbbottModel::all(),
                'stocklocations' => StockLocation::all(),
                'qgms' => $data,
                'qgmtwo' => $qgmtwo
            ]);
        } catch (Exception $e) {
            dd($e->getMessage());
            return abort(500, $e->getMessage());
        }
    }

    // Manage Designation Route
    public function manageDesignation(Request $req)
    {
        if ($req->ajax()) {

            $data = DB::table('designations')
                ->select('id', 'designation_name', 'created_at')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d F Y g:i A');
            });

            $table->addColumn('action', function ($row) {
                $isReferenced = DB::table('users')->where('designation_id', $row->id)->exists();
                $buttonEdit =
                    '
                        <a href="javascript: void(0)" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateDesignationModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                    ';
                if (!$isReferenced) {
                    $buttonRemove =
                        '
                        <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-' . $row->id . '">
                            <i class="ti ti-trash f-20"></i>
                        </a>
                    ';
                } else {
                    $buttonRemove =
                        '
                        <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger disabled-a" data-bs-toggle="modal"
                            data-bs-target="#deleteModal">
                            <i class="ti ti-trash f-20"></i>
                        </a>
                    ';
                }

                return $buttonEdit . $buttonRemove;
            });

            $table->rawColumns(['created_at', 'action']);

            return $table->make(true);
        }
        return view('crmd-system.setting.manage-designation', [
            'title' => 'CRMD System | Manage Designation',
            'des' => Designation::all()
        ]);
    }

    // Manage Staff Route
    public function manageStaff(Request $req)
    {
        if ($req->ajax()) {

            $data = DB::table('users')
                ->select('id', 'staff_name', 'staff_idno', 'staff_role', 'staff_status', 'email', 'designation_id')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('designation', function ($row) {
                $des = '';
                $des = Designation::find($row->designation_id);
                $des = $des->designation_name;
                return $des;
            });

            $table->addColumn('role', function ($row) {
                $role = '';
                if ($row->staff_role == 1) {
                    $role = '<span class="badge bg-danger">' . 'Administator' . '</span>';
                } elseif ($row->staff_role == 2) {
                    $role = '<span class="badge bg-info">' . 'Staff' . '</span>';
                }

                return $role;
            });

            $table->addColumn('status', function ($row) {
                $status = '';
                if ($row->staff_status == 1) {
                    $status = '<span class="badge bg-light-success">' . 'Active' . '</span>';
                } elseif ($row->staff_status == 2) {
                    $status = '<span class="badge bg-light-secondary">' . 'Inactive' . '</span>';
                }

                return $status;
            });

            $table->addColumn('action', function ($row) {

                if ($row->staff_status == 2) {
                    $button =
                        '
                        <a href="javascript: void(0)" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateStaffModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                    ';
                } else {
                    $button =
                        '
                        <a href="javascript: void(0)" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateStaffModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                         <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-' . $row->id . '">
                            <i class="ti ti-trash f-20"></i>
                        </a>
                    ';
                }


                return $button;
            });

            $table->rawColumns(['designation', 'role', 'status', 'action']);

            return $table->make(true);
        }
        return view('crmd-system.setting.manage-staff', [
            'title' => 'CRMD System | Manage Staff',
            'sts' => User::all(),
            'des' => Designation::all()
        ]);
    }

    //Manage Hospital Route
    public function manageHospital(Request $req)
    {
        if ($req->ajax()) {

            $data = DB::table('hospitals')
                ->select('id', 'hospital_name', 'hospital_code', 'hospital_address', 'hospital_phoneno', 'hospital_visibility')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('hospital_code', function ($row) {
                $code = '
                <a href="javascript: void(0)" class="link-primary" data-bs-toggle="modal"
                    data-bs-target="#detailsModal-' . $row->id . '">
                    ' . $row->hospital_code . '
                </a>
                ';
                return $code;
            });

            $table->addColumn('hospital_visibility', function ($row) {
                $visibility = '';
                if ($row->hospital_visibility == 1) {
                    $visibility = '<span class="badge bg-light-success">' . 'Show' . '</span>';
                } elseif ($row->hospital_visibility == 2) {
                    $visibility = '<span class="badge bg-light-danger">' . 'Hide' . '</span>';
                }
                return $visibility;
            });

            $table->addColumn('action', function ($row) {
                $isReferenced = DB::table('implants')->where('hospital_id', $row->id)->exists();
                $buttonEdit =
                    '
                        <a href="javascript: void(0)" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateHospitalModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                    ';
                if (!$isReferenced) {
                    $buttonRemove =
                        '
                        <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-' . $row->id . '">
                            <i class="ti ti-trash f-20"></i>
                        </a>
                    ';
                } else {
                    $buttonRemove =
                        '
                        <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger disabled-a" data-bs-toggle="modal"
                            data-bs-target="#deleteModal">
                            <i class="ti ti-trash f-20"></i>
                        </a>

                    ';
                }

                return $buttonEdit . $buttonRemove;
            });

            $table->rawColumns(['hospital_code', 'hospital_visibility', 'action']);

            return $table->make(true);
        }
        return view('crmd-system.setting.manage-hospital', [
            'title' => 'CRMD System | Manage Hospital',
            'hosp' => Hospital::all()
        ]);
    }

    //Manage Doctor Route
    public function manageDoctor(Request $req)
    {
        if ($req->ajax()) {

            $data = DB::table('doctors')
                ->select('id', 'doctor_name', 'doctor_phoneno', 'doctor_status')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('doctor_phoneno', function ($row) {
                $phoneno = '-';
                if ($row->doctor_phoneno != null) {
                    $phoneno = $row->doctor_phoneno;
                }
                return $phoneno;
            });

            $table->addColumn('doctor_status', function ($row) {
                $status = '';
                if ($row->doctor_status == 1) {
                    $status = '<span class="badge bg-light-success">' . 'Active' . '</span>';
                } elseif ($row->doctor_status == 2) {
                    $status = '<span class="badge bg-light-danger">' . 'Inactive' . '</span>';
                }
                return $status;
            });

            $table->addColumn('action', function ($row) {
                $isReferenced = false;
                $isReferenced = DB::table('implants')->where('doctor_id', $row->id)->exists();
                $buttonEdit =
                    '
                        <a href="javascript: void(0)" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateDoctorModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                    ';
                if (!$isReferenced) {
                    $buttonRemove =
                        '
                        <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-' . $row->id . '">
                            <i class="ti ti-trash f-20"></i>
                        </a>
                    ';
                } else {
                    $buttonRemove =
                        '
                        <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger disabled-a" data-bs-toggle="modal"
                            data-bs-target="#deleteModal">
                            <i class="ti ti-trash f-20"></i>
                        </a>
                    ';
                }

                return $buttonEdit . $buttonRemove;
            });

            $table->rawColumns(['doctor_phoneno', 'doctor_status', 'action']);

            return $table->make(true);
        }
        return view('crmd-system.setting.manage-doctor', [
            'title' => 'CRMD System | Manage Doctor',
            'docs' => Doctor::all()
        ]);
    }

    //Manage Model Category Route
    public function manageModelCategory(Request $req)
    {
        if ($req->ajax()) {

            $data = DB::table('model_categories')
                ->select('id', 'mcategory_name', 'mcategory_abbreviation', 'mcategory_ismorethanone', 'mcategory_isappear_incard')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('mcategory_ismorethanone', function ($row) {
                $isAddable = '';
                if ($row->mcategory_ismorethanone == 0) {
                    $isAddable = '<span class="badge bg-light-danger ">' . 'No' . '</span>';
                } elseif ($row->mcategory_ismorethanone == 1) {
                    $isAddable = '<span class="badge bg-light-success">' . 'Yes' . '</span>';
                }
                return $isAddable;
            });

            $table->addColumn('mcategory_isappear_incard', function ($row) {
                $isAppear = '';
                if ($row->mcategory_isappear_incard == 0) {
                    $isAppear = '<span class="badge bg-light-danger ">' . 'No' . '</span>';
                } elseif ($row->mcategory_isappear_incard == 1) {
                    $isAppear = '<span class="badge bg-light-success">' . 'Yes' . '</span>';
                }
                return $isAppear;
            });

            $table->addColumn('action', function ($row) {
                $isReferenced = DB::table('abbott_models')->where('mcategory_id', $row->id)->exists();
                $buttonEdit =
                    '
                        <a href="javascript: void(0)" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateModelCategoryModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                    ';
                if (!$isReferenced) {
                    $buttonRemove =
                        '
                        <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-' . $row->id . '">
                            <i class="ti ti-trash f-20"></i>
                        </a>
                    ';
                } else {
                    $buttonRemove =
                        '
                        <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger disabled-a" data-bs-toggle="modal"
                            data-bs-target="#deleteModal">
                            <i class="ti ti-trash f-20"></i>
                        </a>
                    ';
                }

                return $buttonEdit . $buttonRemove;
            });

            $table->rawColumns(['mcategory_ismorethanone', 'mcategory_isappear_incard', 'action']);

            return $table->make(true);
        }
        return view('crmd-system.setting.manage-model-category', [
            'title' => 'CRMD System | Manage Model Category',
            'mcs' => ModelCategory::all()
        ]);
    }

    //Manage Model Route
    public function manageModel(Request $req)
    {
        if ($req->ajax()) {

            $data = DB::table('abbott_models as a')
                ->join('model_categories as b', 'b.id', '=', 'a.mcategory_id')
                ->select('a.id', 'a.model_name', 'a.model_code', 'a.model_status', 'b.mcategory_name')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('model_status', function ($row) {
                $status = '';
                if ($row->model_status == 1) {
                    $status = '<span class="badge bg-light-success ">' . 'In Use' . '</span>';
                } elseif ($row->model_status == 2) {
                    $status = '<span class="badge bg-light-danger">' . 'Not In Use' . '</span>';
                }
                return $status;
            });

            $table->addColumn('action', function ($row) {
                $isReferenced = false;
                // $isReferenced = DB::table('implants')->where('model_id', $row->id)->exists();
                $buttonEdit =
                    '
                        <a href="javascript: void(0)" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateModelModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                    ';
                if (!$isReferenced) {
                    $buttonRemove =
                        '
                        <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-' . $row->id . '">
                            <i class="ti ti-trash f-20"></i>
                        </a>
                    ';
                } else {
                    $buttonRemove =
                        '
                        <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger disabled-a" data-bs-toggle="modal"
                            data-bs-target="#deleteModal">
                            <i class="ti ti-trash f-20"></i>
                        </a>
                    ';
                }

                return $buttonEdit . $buttonRemove;
            });

            $table->rawColumns(['model_status', 'action']);

            return $table->make(true);
        }
        return view('crmd-system.setting.manage-model', [
            'title' => 'CRMD System | Manage Model',
            'mcs' => ModelCategory::all(),
            'ms' => AbbottModel::all(),
        ]);
    }

    //Manage Generator Route
    public function manageGenerator(Request $req)
    {
        if ($req->ajax()) {

            $data = DB::table('generators')
                ->select('id', 'generator_name', 'generator_code', 'generator_status')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('generator_status', function ($row) {
                $status = '';
                if ($row->generator_status == 1) {
                    $status = '<span class="badge bg-light-success ">' . 'In Use' . '</span>';
                } elseif ($row->generator_status == 2) {
                    $status = '<span class="badge bg-light-danger">' . 'Not In Use' . '</span>';
                }
                return $status;
            });

            $table->addColumn('action', function ($row) {
                $isReferenced = false;
                // $isReferenced = DB::table('implants')->where('model_id', $row->id)->exists();
                $buttonEdit =
                    '
                        <a href="javascript: void(0)" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateGeneratorModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                    ';
                if (!$isReferenced) {
                    $buttonRemove =
                        '
                        <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-' . $row->id . '">
                            <i class="ti ti-trash f-20"></i>
                        </a>
                    ';
                } else {
                    $buttonRemove =
                        '
                        <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger disabled-a" data-bs-toggle="modal"
                            data-bs-target="#deleteModal">
                            <i class="ti ti-trash f-20"></i>
                        </a>
                    ';
                }

                return $buttonEdit . $buttonRemove;
            });

            $table->rawColumns(['generator_status', 'action']);

            return $table->make(true);
        }
        return view('crmd-system.setting.manage-generator', [
            'title' => 'CRMD System | Manage Generator',
            'gs' => Generator::all(),
        ]);
    }

    //Manage Region Route
    public function manageRegion(Request $req)
    {
        if ($req->ajax()) {

            $data = DB::table('regions')
                ->select('id', 'region_name')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('action', function ($row) {
                $isReferenced = false;
                // $isReferenced = DB::table('implants')->where('region_id', $row->id)->exists();
                $buttonEdit =
                    '
                        <a href="javascript: void(0)" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateRegionModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                    ';
                if (!$isReferenced) {
                    $buttonRemove =
                        '
                            <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal-' . $row->id . '">
                                <i class="ti ti-trash f-20"></i>
                            </a>
                        ';
                } else {
                    $buttonRemove =
                        '
                            <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger disabled-a" data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                <i class="ti ti-trash f-20"></i>
                            </a>
                        ';
                }

                return $buttonEdit . $buttonRemove;
            });

            $table->rawColumns(['action']);

            return $table->make(true);
        }
        return view('crmd-system.setting.manage-region', [
            'title' => 'CRMD System | Manage Region',
            'rs' => Region::all(),
        ]);
    }

    //Manage Product Group Route
    public function manageProductGroup(Request $req)
    {
        if ($req->ajax()) {

            $data = DB::table('product_groups')
                ->select('id', 'product_group_name', 'product_group_visibility')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('product_group_visibility', function ($row) {
                $visibility = '';
                if ($row->product_group_visibility == 1) {
                    $visibility = '<span class="badge bg-light-success ">' . 'Show' . '</span>';
                } elseif ($row->product_group_visibility == 2) {
                    $visibility = '<span class="badge bg-light-danger">' . 'Hide' . '</span>';
                }
                return $visibility;
            });

            $table->addColumn('action', function ($row) {
                $isReferenced = false;
                // $isReferenced = DB::table('product_group_lists')->where('product_group_id', $row->id)->exists();
                $buttonEdit =
                    '
                         <a href="javascript: void(0)" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                             data-bs-target="#updateProductGroupModal-' . $row->id . '">
                             <i class="ti ti-edit f-20"></i>
                         </a>
                     ';
                if (!$isReferenced) {
                    $buttonRemove =
                        '
                             <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
                                 data-bs-target="#deleteModal-' . $row->id . '">
                                 <i class="ti ti-trash f-20"></i>
                             </a>
                         ';
                } else {
                    $buttonRemove =
                        '
                             <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger disabled-a" data-bs-toggle="modal"
                                 data-bs-target="#deleteModal">
                                 <i class="ti ti-trash f-20"></i>
                             </a>
                         ';
                }

                return $buttonEdit . $buttonRemove;
            });

            $table->rawColumns(['product_group_visibility', 'action']);

            return $table->make(true);
        }
        return view('crmd-system.setting.manage-product-group', [
            'title' => 'CRMD System | Manage Product Group',
            'pgs' => ProductGroup::all(),
        ]);
    }

    //Manage Stock Location Route
    public function manageStockLocation(Request $req)
    {
        if ($req->ajax()) {

            $data = DB::table('stock_locations')
                ->select('id', 'stock_location_code', 'stock_location_name', 'stock_location_status')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('stock_location_status', function ($row) {
                $status = '';
                if ($row->stock_location_status == 1) {
                    $status = '<span class="badge bg-light-success ">' . 'Active' . '</span>';
                } elseif ($row->stock_location_status == 2) {
                    $status = '<span class="badge bg-light-danger">' . 'Inactive' . '</span>';
                }
                return $status;
            });

            $table->addColumn('action', function ($row) {
                $isReferenced = false;
                // $isReferenced = DB::table('implants')->where('stock_location_id', $row->id)->exists();
                $buttonEdit =
                    '
                         <a href="javascript: void(0)" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                             data-bs-target="#updateStockLocationModal-' . $row->id . '">
                             <i class="ti ti-edit f-20"></i>
                         </a>
                    ';
                if (!$isReferenced) {
                    $buttonRemove =
                        '
                             <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
                                 data-bs-target="#deleteModal-' . $row->id . '">
                                 <i class="ti ti-trash f-20"></i>
                             </a>
                        ';
                } else {
                    $buttonRemove =
                        '
                             <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-danger disabled-a" data-bs-toggle="modal"
                                 data-bs-target="#deleteModal">
                                 <i class="ti ti-trash f-20"></i>
                             </a>
                        ';
                }

                return $buttonEdit . $buttonRemove;
            });

            $table->rawColumns(['stock_location_status', 'action']);

            return $table->make(true);
        }
        return view('crmd-system.setting.manage-stock-location', [
            'title' => 'CRMD System | Manage Stock Location',
            'sls' => StockLocation::all(),
        ]);
    }
}
