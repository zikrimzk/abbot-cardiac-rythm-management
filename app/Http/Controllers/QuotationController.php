<?php

namespace App\Http\Controllers;

use App\Models\AbbottModel;
use Exception;
use Illuminate\Http\Request;
use App\Models\QuoteGeneratorModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\Extension\SmartPunct\Quote;

class QuotationController extends Controller
{
    public function addAssignGeneratorModel(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'generator_id' => 'required|integer',
            'model_ids' => 'nullable|array',
        ], [], [
            'generator_id' => 'generator',
            'model_ids' => 'model',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'addAssignmentModal');
        }

        try {

            $validated = $validator->validated();

            /**** 01 - Validate Generator & Model ****/
            $exist = QuoteGeneratorModel::where('generator_id', $validated['generator_id'])->first();
            if ($exist) {
                return redirect()->back()->with('error', 'Generator has already assigned.');
            }

            /**** 02 - Insert Generator and Model ****/
            if (!empty($validated['model_ids'])) {
                foreach ($validated['model_ids'] as $model_id) {
                    $am = AbbottModel::where('id', trim($model_id))->first();
                    if ($am) {
                        QuoteGeneratorModel::firstOrCreate([
                            'generator_id' => $validated['generator_id'],
                            'model_id' => $am->id
                        ]);
                    }
                }
            }

            return back()->with('success', 'Successfully assign generator and model.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to add assignment: ' . $e->getMessage());
        }
    }

    public function updateAssignGeneratorModel(Request $req, $generator_id)
    {
        $generator_id = Crypt::decrypt($generator_id);

        $validator = Validator::make($req->all(), [
            'model_ids' => 'nullable|array',
        ], [], [
            'model_ids' => 'model',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal', 'updateAssignmentModal-' . $generator_id);
        }

        try {
            $validated = $validator->validated();

            /**** 01 - Validate Generator Exists ****/
            $exist = QuoteGeneratorModel::where('generator_id', $generator_id)->first();
            if (!$exist) {
                return redirect()->back()->with('error', 'Generator does not exist.');
            }

            /**** 02 - Delete Old Assignments ****/
            QuoteGeneratorModel::where('generator_id', $generator_id)->delete();

            /**** 03 - Insert New Assignments ****/
            if (!empty($validated['model_ids'])) {
                foreach ($validated['model_ids'] as $model_id) {
                    $am = AbbottModel::where('id', trim($model_id))->first();
                    if ($am) {
                        QuoteGeneratorModel::firstOrCreate([
                            'generator_id' => $generator_id,
                            'model_id' => $am->id,
                        ]);
                    }
                }
            }

            return back()->with('success', 'Successfully updated generator and model assignment.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update assignment: ' . $e->getMessage());
        }
    }

     public function deleteAssignGeneratorModel($generator_id)
    {
        $generator_id = Crypt::decrypt($generator_id);

        try {

            /**** 01 - Validate Generator Exists ****/
            $exist = QuoteGeneratorModel::where('generator_id', $generator_id)->first();
            if (!$exist) {
                return redirect()->back()->with('error', 'Generator does not exist.');
            }

            /**** 02 - Delete Old Assignments ****/
            QuoteGeneratorModel::where('generator_id', $generator_id)->delete();

            return back()->with('success', 'Successfully deleted generator and model assignment.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update assignment: ' . $e->getMessage());
        }
    }
}
