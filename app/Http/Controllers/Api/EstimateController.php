<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\ProjectEstimantion;
use Helper;
use Auth;
use File;
use DB;

class EstimateController extends Controller{

    public function createEstimate(Request $request){
        $country = $request->code_of_design == 1 ? 'india_':'american_';
        $table = $country.$request->type_of_frame.'_wind_'.$request->wind_speed.'_span_'.$request->span;
        $estimate = DB::table($table)->where(['span' => $request->cc_span,'height' => $request->height])->first();
        $data = [
           'user_id' => Auth::id(),
           'project_name' => $request->project_name,
           'project_location' => $request->project_location,
           'code_of_design' => $request->code_of_design,
           'type_of_frame' => $request->type_of_frame,
           'wind_speed' => $request->wind_speed,
           'span' => $request->span,
           'width' => $request->cc_span,
           'height' => $request->height,
           'length_of_building' => $request->length_of_building,
           'main_frame_steel_m2' => $estimate->main_frame,
           'main_frame_steel_kg' => number_format($estimate->main_frame * $request->cc_span *$request->length_of_building),
           'top_purlin_m2' => Roofling_purlin($estimate->fm_roofing_purlin,$estimate->fc_roofing_purlin,$estimate->span),
           'top_purlin_kg' => number_format(Roofling_purlin($estimate->fm_roofing_purlin,$estimate->fc_roofing_purlin,$estimate->span) * $request->cc_span *$request->length_of_building),
           'side_wall_girt_m2' => Side_wall_girt($estimate->fm_total_side_wall_girt,$estimate->fc_total_side_wall_girt,$estimate->span),
           'side_wall_girt_kg' => number_format(Side_wall_girt($estimate->fm_total_side_wall_girt,$estimate->fc_total_side_wall_girt,$estimate->span)  * $request->cc_span *$request->length_of_building),
           'gable_end_girt_m2' => gable_end_girt($estimate->fm_total_gable_end_girt,$estimate->fc_total_gable_end_girt,$estimate->span),
           'gable_end_girt_kg' => number_format(gable_end_girt($estimate->fm_total_gable_end_girt,$estimate->fc_total_gable_end_girt,$estimate->span)* $request->cc_span *$request->length_of_building),
           'roofing_sheet_m2' => roofing_sheet($estimate->fm_total_roofing_sheet,$estimate->fc_total_roofing_sheet,$estimate->span),
           'roofing_sheet_kg' => number_format(roofing_sheet($estimate->fm_total_roofing_sheet,$estimate->fc_total_roofing_sheet,$estimate->span) *$request->cc_span *$request->length_of_building),
           'clading_sheet_m2' => clading_sheet($estimate->fm_total_clading_sheet,$estimate->fc_total_clading_sheet,$estimate->span),
           'clading_sheet_kg' => number_format(clading_sheet($estimate->fm_total_clading_sheet,$estimate->fc_total_clading_sheet,$estimate->span)*$request->cc_span *$request->length_of_building),
           'sag_rod_m2' => sag_rod($estimate->fm_sag_rod,$estimate->fc_sag_rod,$estimate->span),
           'sag_rod_kg' => number_format(sag_rod($estimate->fm_sag_rod,$estimate->fc_sag_rod,$estimate->span) * $request->cc_span * $request->length_of_building),
           'stay_brace_m2' => stay_brace($estimate->fm_stay_brace,$estimate->fc_stay_brace,$estimate->span),
           'stay_brace_kg' => number_format(stay_brace($estimate->fm_stay_brace,$estimate->fc_stay_brace,$estimate->span) * $request->cc_span * $request->length_of_building),
           'anchor_bolt_m2' => anchor_bolt($estimate->fm_anchor_bolt,$estimate->fc_anchor_bolt,$estimate->span),
           'anchor_bolt_kg' => number_format(anchor_bolt($estimate->fm_anchor_bolt,$estimate->fc_anchor_bolt,$estimate->span) * $request->cc_span * $request->length_of_building),
           'cleat_m2' => cleat_for_purlin_and_girt($estimate->fm_cleat_for_purlin_and_girt,$estimate->fc_cleat_for_purlin_and_girt,$estimate->span),
           'cleat_kg' => number_format(cleat_for_purlin_and_girt($estimate->fm_cleat_for_purlin_and_girt,$estimate->fc_cleat_for_purlin_and_girt,$estimate->span) * $request->cc_span * $request->length_of_building),
           'x_bracing_m2' => x_bracing($estimate->fm_x_bracing,$estimate->fc_x_bracing,$estimate->span),
           'x_bracing_kg' => number_format(x_bracing($estimate->fm_x_bracing,$estimate->fc_x_bracing,$estimate->span) * $request->cc_span * $request->length_of_building),
           'finishing_m2' => finishing($estimate->fm_finishing,$estimate->fc_finishing,$estimate->span),
           'finishing_kg' => number_format(finishing($estimate->fm_finishing,$estimate->fc_finishing,$estimate->span) * $request->cc_span * $request->length_of_building),
           'total_quantity_m2' => number_format(Roofling_purlin($estimate->fm_roofing_purlin,$estimate->fc_roofing_purlin,$estimate->span) + Side_wall_girt($estimate->fm_total_side_wall_girt,$estimate->fc_total_side_wall_girt,$estimate->span) + gable_end_girt($estimate->fm_total_gable_end_girt,$estimate->fc_total_gable_end_girt,$estimate->span) + roofing_sheet($estimate->fm_total_roofing_sheet,$estimate->fc_total_roofing_sheet,$estimate->span) + clading_sheet($estimate->fm_total_clading_sheet,$estimate->fc_total_clading_sheet,$estimate->span) + sag_rod($estimate->fm_sag_rod,$estimate->fc_sag_rod,$estimate->span) + stay_brace($estimate->fm_stay_brace,$estimate->fc_stay_brace,$estimate->span) + anchor_bolt($estimate->fm_anchor_bolt,$estimate->fc_anchor_bolt,$estimate->span) + cleat_for_purlin_and_girt($estimate->fm_cleat_for_purlin_and_girt,$estimate->fc_cleat_for_purlin_and_girt,$estimate->span) + x_bracing($estimate->fm_x_bracing,$estimate->fc_x_bracing,$estimate->span) + finishing($estimate->fm_finishing,$estimate->fc_finishing,$estimate->span) + $estimate->main_frame,2),
           'atotal_quantity_kg' => number_format((Roofling_purlin($estimate->fm_roofing_purlin,$estimate->fc_roofing_purlin,$estimate->span) + Side_wall_girt($estimate->fm_total_side_wall_girt,$estimate->fc_total_side_wall_girt,$estimate->span) + gable_end_girt($estimate->fm_total_gable_end_girt,$estimate->fc_total_gable_end_girt,$estimate->span) + roofing_sheet($estimate->fm_total_roofing_sheet,$estimate->fc_total_roofing_sheet,$estimate->span) + clading_sheet($estimate->fm_total_clading_sheet,$estimate->fc_total_clading_sheet,$estimate->span) + sag_rod($estimate->fm_sag_rod,$estimate->fc_sag_rod,$estimate->span) + stay_brace($estimate->fm_stay_brace,$estimate->fc_stay_brace,$estimate->span) + anchor_bolt($estimate->fm_anchor_bolt,$estimate->fc_anchor_bolt,$estimate->span) + cleat_for_purlin_and_girt($estimate->fm_cleat_for_purlin_and_girt,$estimate->fc_cleat_for_purlin_and_girt,$estimate->span) + x_bracing($estimate->fm_x_bracing,$estimate->fc_x_bracing,$estimate->span) + finishing($estimate->fm_finishing,$estimate->fc_finishing,$estimate->span) + $estimate->main_frame) * $request->cc_span * $request->length_of_building)
        ];
        ProjectEstimantion::create($data);
        return response()->json([$data], Response::HTTP_OK);
    }
}