<?php

namespace App\Http\Controllers;

use App\Models\AbbottModel;
use App\Models\Generator;
use Exception;
use Illuminate\Http\Request;
use App\Models\ModelCategory;
use Illuminate\Support\Facades\Validator;

class ModelController extends Controller
{

    // ADD MODEL CATEGORY - FUNCTION
    public function addModelCategory(Request $req)
    {
        /**** 01 - Validate Request Data ****/
        $validator = Validator::make($req->all(), [
            'mcategory_name' => 'required|string',
            'mcategory_abbreviation' => 'required|string',
            'mcategory_ismorethanone' => 'required|integer',
            'mcategory_isappear_incard' => 'required|integer',
        ], [], [
            'mcategory_name' => 'model category name',
            'mcategory_abbreviation' => 'model category abbreviation',
            'mcategory_ismorethanone' => 'category multiple input',
            'mcategory_isappear_incard' => 'category appearance in Patient ID Card',
        ]);

        if ($validator->fails()) {
            /**** 02 - Handle Validation Errors ****/
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addModalCategoryModal');
        }

        try {
            /**** 03 - Create Model Category Record ****/
            $validated = $validator->validated();
            ModelCategory::create($validated);

            /**** 04 - Return Success Response ****/
            return back()->with('success', 'Model category added successfully.');
        } catch (Exception $e) {
            /**** 05 - Handle Exception Error ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage())
                ->with('modal', 'addModalCategoryModal');
        }
    }

    // UPDATE MODEL CATEGORY - FUNCTION
    public function updateModelCategory(Request $req, $id)
    {
        /**** 01 - Validate Request Data ****/
        $validator = Validator::make($req->all(), [
            'mcategory_name' => 'required|string',
            'mcategory_abbreviation' => 'required|string',
            'mcategory_ismorethanone' => 'required|integer',
            'mcategory_isappear_incard' => 'required|integer',
        ], [], [
            'mcategory_name' => 'model category name',
            'mcategory_abbreviation' => 'model category abbreviation',
            'mcategory_ismorethanone' => 'category multiple input',
            'mcategory_isappear_incard' => 'category appearance in Patient ID Card',
        ]);

        if ($validator->fails()) {
            /**** 02 - Handle Validation Errors ****/
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateModalCategoryModal-' . $id);
        }

        try {
            /**** 03 - Update Model Category Record ****/
            $validated = $validator->validated();
            ModelCategory::find($id)->update($validated);

            /**** 04 - Return Success Response ****/
            return back()->with('success', 'Model category updated successfully.');
        } catch (Exception $e) {
            /**** 05 - Handle Exception Error ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage())
                ->with('modal', 'updateModalCategoryModal-' . $id);
        }
    }

    // DELETE MODEL CATEGORY - FUNCTION
    public function deleteModelCategory($id)
    {
        try {
            /**** 01 - Delete Model Category Record ****/
            ModelCategory::find($id)->delete();

            /**** 02 - Return Success Response ****/
            return back()->with('success', 'Model category deleted successfully.');
        } catch (Exception $e) {
            /**** 03 - Handle Exception Error ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage());
        }
    }

    // ADD MODEL - FUNCTION
    public function addModel(Request $req)
    {
        /**** 01 - Validate Request Data ****/
        $validator = Validator::make($req->all(), [
            'model_name' => 'required|string',
            'model_code' => 'required|string|unique:abbott_models,model_code',
            'model_status' => 'required|integer',
            'mcategory_id' => 'required|integer',
        ], [], [
            'model_name' => 'model name',
            'model_code' => 'model code',
            'model_status' => 'model status',
            'mcategory_id' => 'model category',
        ]);

        /**** 02 - Handle Validation Failure ****/
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addModelModal');
        }

        try {
            /**** 03 - Insert Model Record ****/
            $validated = $validator->validated();
            AbbottModel::create($validated);

            /**** 04 - Return Success Response ****/
            return back()->with('success', 'Model added successfully.');
        } catch (Exception $e) {
            /**** 05 - Handle Exception Error ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage())
                ->with('modal', 'addModelModal');
        }
    }

    // UPDATE MODEL - FUNCTION
    public function updateModel(Request $req, $id)
    {
        /**** 01 - Validate Request Data ****/
        $validator = Validator::make($req->all(), [
            'model_name' => 'required|string',
            'model_code' => 'required|string|unique:abbott_models,model_code,' . $id,
            'model_status' => 'required|integer',
            'mcategory_id' => 'required|integer',
        ], [], [
            'model_name' => 'model name',
            'model_code' => 'model code',
            'model_status' => 'model status',
            'mcategory_id' => 'model category',
        ]);

        /**** 02 - Handle Validation Failure ****/
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateModelModal-' . $id);
        }

        try {
            /**** 03 - Update Model Record ****/
            $validated = $validator->validated();
            AbbottModel::find($id)->update($validated);

            /**** 04 - Return Success Response ****/
            return back()->with('success', 'Model updated successfully.');
        } catch (Exception $e) {
            /**** 05 - Handle Exception Error ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage())
                ->with('modal', 'updateModelModal-' . $id);
        }
    }

    // DELETE MODEL - FUNCTION
    public function deleteModel($id)
    {
        try {
            /**** 01 - Delete Model Record ****/
            AbbottModel::find($id)->delete();

            /**** 02 - Return Success Response ****/
            return back()->with('success', 'Model deleted successfully.');
        } catch (Exception $e) {
            /**** 03 - Handle Exception Error ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage());
        }
    }

    // ADD GENERATOR - FUNCTION
    public function addGenerator(Request $req)
    {
        /**** 01 - Validate Generator Form Data ****/
        $validator = Validator::make($req->all(), [
            'generator_name' => 'required|string',
            'generator_code' => 'required|string|unique:generators,generator_code',
            'generator_status' => 'required|integer',
        ], [], [
            'generator_name' => 'generator name',
            'generator_code' => 'generator code',
            'generator_status' => 'generator status',
        ]);

        /**** 02 - Handle Validation Failure ****/
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addGeneratorModal');
        }

        try {
            /**** 03 - Create New Generator Record ****/
            $validated = $validator->validated();
            Generator::create($validated);

            /**** 04 - Return Success Response ****/
            return back()->with('success', 'Generator added successfully.');
        } catch (Exception $e) {
            /**** 05 - Handle Exception Error ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage())
                ->with('modal', 'addGeneratorModal');
        }
    }

    // UPDATE GENERATOR - FUNCTION
    public function updateGenerator(Request $req, $id)
    {
        /**** 01 - Validate Generator Form Data ****/
        $validator = Validator::make($req->all(), [
            'generator_name' => 'required|string',
            'generator_code' => 'required|string|unique:generators,generator_code,' . $id,
            'generator_status' => 'required|integer',
        ], [], [
            'generator_name' => 'generator name',
            'generator_code' => 'generator code',
            'generator_status' => 'generator status',
        ]);

        /**** 02 - Handle Validation Failure ****/
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateGeneratorModal-' . $id);
        }

        try {
            /**** 03 - Update Existing Generator Record ****/
            $validated = $validator->validated();
            Generator::find($id)->update($validated);

            /**** 04 - Return Success Response ****/
            return back()->with('success', 'Generator updated successfully.');
        } catch (Exception $e) {
            /**** 05 - Handle Exception Error ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage())
                ->with('modal', 'updateGeneratorModal-' . $id);
        }
    }

    // DELETE GENERATOR - FUNCTION
    public function deleteGenerator($id)
    {
        try {
            /**** 01 - Delete Generator Record by ID ****/
            Generator::find($id)->delete();

            /**** 02 - Return Success Response ****/
            return back()->with('success', 'Generator deleted successfully.');
        } catch (Exception $e) {
            /**** 03 - Handle Exception Error ****/
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again. ' . $e->getMessage());
        }
    }
}
