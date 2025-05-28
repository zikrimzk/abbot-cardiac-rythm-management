<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesBillingController extends Controller
{
    // Generate Iventory Consumption Form (Preview) Function
    public function previewICF(Request $request)
    {
        try {
            $modelCategories = DB::table('model_categories')
                ->select('id as model_category_id', 'mcategory_abbreviation as model_category')
                ->where('mcategory_abbreviation', '!=', null)
                ->get();

            $implant = DB::table('implants as a')
                ->join('generators as b', 'a.generator_id', '=', 'b.id')
                ->join('regions as c', 'a.region_id', '=', 'c.id')
                ->join('hospitals as d', 'a.hospital_id', '=', 'd.id')
                ->join('doctors as e', 'a.doctor_id', '=', 'e.id')
                ->leftJoin('stock_locations as f', 'a.stock_location_id', '=', 'f.id')
                ->leftJoin('product_group_lists as g', 'a.id', '=', 'g.implant_id')
                ->leftJoin('product_groups as h', 'g.product_group_id', '=', 'h.id')
                ->where('a.id', $request->id)
                ->select([
                    'a.id',
                    'a.implant_date',
                    'a.implant_refno',
                    'd.hospital_name',
                    'd.hospital_phoneno',
                    'd.hospital_code',
                    'e.doctor_name',
                    'e.doctor_phoneno',
                    'b.generator_name',
                    'b.generator_code',
                    'a.implant_generator_sn',
                    'a.implant_generator_qty',
                    'a.implant_generator_itemPrice',
                    'a.implant_pt_name',
                    'a.implant_pt_address',
                    'a.implant_pt_directory',
                    'a.implant_pt_mrn',
                    'a.implant_pt_icno',
                    'f.stock_location_name',
                    'f.stock_location_code',
                ])
                ->groupBy(
                    'a.id',
                    'a.implant_date',
                    'a.implant_refno',
                    'd.hospital_name',
                    'd.hospital_phoneno',
                    'd.hospital_code',
                    'e.doctor_name',
                    'e.doctor_phoneno',
                    'b.generator_name',
                    'b.generator_code',
                    'a.implant_generator_sn',
                    'a.implant_generator_qty',
                    'a.implant_generator_itemPrice',
                    'a.implant_pt_name',
                    'a.implant_pt_address',
                    'a.implant_pt_directory',
                    'a.implant_pt_mrn',
                    'a.implant_pt_icno',
                    'f.stock_location_name',
                    'f.stock_location_code',
                )
                ->first();

            $models = DB::table('implant_models as i')
                ->join('abbott_models as j', 'i.model_id', '=', 'j.id')
                ->join('model_categories as k', 'j.mcategory_id', '=', 'k.id')
                ->join('stock_locations as l', 'i.stock_location_id', '=', 'l.id')
                ->where('i.implant_id', $request->id)
                ->select([
                    'k.id as model_category_id',
                    'k.mcategory_name as model_category',
                    'j.model_name',
                    'j.model_code',
                    'i.implant_model_sn',
                    'i.implant_model_qty',
                    'i.implant_model_itemPrice',
                    'l.stock_location_name',
                    'l.stock_location_code'
                ])
                ->get();

            $mergedModels = [];
            foreach ($modelCategories as $category) {
                $foundModel = $models->firstWhere('model_category_id', $category->model_category_id);

                $mergedModels[] = [
                    'model_category_id' => $category->model_category_id,
                    'model_category' => $category->model_category,
                    'model_name' => $foundModel->model_name ?? '-',
                    'model_code' => $foundModel->model_code ?? '-',
                    'implant_model_sn' => $foundModel->implant_model_sn ?? '-',
                    'implant_model_qty' => $foundModel->implant_model_qty ?? 0,
                    'implant_model_itemPrice' => $foundModel->implant_model_itemPrice ?? 0,
                    'stock_location_name' => $foundModel->stock_location_name ?? '-',
                    'stock_location_code' => $foundModel->stock_location_code ?? '-',
                ];
            }

            $formattedData = [
                'id' => $implant->id ?? '-',
                'implant_date' => Carbon::parse($implant->implant_date)->format('d M Y') ?? '-',
                'implant_refno' => $implant->implant_refno ?? '-',
                'hospital_name' => Str::upper($implant->hospital_name) ?? '-',
                'hospital_phoneno' => $implant->hospital_phoneno ?? '-',
                'hospital_code' => $implant->hospital_code ?? '-',
                'doctor_name' => Str::upper($implant->doctor_name) ?? '-',
                'doctor_phoneno' => $implant->doctor_phoneno ?? '-',
                'generator_name' => Str::upper($implant->generator_name) ?? '-',
                'generator_code' => Str::upper($implant->generator_code) ?? '-',
                'implant_generator_sn' => $implant->implant_generator_sn ?? '-',
                'implant_generator_qty' => $implant->implant_generator_qty ?? 0,
                'implant_generator_itemPrice' => $implant->implant_generator_itemPrice ?? 0,
                'implant_pt_name' => Str::upper($implant->implant_pt_name) ?? '-',
                'implant_pt_address' => $implant->implant_pt_address ?? '-',
                'implant_pt_directory' => $implant->implant_pt_directory ?? '-',
                'implant_pt_mrn' => $implant->implant_pt_mrn ?? '-',
                'implant_pt_icno' => $implant->implant_pt_icno ?? '-',
                'stock_location_name' => Str::upper($implant->stock_location_name) ?? '-',
                'stock_location_code' => $implant->stock_location_code ?? '-',
                'models' => $mergedModels,
            ];
          
            $html = view('crmd-system.sales-billing.icf-generator', [
                'data' => $formattedData,
            ])->render();
            return response()->json(['html' => $html]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
