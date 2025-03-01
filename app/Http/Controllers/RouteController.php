<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Department;
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

    // Manage Department Route
    public function manageDepartment(Request $req)
    {
        if ($req->ajax()) {

            $data = DB::table('departments')
                ->select('id', 'department_name','created_at')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d F Y g:i A');
            });

            $table->addColumn('action', function ($row) {
                $isReferenced = DB::table('users')->where('department_id', $row->id)->exists();
                $buttonEdit =
                    '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateDepartmentModal-' . $row->id . '">
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
        return view('crmd-system.staff-management.manage-department', [
            'title' => 'CRMD System | Manage Department',
            'deps' => Department::all()
        ]);
    }

    // Manage Department Route
    public function manageStaff(Request $req)
    {
        if ($req->ajax()) {

            $data = DB::table('users')
                ->select('id', 'staff_name', 'staff_idno', 'staff_role', 'staff_status', 'email', 'department_id')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('department', function ($row) {
                $deps = '';
                $deps = Department::find($row->department_id);
                $deps = $deps->department_name;
                return $deps;
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

            $table->rawColumns(['department', 'role', 'status', 'action']);

            return $table->make(true);
        }
        return view('crmd-system.staff-management.manage-staff', [
            'title' => 'CRMD System | Manage Staff',
            'sts' => User::all(),
            'deps' => Department::all()
        ]);
    }
}
