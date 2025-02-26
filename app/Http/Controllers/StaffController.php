<?php

namespace App\Http\Controllers;

use App\Models\Department;
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
}
