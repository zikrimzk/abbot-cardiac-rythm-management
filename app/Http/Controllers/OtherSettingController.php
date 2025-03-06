<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OtherSettingController extends Controller
{
    //Manage Region Functions
    public function addRegion(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'region_name' => 'required|string',
        ], [], [
            'region_name' => 'region name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addRegionModal');
        }

        try {
            $validated = $validator->validated();
            Region::create($validated);
            return back()->with('success', 'Region added successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->with('modal', 'addRegionModal');
        }
    }

    public function updateRegion(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'region_name' => 'required|string',
        ], [], [
            'region_name' => 'region name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateRegionModal-' . $id);
        }

        try {
            $validated = $validator->validated();
            Region::find($id)->update($validated);
            return back()->with('success', 'Region updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->with('modal', 'updateRegionModal-' . $id);
        }
    }

    public function deleteRegion($id)
    {
        try {
            Region::find($id)->delete();
            return back()->with('success', 'Region deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }
}
