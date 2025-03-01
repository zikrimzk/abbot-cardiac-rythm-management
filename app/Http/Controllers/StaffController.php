<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\PasswordNotifyMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    // Manage Department Functions
    public function addDepartment(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'department_name' => 'required|string',
        ], [], [
            'department_name' => 'department name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addDepartmentModal'); // Pastikan modal yang betul dipaparkan
        }

        try {
            Department::create($validator->validated());
            return back()->with('success', 'Department added successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.')
                ->with('modal', 'addDepartmentModal');
        }
    }

    public function updateDepartment(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'department_name' => 'required|string',
        ], [], [
            'department_name' => 'department name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateDepartmentModal-' . $id);
        }

        try {
            Department::find($id)->update($validator->validated());
            return back()->with('success', 'Department updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.')
                ->with('modal', 'updateDepartmentModal-' . $id);
        }
    }

    public function deleteDepartment($id)
    {
        Department::find($id)->delete();
        return back()->with('success', 'Department deleted successfully.');
    }

    // Manage Staff Functions

    /* Send Password Notification */
    private function sendPasswordMail($data, $password)
    {
        Mail::to($data->email)->send(new PasswordNotifyMail([
            'name' => Str::headline($data->staff_name),
            'email' => $data->email,
            'date' => Carbon::now()->format('d F Y g:i A'),
            'password' => $password,
        ]));
    }

    public function addStaff(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'staff_name' => 'required|string',
            'staff_idno' => 'nullable|string',
            'staff_role' => 'required|integer',
            'staff_status' => 'required|integer',
            'email' => 'required|email|unique:users,email',
            'department_id' => 'required|integer',
        ], [], [
            'staff_name' => 'staff name',
            'staff_idno' => 'staff id number',
            'staff_role' => 'staff role',
            'staff_status' => 'staff status',
            'email' => 'staff email',
            'department_id' => 'staff department',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addStaffModal');
        }

        try {
            $validated = $validator->validated();
            $password = Str::random(12);
            $validated['password'] = bcrypt($password);

            $user = User::create($validated);

            $this->sendPasswordMail($user, $password);

            return back()->with('success', 'Staff added successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->with('modal', 'addStaffModal');
        }
    }

    public function updateStaff(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'staff_name' => 'required|string',
            'staff_idno' => 'nullable|string',
            'staff_role' => 'required|integer',
            'staff_status' => 'required|integer',
            'email' => 'required|email|unique:users,email,' . $id,
            'department_id' => 'required|integer',

        ], [], [
            'staff_name' => 'staff name',
            'staff_idno' => 'staff id number',
            'staff_role' => 'staff role',
            'staff_status' => 'staff status',
            'email' => 'staff email',
            'department_id' => 'staff department',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateStaffModal-' . $id);
        }

        try {
            $validated = $validator->validated();
            User::find($id)->update($validated);
            return back()->with('success', 'Staff updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->with('modal', 'updateStaffModal-' . $id);
        }
    }

    public function deleteStaff($id)
    {
        User::find($id)->update(['staff_status' => 2]);
        return back()->with('success', 'Staff account has been inactivated.');
    }
    
}
