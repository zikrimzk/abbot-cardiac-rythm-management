<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Exception;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HospitalDoctorController extends Controller
{
    //Manage Hospital Functions
    public function addHospital(Request $req)
    {
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
            $validated = $validator->validated();
            Hospital::create($validated);
            return back()->with('success', 'Hospital added successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->with('modal', 'addHospitalModal');
        }
    }

    public function updateHospital(Request $req, $id)
    {
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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateHospitalModal-' . $id);
        }

        try {
            $validated = $validator->validated();

            Hospital::find($id)->update($validated);

            return back()->with('success', 'Hospital updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->with('modal', 'updateHospitalModal-' . $id);
        }
    }

    public function deleteHospital($id)
    {
        try {
            Hospital::find($id)->delete();
            return back()->with('success', 'Hospital deleted successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    //Manage Doctor Functions
    public function addDoctor(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'doctor_name' => 'required|string',
            'doctor_phoneno' => 'nullable|string| max:13 | min:10',
            'doctor_status' => 'required|integer',
            'hospital_id' => 'required|integer'
        ], [], [
            'doctor_name' => 'doctor name',
            'doctor_phoneno' => 'doctor phone number',
            'doctor_status' => 'doctor status',
            'hospital_id' => 'hospital'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addDoctorModal');
        }

        try {
            $validated = $validator->validated();
            Doctor::create($validated);
            return back()->with('success', 'Doctor added successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->with('modal', 'addDoctorModal');
        }
    }

    public function updateDoctor(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'doctor_name' => 'required|string',
            'doctor_phoneno' => 'nullable|string| max:13 | min:10',
            'doctor_status' => 'required|integer',
            'hospital_id' => 'required|integer'
        ], [], [
            'doctor_name' => 'doctor name',
            'doctor_phoneno' => 'doctor phone number',
            'doctor_status' => 'doctor status',
            'hospital_id' => 'hospital'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateDoctorModal-'. $id);
        }

        try {
            $validated = $validator->validated();
            Doctor::find($id)->update($validated);
            return back()->with('success', 'Doctor updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->with('modal', 'updateDoctorModal-'. $id);
        }
    }

    public function deleteDoctor($id) 
    {
        try{
            Doctor::find($id)->delete();
            return back()->with('success', 'Doctor deleted successfully.');
        }
        catch(Exception $e){
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }
}
