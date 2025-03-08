<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Region;
use App\Models\Implant;
use App\Models\Hospital;
use App\Models\Generator;
use App\Models\AbbottModel;
use App\Models\Designation;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use App\Models\ModelCategory;
use App\Models\StockLocation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class RouteController extends Controller
{
    // Login Route 
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

    // Staff Dashboard Route
    public function staffDashboard()
    {
        return view('crmd-system.staff.staff-dashboard', [
            'title' => 'CRMD System | Staff Dashboard'
        ]);
    }

    // Staff Profile Route
    public function staffAccount()
    {
        return view('crmd-system.staff.staff-account', [
            'title' => 'CRMD System | My Profile'
        ]);
    }

    // Manage Implant Route
    public function manageImplant(Request $req)
    {
        if ($req->ajax()) {

            $data = DB::table('implants')
                ->select(
                    'id',
                    'implant_date',
                    'implant_pt_name',
                    'implant_pt_icno',
                    'implant_pt_directory',
                    'region_id',
                    'hospital_id',
                    'doctor_id',
                )
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('implant_date', function ($row) {
                $date = Carbon::parse($row->implant_date)->format('d-m-Y');
                return $date;
            });

            $table->addColumn('implant_pt_directory', function ($row) {
                $directory =
                    '
                    <a href="javascript: void(0)" class="link-primary" data-bs-toggle="modal"
                        data-bs-target="#directoryModal-' . $row->id . '">
                        ' . $row->implant_pt_directory . '
                    </a>
                
                ';
                return $directory;
            });


            $table->addColumn('action', function ($row) {

                $button =
                    '
                        <a href="'. route('update-implant-page', Crypt::encrypt($row->id)) .'" class="avtar avtar-xs btn-light-primary">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                         <a href="javascript: void(0)" class="avtar avtar-xs  btn-light-info" data-bs-toggle="modal"
                            data-bs-target="#uploadBackupFormModal-' . $row->id . '">
                            <i class="ti ti-file-upload f-20"></i>
                        </a>
                    ';
                return $button;
            });

            $table->rawColumns(['implant_date','implant_pt_directory', 'action']);

            return $table->make(true);
        }
        return view('crmd-system.implant-management.manage-implant', [
            'title' => 'CRMD System | Manage Implant'
        ]);
    }

    // Add Implant Route
    public function addImplant()
    {
        return view('crmd-system.implant-management.add-implant', [
            'title' => 'CRMD System | Add Implant',
            'regions' => Region::all(),
            'hospitals' => Hospital::all(),
            'doctors' => Doctor::all(),
            'pgs' => ProductGroup::all(),
            'mcs' => ModelCategory::where('mcategory_isimplant', 1)->get(),
            'generators' => Generator::all(),
            'abbottmodels' => AbbottModel::all(),
            'stocklocations' => StockLocation::all(),
        ]);
    }

     // Add Implant Route
     public function updateImplant($id)
     {
         return view('crmd-system.implant-management.update-implant', [
             'title' => 'CRMD System | Update Implant',
             'im' => Implant::where('id', Crypt::decrypt($id))->first(),
             'regions' => Region::all(),
             'hospitals' => Hospital::all(),
             'doctors' => Doctor::all(),
             'pgs' => ProductGroup::all(),
             'mcs' => ModelCategory::where('mcategory_isimplant', 1)->get(),
             'generators' => Generator::all(),
             'abbottmodels' => AbbottModel::all(),
             'stocklocations' => StockLocation::all(),
         ]);
     }

    // Generate Patient ID Card Route
    public function generatePatientIdCard(Request $req)
    {
        return view('crmd-system.patient-management.generate-patient-id-card', [
            'title' => 'CRMD System | Generate Patient ID Card'
        ]);
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
                $isReferenced = DB::table('doctors')->where('hospital_id', $row->id)->exists();
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

            $data = DB::table('doctors as a')
                ->join('hospitals as b', 'b.id', '=', 'a.hospital_id')
                ->select('a.id', 'a.doctor_name', 'a.doctor_phoneno', 'a.doctor_status', 'b.hospital_name', 'b.hospital_code')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('doctor_phoneno', function ($row) {
                $phoneno = '-';
                if ($row->doctor_phoneno != null) {
                    $phoneno = $row->doctor_phoneno;
                }
                return $phoneno;
            });

            $table->addColumn('hospital_code', function ($row) {
                $code = '
                <a href="javascript: void(0)" class="link-primary" data-bs-toggle="modal"
                    data-bs-target="#detailHospitalModal-' . $row->id . '">
                    ' . $row->hospital_code . '
                </a>
                ';
                return $code;
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
                // $isReferenced = DB::table('implants')->where('doctor_id', $row->id)->exists();
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

            $table->rawColumns(['doctor_phoneno', 'hospital_code', 'doctor_status', 'action']);

            return $table->make(true);
        }
        return view('crmd-system.setting.manage-doctor', [
            'title' => 'CRMD System | Manage Doctor',
            'hosp' => Hospital::all(),
            'docs' => Doctor::all()

        ]);
    }

    //Manage Model Category Route
    public function manageModelCategory(Request $req)
    {
        if ($req->ajax()) {

            $data = DB::table('model_categories')
                ->select('id', 'mcategory_name', 'mcategory_isimplant')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('mcategory_isimplant', function ($row) {
                $isImplant = '';
                if ($row->mcategory_isimplant == 0) {
                    $isImplant = '<span class="badge bg-light-danger ">' . 'No' . '</span>';
                } elseif ($row->mcategory_isimplant == 1) {
                    $isImplant = '<span class="badge bg-light-success">' . 'Yes' . '</span>';
                }
                return $isImplant;
            });

            $table->addColumn('action', function ($row) {
                // $isReferenced = false;
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

            $table->rawColumns(['mcategory_isimplant', 'action']);

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
