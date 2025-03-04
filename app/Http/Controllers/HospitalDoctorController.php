<?php

namespace App\Http\Controllers;

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
            'hospital_code' => 'required|string|unique:hospitals,hospital_code,'. $id,
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
                ->with('modal', 'updateHospitalModal-'. $id);
        }

        try {
            $validated = $validator->validated();

            Hospital::find($id)->update($validated);

            return back()->with('success', 'Hospital updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->with('modal', 'updateHospitalModal-'. $id);
        }
    }

    public function deleteHospital(Request $req, $id) {}

    //Manage Doctor Functions
    public function addDoctor(Request $req) {}

    public function updateDoctor(Request $req, $id) {}

    public function deleteDoctor(Request $req, $id) {}
}
