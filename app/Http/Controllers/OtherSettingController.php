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

    //Manage Product Group Functions
    public function addProductGroup(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'product_group_name' => 'required|string|unique:product_groups,product_group_name',
            'product_group_visibility' => 'required|integer',
        ], [], [
            'product_group_name' => 'product group name',
            'product_group_visibility' => 'product group visibility',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addProductGroupModal');
        }

        try {
            $validated = $validator->validated();
            ProductGroup::create($validated);
            return back()->with('success', 'Product group added successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->with('modal', 'addProductGroupModal');
        }
    }

    public function updateProductGroup(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'product_group_name' => 'required|string|unique:product_groups,product_group_name,' . $id,
            'product_group_visibility' => 'required|integer',
        ], [], [
            'product_group_name' => 'product group name',
            'product_group_visibility' => 'product group visibility',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateProductGroupModal-' . $id);
        }

        try {
            $validated = $validator->validated();
            ProductGroup::find($id)->update($validated);
            return back()->with('success', 'Product group updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->with('modal', 'updateProductGroupModal-' . $id);
        }
    }

    public function deleteProductGroup($id)
    {
        try {
            ProductGroup::find($id)->delete();
            return back()->with('success', 'Product group deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    //Manage Stock Location Functions
    public function addStockLocation(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'stock_location_code' => 'required|string|unique:stock_locations,stock_location_code',
            'stock_location_name' => 'required|string',
            'stock_location_status' => 'required|integer',

        ], [], [
            'stock_location_code' => 'stock location code',
            'stock_location_name' => 'stock location name',
            'stock_location_status' => 'stock location status',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addStockLocationModal');
        }

        try {
            $validated = $validator->validated();
            StockLocation::create($validated);
            return back()->with('success', 'Stock location added successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->with('modal', 'addStockLocationModal');
        }
    }

    public function updateStockLocation(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'stock_location_code' => 'required|string|unique:stock_locations,stock_location_code,' . $id,
            'stock_location_name' => 'required|string',
            'stock_location_status' => 'required|integer',

        ], [], [
            'stock_location_code' => 'stock location code',
            'stock_location_name' => 'stock location name',
            'stock_location_status' => 'stock location status',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateStockLocationModal-' . $id);
        }

        try {
            $validated = $validator->validated();
            StockLocation::find($id)->update($validated);
            return back()->with('success', 'Stock location updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->with('modal', 'updateStockLocationModal-' . $id);
        }
    }

    public function deleteStockLocation($id)
    {
        try {
            StockLocation::find($id)->delete();
            return back()->with('success', 'Stock location deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }
}
