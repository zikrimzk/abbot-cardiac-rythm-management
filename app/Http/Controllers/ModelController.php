<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\ModelCategory;
use Illuminate\Support\Facades\Validator;

class ModelController extends Controller
{
    //Manage Model Category Functions
    public function addModelCategory(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'mcategory_name' => 'required|string',
            'mcategory_isimplant' => 'required|integer',
        ], [], [
            'mcategory_name' => 'model category name',
            'mcategory_isimplant' => 'model category appearance',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addModalCategoryModal');
        }

        try {
            $validated = $validator->validated();
            ModelCategory::create($validated);
            return back()->with('success', 'Model category added successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->with('modal', 'addModalCategoryModal');
        }
    }

    public function updateModelCategory(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'mcategory_name' => 'required|string',
            'mcategory_isimplant' => 'required|integer',
        ], [], [
            'mcategory_name' => 'model category name',
            'mcategory_isimplant' => 'model category appearance',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateModalCategoryModal-'.$id);
        }

        try {
            $validated = $validator->validated();
            ModelCategory::find($id)->update($validated);
            return back()->with('success', 'Model category updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->with('modal','updateModalCategoryModal-'.$id);
        }
    }

    public function deleteModelCategory($id)
    {
        try {
            ModelCategory::find($id)->delete();
            return back()->with('success', 'Model category deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }
}
