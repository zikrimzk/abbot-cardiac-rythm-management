<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        return view('crmd-system.staff.staff-account',[
            'title'=>'CRMD System | My Profile'
        ]);
    }

    // Manage Designation Route
    public function manageDesignation(Request $req)
    {
        if ($req->ajax()) {

            $data = DB::table('designations')
                ->select('id', 'designation_name','created_at')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d F Y g:i A');
            });

            $table->addColumn('action', function ($row) {
                $isReferenced = DB::table('users')->where('designation_id', $row->id)->exists();
                $buttonEdit =
                    '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateDesignationModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                    ';
                if (!$isReferenced) {
                    $buttonRemove =
                        '
                        <a href="#" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-' . $row->id . '">
                            <i class="ti ti-trash f-20"></i>
                        </a>
                    ';
                } else {
                    $buttonRemove = '';
                }

                return $buttonEdit . $buttonRemove;
            });

            $table->rawColumns(['created_at','action']);

            return $table->make(true);
        }
        return view('crmd-system.staff-management.manage-designation', [
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
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateStaffModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                    ';
                } else {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateStaffModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                         <a href="#" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
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
        return view('crmd-system.staff-management.manage-staff', [
            'title' => 'CRMD System | Manage Staff',
            'sts' => User::all(),
            'des' => Designation::all()
        ]);
    }

    public function manageImplant(Request $req)
    {
        return view('crmd-system.implant-management.manage-implant', [
            'title' => 'CRMD System | Manage Implant'
        ]);
    }

    public function addImplant(Request $req)
    {
        return view('crmd-system.implant-management.add-implant', [
            'title' => 'CRMD System | Add Implant'
        ]);
    }
}
