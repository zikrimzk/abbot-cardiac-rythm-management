<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\PasswordNotifyMail;
use App\Models\Designation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    // ADD DESIGNATION - FUNCTION
    public function addDesignation(Request $req)
    {
        /**** 01 - Validation ****/
        $validator = Validator::make($req->all(), [
            'designation_name' => 'required|string|unique:designations,designation_name',
        ], [], [
            'designation_name' => 'designation name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addDesignationModal');
        }

        /**** 02 - Store Designation ****/
        try {
            Designation::create($validator->validated());

            return back()->with('success', 'Designation added successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage())
                ->with('modal', 'addDesignationModal');
        }
    }

    // UPDATE DESIGNATION - FUNCTION
    public function updateDesignation(Request $req, $id)
    {
        /**** 01 - Validation ****/
        $validator = Validator::make($req->all(), [
            'designation_name' => 'required|string|unique:designations,designation_name,' . $id,
        ], [], [
            'designation_name' => 'designation name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateDesignationModal-' . $id);
        }

        /**** 02 - Update Designation ****/
        try {
            $designation = Designation::find($id);

            if (!$designation) {
                return redirect()->back()
                    ->with('error', 'Designation not found.')
                    ->with('modal', 'updateDesignationModal-' . $id);
            }

            $designation->update($validator->validated());

            return back()->with('success', 'Designation updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage())
                ->with('modal', 'updateDesignationModal-' . $id);
        }
    }

    // DELETE DESIGNATION - FUNCTION
    public function deleteDesignation($id)
    {
        /**** 01 - Delete Process ****/
        try {
            $designation = Designation::find($id);

            if (!$designation) {
                return redirect()->back()->with('error', 'Designation not found.');
            }

            $designation->delete();

            return back()->with('success', 'Designation deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage());
        }
    }

    // SEND PASSWORD - MAIL FUNCTION
    private function sendPasswordMail($data, $password)
    {
        Mail::to($data->email)->send(new PasswordNotifyMail([
            'name' => Str::headline($data->staff_name),
            'email' => $data->email,
            'date' => Carbon::now()->format('d F Y g:i A'),
            'password' => $password,
        ]));
    }


    // ADD STAFF - FUNCTION
    public function addStaff(Request $req)
    {
        /**** 01 - Validation ****/
        $validator = Validator::make($req->all(), [
            'staff_name' => 'required|string',
            'staff_idno' => 'required|string|unique:users,staff_idno',
            'staff_role' => 'required|integer',
            'staff_status' => 'required|integer',
            'email' => 'required|email|unique:users,email',
            'designation_id' => 'required|integer',
        ], [], [
            'staff_name' => 'staff name',
            'staff_idno' => 'staff id number',
            'staff_role' => 'staff role',
            'staff_status' => 'staff status',
            'email' => 'staff email',
            'designation_id' => 'staff designation',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addStaffModal');
        }

        /**** 02 - Create User ****/
        try {
            $validated = $validator->validated();

            // Generate password using a secure base
            $password = 'crmd@' . Str::lower($validated['staff_idno']);
            $validated['password'] = bcrypt($password);

            // Create user
            $user = User::create($validated);

            // Send password email
            $this->sendPasswordMail($user, $password);

            return back()->with('success', 'Staff added successfully. An email with the temporary password has been sent to the staff. Please inform them to change their password upon first login.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage())
                ->with('modal', 'addStaffModal');
        }
    }

    // UPDATE STAFF - FUNCTION
    public function updateStaff(Request $req, $id)
    {
        /**** 01 - Validation ****/
        $validator = Validator::make($req->all(), [
            'staff_name' => 'required|string',
            'staff_idno' => 'required|string|unique:users,staff_idno,' . $id,
            'staff_role' => 'required|integer',
            'staff_status' => 'required|integer',
            'email' => 'required|email|unique:users,email,' . $id,
            'designation_id' => 'required|integer',
        ], [], [
            'staff_name' => 'staff name',
            'staff_idno' => 'staff id number',
            'staff_role' => 'staff role',
            'staff_status' => 'staff status',
            'email' => 'staff email',
            'designation_id' => 'staff designation',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateStaffModal-' . $id);
        }

        /**** 02 - Update User ****/
        try {
            $user = User::find($id);

            if (!$user) {
                return redirect()->back()
                    ->with('error', 'Staff not found.')
                    ->with('modal', 'updateStaffModal-' . $id);
            }

            $user->update($validator->validated());

            return back()->with('success', 'Staff details updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage())
                ->with('modal', 'updateStaffModal-' . $id);
        }
    }

    // INACTIVATE STAFF - FUNCTION
    public function deleteStaff($id)
    {
        try {
            /**** 01 - Find User ****/
            $user = User::find($id);

            if (!$user) {
                return redirect()->back()->with('error', 'Staff not found.');
            }

            /**** 02 - Update User Status ****/
            $user->update(['staff_status' => 2]);

            return back()->with('success', 'Staff account has been inactivated.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage());
        }
    }
}
