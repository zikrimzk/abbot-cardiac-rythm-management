<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    // Manage Department Functions

    public function addDepartment(Request $req){
        $validated = $req->validate([
            'department_name'=>'required|string',
        ],[],[
            'department_name'=>'Department Name',
        ]);
        Department::create($validated);
        return back()->with('success','Department added successfully.');
    }

    public function updateDepartment(Request $req,$id){
        $validated = $req->validate([
            'department_name'=>'required|string',
        ],[],[
            'department_name'=>'Department Name',
        ]);
        Department::find($id)->update($validated);
        return back()->with('success','Department updated successfully.');
    }

    public function deleteDepartment($id){
        Department::find($id)->delete();
        return back()->with('success','Department deleted successfully.');
    }

    // Manage Staff Functions
    public function addStaff(Request $req){
        $validated = $req->validate([
            'staff_name'=>'required|string',
            'staff_idno'=>'',
            'staff_role'=>'required|integer',
            'staff_status'=>'required|integer',
            'email'=>'required|email|unique:users,email',
            'department_id'=>'required|integer',
            
        ],[],[
            'staff_name'=>'staff name',
            'staff_idno'=>'staff id number',
            'staff_role'=>'staff role',
            'staff_status'=>'staff status',
            'email'=>'staff email',
            'department_id'=>'staff department',
        ]);
        $password = Str::random(12); 
        $validated['password'] = bcrypt($password);
        User::create($validated);
        return back()->with('success','Staff added successfully.'. 'Password: '.$password);
    }

    public function updateStaff(Request $req,$id){
        $validated = $req->validate([
            'staff_name'=>'required|string',
            'staff_idno'=>'',
            'staff_role'=>'required|integer',
            'staff_status'=>'required|integer',
            'email'=>'required|email',
            'department_id'=>'required|integer',
            
        ],[],[
            'staff_name'=>'staff name',
            'staff_idno'=>'staff id number',
            'staff_role'=>'staff role',
            'staff_status'=>'staff status',
            'email'=>'staff email',
            'department_id'=>'staff department',
        ]);
    
        User::find($id)->update($validated);
        return back()->with('success','Staff updated successfully.');
    }

    public function deleteStaff($id){
        User::find($id)->update(['staff_status'=>2]);
        return back()->with('success','Staff account has been inactivated.');
    }

}
