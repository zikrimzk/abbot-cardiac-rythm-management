<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HospitalDoctorController extends Controller
{
    // ADD HOSPITAL - FUNCTION
    public function addHospital(Request $req)
    {
        /**** 01 - Validate Input ****/
        $validator = Validator::make($req->all(), [
            'hospital_name' => 'required|string',
            'hospital_code' => 'required|string|unique:hospitals,hospital_code',
            'hospital_address' => 'nullable|string',
            'hospital_phoneno' => 'nullable|string',
            'hospital_visibility' => 'required|integer',
        ], [], [
            'hospital_name' => 'hospital name',
            'hospital_code' => 'hospital code',
            'hospital_address' => 'hospital address',
            'hospital_phoneno' => 'hospital phone number',
            'hospital_visibility' => 'hospital visibility',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addHospitalModal');
        }

        try {
            /**** 02 - Sanitize and Save Data ****/
            $validated = $validator->validated();

            // Ensure hospital code is stored in uppercase
            $validated['hospital_code'] = Str::upper($validated['hospital_code']);

            // Save hospital record
            Hospital::create($validated);

            return back()->with('success', 'Hospital added successfully.');
        } catch (Exception $e) {
            /**** 03 - Handle Exception and Return Error Message ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage())
                ->with('modal', 'addHospitalModal');
        }
    }

    // UPDATE HOSPITAL - FUNCTION
    public function updateHospital(Request $req, $id)
    {
        /**** 01 - Validate Input ****/
        $validator = Validator::make($req->all(), [
            'hospital_name' => 'required|string',
            'hospital_code' => 'required|string|unique:hospitals,hospital_code,' . $id,
            'hospital_address' => 'nullable|string',
            'hospital_phoneno' => 'nullable|string',
            'hospital_visibility' => 'required|integer',
        ], [], [
            'hospital_name' => 'hospital name',
            'hospital_code' => 'hospital code',
            'hospital_address' => 'hospital address',
            'hospital_phoneno' => 'hospital phone number',
            'hospital_visibility' => 'hospital visibility',
        ]);

        if ($validator->fails()) {
            // Redirect back with validation errors and reopen the specific modal
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateHospitalModal-' . $id);
        }

        try {
            /**** 02 - Sanitize and Update Data ****/
            $validated = $validator->validated();

            // Ensure hospital code is stored in uppercase
            $validated['hospital_code'] = Str::upper($validated['hospital_code']);

            // Update hospital record
            Hospital::find($id)->update($validated);

            return back()->with('success', 'Hospital updated successfully.');
        } catch (Exception $e) {
            /**** 03 - Handle Exception and Return Error Message ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage())
                ->with('modal', 'updateHospitalModal-' . $id);
        }
    }

    // DELETE HOSPITAL - FUNCTION
    public function deleteHospital($id)
    {
        try {
            /**** 01 - Delete Hospital Record ****/
            Hospital::find($id)->delete();

            return back()->with('success', 'Hospital deleted successfully.');
        } catch (Exception $e) {
            /**** 02 - Handle Exception and Return Error Message ****/
            return back()->with('error', 'Something went wrong. Please try again. ' . $e->getMessage());
        }
    }

    // ADD DOCTOR - FUNCTION
    public function addDoctor(Request $req)
    {
        /**** 01 - Validate Request Data ****/
        $validator = Validator::make($req->all(), [
            'doctor_name' => 'required|string',
            'doctor_phoneno' => 'nullable|string',
            'doctor_status' => 'required|integer',
        ], [], [
            'doctor_name' => 'doctor name',
            'doctor_phoneno' => 'doctor phone number',
            'doctor_status' => 'doctor status',
        ]);

        /**** 02 - Handle Validation Failure ****/
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addDoctorModal');
        }

        try {
            /**** 03 - Create New Doctor Record ****/
            $validated = $validator->validated();
            Doctor::create($validated);

            /**** 04 - Return Success Response ****/
            return back()->with('success', 'Doctor added successfully.');
        } catch (Exception $e) {
            /**** 05 - Handle Exception Error ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage())
                ->with('modal', 'addDoctorModal');
        }
    }

    // UPDATE DOCTOR - FUNCTION
    public function updateDoctor(Request $req, $id)
    {
        /**** 01 - Validate Request Data ****/
        $validator = Validator::make($req->all(), [
            'doctor_name' => 'required|string',
            'doctor_phoneno' => 'nullable|string',
            'doctor_status' => 'required|integer',
        ], [], [
            'doctor_name' => 'doctor name',
            'doctor_phoneno' => 'doctor phone number',
            'doctor_status' => 'doctor status',
        ]);

        /**** 02 - Handle Validation Failure ****/
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateDoctorModal-' . $id);
        }

        try {
            /**** 03 - Update Doctor Record ****/
            $validated = $validator->validated();
            Doctor::find($id)->update($validated);

            /**** 04 - Return Success Response ****/
            return back()->with('success', 'Doctor updated successfully.');
        } catch (Exception $e) {
            /**** 05 - Handle Exception Error ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage())
                ->with('modal', 'updateDoctorModal-' . $id);
        }
    }

    // DELETE DOCTOR - FUNCTION
    public function deleteDoctor($id)
    {
        try {
            /**** 01 - Delete Doctor Record ****/
            Doctor::find($id)->delete();

            /**** 02 - Return Success Response ****/
            return back()->with('success', 'Doctor deleted successfully.');
        } catch (Exception $e) {
            /**** 03 - Handle Exception Error ****/
            return back()->with('error', 'Something went wrong. Please try again. ' . $e->getMessage());
        }
    }
}
