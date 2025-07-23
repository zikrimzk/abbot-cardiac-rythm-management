<?php

namespace App\Http\Controllers;

use App\Models\ProductGroup;
use Exception;
use App\Models\Region;
use App\Models\StockLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OtherSettingController extends Controller
{
    // ADD REGION - FUNCTION
    public function addRegion(Request $req)
    {
        /**** 01 - Validate Region Input ****/
        $validator = Validator::make($req->all(), [
            'region_name' => 'required|string|unique:regions,region_name',
        ], [], [
            'region_name' => 'region name',
        ]);

        if ($validator->fails()) {
            /**** 02 - Return Back With Validation Errors ****/
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addRegionModal');
        }

        try {
            /**** 03 - Save Region Record ****/
            $validated = $validator->validated();
            Region::create($validated);

            /**** 04 - Return Success Response ****/
            return back()->with('success', 'Region added successfully.');
        } catch (Exception $e) {
            /**** 05 - Handle Exception Error ****/
            return redirect()->back()
                ->with('error',  'Something went wrong. Please try again.' . $e->getMessage())
                ->with('modal', 'addRegionModal');
        }
    }

    // UPDATE REGION - FUNCTION
    public function updateRegion(Request $req, $id)
    {
        /**** 01 - Validate Region Input ****/
        $validator = Validator::make($req->all(), [
            'region_name' => 'required|string|unique:regions,region_name,' . $id,
        ], [], [
            'region_name' => 'region name',
        ]);

        if ($validator->fails()) {
            /**** 02 - Return Back With Validation Errors ****/
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateRegionModal-' . $id);
        }

        try {
            /**** 03 - Update Region Record ****/
            $validated = $validator->validated();
            Region::find($id)->update($validated);

            /**** 04 - Return Success Response ****/
            return back()->with('success', 'Region updated successfully.');
        } catch (Exception $e) {
            /**** 05 - Handle Exception Error ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.' . $e->getMessage())
                ->with('modal', 'updateRegionModal-' . $id);
        }
    }

    // DELETE REGION - FUNCTION
    public function deleteRegion($id)
    {
        try {
            /**** 01 - Delete Region Record ****/
            Region::find($id)->delete();

            /**** 02 - Return Success Response ****/
            return back()->with('success', 'Region deleted successfully.');
        } catch (Exception $e) {
            /**** 03 - Handle Exception Error ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage());
        }
    }

    // ADD PRODUCT GROUP - FUNCTION
    public function addProductGroup(Request $req)
    {
        /**** 01 - Validate Input ****/
        $validator = Validator::make($req->all(), [
            'product_group_name' => 'required|string|unique:product_groups,product_group_name',
            'product_group_visibility' => 'required|integer',
        ], [], [
            'product_group_name' => 'product group name',
            'product_group_visibility' => 'product group visibility',
        ]);

        if ($validator->fails()) {
            /**** 02 - Handle Validation Failure ****/
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addProductGroupModal');
        }

        try {
            /**** 03 - Insert Product Group Record ****/
            $validated = $validator->validated();
            ProductGroup::create($validated);

            /**** 04 - Return Success Response ****/
            return back()->with('success', 'Product group added successfully.');
        } catch (Exception $e) {
            /**** 05 - Handle Exception Error ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.' . $e->getMessage())
                ->with('modal', 'addProductGroupModal');
        }
    }

    // UPDATE PRODUCT GROUP - FUNCTION
    public function updateProductGroup(Request $req, $id)
    {
        /**** 01 - Validate Input ****/
        $validator = Validator::make($req->all(), [
            'product_group_name' => 'required|string|unique:product_groups,product_group_name,' . $id,
            'product_group_visibility' => 'required|integer',
        ], [], [
            'product_group_name' => 'product group name',
            'product_group_visibility' => 'product group visibility',
        ]);

        if ($validator->fails()) {
            /**** 02 - Handle Validation Failure ****/
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateProductGroupModal-' . $id);
        }

        try {
            /**** 03 - Update Product Group Record ****/
            $validated = $validator->validated();
            ProductGroup::find($id)->update($validated);

            /**** 04 - Return Success Response ****/
            return back()->with('success', 'Product group updated successfully.');
        } catch (Exception $e) {
            /**** 05 - Handle Exception Error ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.' . $e->getMessage())
                ->with('modal', 'updateProductGroupModal-' . $id);
        }
    }

    // DELETE PRODUCT GROUP - FUNCTION
    public function deleteProductGroup($id)
    {
        try {
            /**** 01 - Delete Product Group Record ****/
            ProductGroup::find($id)->delete();

            /**** 02 - Return Success Response ****/
            return back()->with('success', 'Product group deleted successfully.');
        } catch (Exception $e) {
            /**** 03 - Handle Exception Error ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.' . $e->getMessage());
        }
    }

    // ADD STOCK LOCATION - FUNCTION
    public function addStockLocation(Request $req)
    {
        /**** 01 - Validate Request Inputs ****/
        $validator = Validator::make($req->all(), [
            'stock_location_code' => 'required|string|unique:stock_locations,stock_location_code',
            'stock_location_name' => 'required|string',
            'stock_location_status' => 'required|integer',
        ], [], [
            'stock_location_code' => 'stock location code',
            'stock_location_name' => 'stock location name',
            'stock_location_status' => 'stock location status',
        ]);

        /**** 02 - Return with Error If Validation Fails ****/
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addStockLocationModal');
        }

        try {
            /**** 03 - Store Validated Data into Database ****/
            $validated = $validator->validated();
            StockLocation::create($validated);

            /**** 04 - Return Success Message ****/
            return back()->with('success', 'Stock location added successfully.');
        } catch (Exception $e) {
            /**** 05 - Return Error If Something Goes Wrong ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage())
                ->with('modal', 'addStockLocationModal');
        }
    }

    // UPDATE STOCK LOCATION - FUNCTION
    public function updateStockLocation(Request $req, $id)
    {
        /**** 01 - Validate Request Inputs ****/
        $validator = Validator::make($req->all(), [
            'stock_location_code' => 'required|string|unique:stock_locations,stock_location_code,' . $id,
            'stock_location_name' => 'required|string',
            'stock_location_status' => 'required|integer',
        ], [], [
            'stock_location_code' => 'stock location code',
            'stock_location_name' => 'stock location name',
            'stock_location_status' => 'stock location status',
        ]);

        /**** 02 - Return with Error If Validation Fails ****/
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateStockLocationModal-' . $id);
        }

        try {
            /**** 03 - Update Record in Database ****/
            $validated = $validator->validated();
            StockLocation::find($id)->update($validated);

            /**** 04 - Return Success Message ****/
            return back()->with('success', 'Stock location updated successfully.');
        } catch (Exception $e) {
            /**** 05 - Return Error If Something Goes Wrong ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage())
                ->with('modal', 'updateStockLocationModal-' . $id);
        }
    }

    // DELETE STOCK LOCATION - FUNCTION
    public function deleteStockLocation($id)
    {
        try {
            /**** 01 - Delete Stock Location by ID ****/
            StockLocation::find($id)?->delete();

            /**** 02 - Return Success Message ****/
            return back()->with('success', 'Stock location deleted successfully.');
        } catch (Exception $e) {
            /**** 03 - Return Error Message on Failure ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage());
        }
    }
}
