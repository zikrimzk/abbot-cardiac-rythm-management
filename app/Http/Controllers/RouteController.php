<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RouteController extends Controller
{
    // Login Route 
    public function loginpage()
    {
        return view('crmd-system.login-page', [
            'title' => 'CRMD System | Login'
        ]);
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
                ->select('id', 'department_name')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

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

            $table->rawColumns(['action']);

            return $table->make(true);
        }
        return view('crmd-system.staff-management.manage-department', [
            'title' => 'CRMD System | Manage Department',
            'deps' => Department::all()
        ]);
    }
}
