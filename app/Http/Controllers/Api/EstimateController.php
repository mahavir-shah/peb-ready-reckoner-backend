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
use Barryvdh\DomPDF\Facade\Pdf;

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
           'main_frame_steel_kg' => round($estimate->main_frame * $request->cc_span *$request->length_of_building),
           'top_purlin_m2' => Roofling_purlin($estimate->fm_roofing_purlin,$estimate->fc_roofing_purlin,$estimate->span,$request->length_of_building),
           'top_purlin_kg' => round(Roofling_purlin($estimate->fm_roofing_purlin,$estimate->fc_roofing_purlin,$estimate->span,$request->length_of_building) * $request->cc_span *$request->length_of_building),
           'side_wall_girt_m2' => Side_wall_girt($estimate->fm_total_side_wall_girt,$estimate->fc_total_side_wall_girt,$estimate->span,$request->length_of_building),
           'side_wall_girt_kg' => round(Side_wall_girt($estimate->fm_total_side_wall_girt,$estimate->fc_total_side_wall_girt,$estimate->span,$request->length_of_building)  * $request->cc_span *$request->length_of_building),
           'gable_end_girt_m2' => gable_end_girt($estimate->fm_total_gable_end_girt,$estimate->fc_total_gable_end_girt,$estimate->span,$request->length_of_building),
           'gable_end_girt_kg' => round(gable_end_girt($estimate->fm_total_gable_end_girt,$estimate->fc_total_gable_end_girt,$estimate->span,$request->length_of_building)* $request->cc_span *$request->length_of_building),
           'roofing_sheet_m2' => roofing_sheet($estimate->fm_total_roofing_sheet,$estimate->fc_total_roofing_sheet,$estimate->span,$request->length_of_building),
           'roofing_sheet_kg' => round(roofing_sheet($estimate->fm_total_roofing_sheet,$estimate->fc_total_roofing_sheet,$estimate->span,$request->length_of_building) *$request->cc_span *$request->length_of_building),
           'clading_sheet_m2' => clading_sheet($estimate->fm_total_clading_sheet,$estimate->fc_total_clading_sheet,$estimate->span,$request->length_of_building),
           'clading_sheet_kg' => round(clading_sheet($estimate->fm_total_clading_sheet,$estimate->fc_total_clading_sheet,$estimate->span,$request->length_of_building)*$request->cc_span *$request->length_of_building),
           'sag_rod_m2' => sag_rod($estimate->fm_sag_rod,$estimate->fc_sag_rod,$estimate->span,$request->length_of_building),
           'sag_rod_kg' => round(sag_rod($estimate->fm_sag_rod,$estimate->fc_sag_rod,$estimate->span,$request->length_of_building) * $request->cc_span * $request->length_of_building),
           'stay_brace_m2' => stay_brace($estimate->fm_stay_brace,$estimate->fc_stay_brace,$estimate->span,$request->length_of_building),
           'stay_brace_kg' => round(stay_brace($estimate->fm_stay_brace,$estimate->fc_stay_brace,$estimate->span,$request->length_of_building) * $request->cc_span * $request->length_of_building),
           'anchor_bolt_m2' => anchor_bolt($estimate->fm_anchor_bolt,$estimate->fc_anchor_bolt,$estimate->span,$request->length_of_building),
           'anchor_bolt_kg' => round(anchor_bolt($estimate->fm_anchor_bolt,$estimate->fc_anchor_bolt,$estimate->span,$request->length_of_building) * $request->cc_span * $request->length_of_building),
           'cleat_m2' => cleat_for_purlin_and_girt($estimate->fm_cleat_for_purlin_and_girt,$estimate->fc_cleat_for_purlin_and_girt,$estimate->span,$request->length_of_building),
           'cleat_kg' => round(cleat_for_purlin_and_girt($estimate->fm_cleat_for_purlin_and_girt,$estimate->fc_cleat_for_purlin_and_girt,$estimate->span,$request->length_of_building) * $request->cc_span * $request->length_of_building),
           'x_bracing_m2' => x_bracing($estimate->fm_x_bracing,$estimate->fc_x_bracing,$estimate->span,$request->length_of_building),
           'x_bracing_kg' => round(x_bracing($estimate->fm_x_bracing,$estimate->fc_x_bracing,$estimate->span,$request->length_of_building) * $request->cc_span * $request->length_of_building),
           'tie_strut_m2' => tie_strut($estimate->fm_tie_strut,$estimate->fc_tie_strut,$estimate->span,$request->length_of_building),
           'tie_strut_kg' => round(tie_strut($estimate->fm_tie_strut,$estimate->fc_tie_strut,$estimate->span,$request->length_of_building) * $request->cc_span * $request->length_of_building),
           'gantry_girder_m2' => $request->gantry_girder_in_all_days == 1 ? gantry_girder($estimate->fm_gantry_girder,$estimate->fc_gantry_girder,$estimate->span,$request->length_of_building) : 0,
           'gantry_girder_kg' => $request->gantry_girder_in_all_days == 1 ? round(gantry_girder($estimate->fm_gantry_girder,$estimate->fc_gantry_girder,$estimate->span,$request->length_of_building) * $request->cc_span * $request->length_of_building) : 0,
           'finishing_m2' => finishing($estimate->fm_finishing,$estimate->fc_finishing,$estimate->span,$request->length_of_building),
           'finishing_kg' => round(finishing($estimate->fm_finishing,$estimate->fc_finishing,$estimate->span,$request->length_of_building) * $request->cc_span * $request->length_of_building),
           'total_quantity_m2' => number_format(Roofling_purlin($estimate->fm_roofing_purlin,$estimate->fc_roofing_purlin,$estimate->span,$request->length_of_building) + Side_wall_girt($estimate->fm_total_side_wall_girt,$estimate->fc_total_side_wall_girt,$estimate->span,$request->length_of_building) + gable_end_girt($estimate->fm_total_gable_end_girt,$estimate->fc_total_gable_end_girt,$estimate->span,$request->length_of_building) + roofing_sheet($estimate->fm_total_roofing_sheet,$estimate->fc_total_roofing_sheet,$estimate->span,$request->length_of_building) + clading_sheet($estimate->fm_total_clading_sheet,$estimate->fc_total_clading_sheet,$estimate->span,$request->length_of_building) + sag_rod($estimate->fm_sag_rod,$estimate->fc_sag_rod,$estimate->span,$request->length_of_building) + stay_brace($estimate->fm_stay_brace,$estimate->fc_stay_brace,$estimate->span,$request->length_of_building) + anchor_bolt($estimate->fm_anchor_bolt,$estimate->fc_anchor_bolt,$estimate->span,$request->length_of_building) + cleat_for_purlin_and_girt($estimate->fm_cleat_for_purlin_and_girt,$estimate->fc_cleat_for_purlin_and_girt,$estimate->span,$request->length_of_building) + x_bracing($estimate->fm_x_bracing,$estimate->fc_x_bracing,$estimate->span,$request->length_of_building) + tie_strut($estimate->fm_tie_strut,$estimate->fc_tie_strut,$estimate->span,$request->length_of_building) + finishing($estimate->fm_finishing,$estimate->fc_finishing,$estimate->span,$request->length_of_building,$request->length_of_building) + $estimate->main_frame + with_ganty($estimate->fm_gantry_girder,$estimate->fc_gantry_girder,$estimate->span,$request->gantry_girder_in_all_days,$request->length_of_building),2),
           'atotal_quantity_kg' =>round((Roofling_purlin($estimate->fm_roofing_purlin,$estimate->fc_roofing_purlin,$estimate->span,$request->length_of_building) + Side_wall_girt($estimate->fm_total_side_wall_girt,$estimate->fc_total_side_wall_girt,$estimate->span,$request->length_of_building) + gable_end_girt($estimate->fm_total_gable_end_girt,$estimate->fc_total_gable_end_girt,$estimate->span,$request->length_of_building) + roofing_sheet($estimate->fm_total_roofing_sheet,$estimate->fc_total_roofing_sheet,$estimate->span,$request->length_of_building) + clading_sheet($estimate->fm_total_clading_sheet,$estimate->fc_total_clading_sheet,$estimate->span,$request->length_of_building) + sag_rod($estimate->fm_sag_rod,$estimate->fc_sag_rod,$estimate->span,$request->length_of_building) + stay_brace($estimate->fm_stay_brace,$estimate->fc_stay_brace,$estimate->span,$request->length_of_building) + anchor_bolt($estimate->fm_anchor_bolt,$estimate->fc_anchor_bolt,$estimate->span,$request->length_of_building) + cleat_for_purlin_and_girt($estimate->fm_cleat_for_purlin_and_girt,$estimate->fc_cleat_for_purlin_and_girt,$estimate->span,$request->length_of_building) + x_bracing($estimate->fm_x_bracing,$estimate->fc_x_bracing,$estimate->span,$request->length_of_building) + tie_strut($estimate->fm_tie_strut,$estimate->fc_tie_strut,$estimate->span,$request->length_of_building)+ finishing($estimate->fm_finishing,$estimate->fc_finishing,$estimate->span,$request->length_of_building) + $estimate->main_frame + with_ganty($estimate->fm_gantry_girder,$estimate->fc_gantry_girder,$estimate->span,$request->gantry_girder_in_all_days,$request->length_of_building)) * $request->cc_span * $request->length_of_building),
           'gantry_girder_in_all_days' => $request->gantry_girder_in_all_days,
           'no_gable_on_both_side' => $request->no_gable_on_both_side,
           'city' => $request->city,
           'state' => $request->state,
        ];
       $id = ProjectEstimantion::create($data)->id;
       $data['id'] =  $id;
        return response()->json([$data], Response::HTTP_OK);
    }

    public function exportEstimate($id){
        $estimate = ProjectEstimantion::find($id)->toArray();
        $pdf = PDF::loadView('estimatePdf', $estimate);
    
        return $pdf->download('estimatePdf.pdf');
    }

    public function  getEstimateHistory(){
       $data =  ProjectEstimantion::select('id','project_name', 'project_location','type_of_frame', 'wind_speed', 'span', 'width', 'height','city','state')->where('user_id',Auth::id())->get();

       return response()->json($data, Response::HTTP_OK);
    }

    public function  getEstimateHistoryDetails(Request $request){
        $data =  ProjectEstimantion::where('id',$request->id)->first();
        $data['top_purlin_m2'] = number_format($data->top_purlin_m2,2);
        $data['side_wall_girt_m2'] = number_format($data->side_wall_girt_m2,2);
        $data['gable_end_girt_m2'] = number_format($data->gable_end_girt_m2,2);
        $data['roofing_sheet_m2'] = number_format($data->roofing_sheet_m2,2);
        $data['clading_sheet_m2'] = number_format($data->clading_sheet_m2,2);
        $data['sag_rod_m2'] = number_format($data->sag_rod_m2,2);
        $data['stay_brace_m2'] = number_format($data->stay_brace_m2,2);
        $data['anchor_bolt_m2'] = number_format($data->anchor_bolt_m2,2);
        $data['cleat_m2'] = number_format($data->cleat_m2,2);
        $data['x_bracing_m2'] = number_format($data->x_bracing_m2,2);
        $data['tie_strut_m2'] = number_format($data->tie_strut_m2,2);
        $data['gantry_girder_m2'] = number_format($data->gantry_girder_m2,2);
        $data['finishing_m2'] = number_format($data->finishing_m2,2);
        $data['total_quantity_m2'] = number_format($data->total_quantity_m2,2);
        return response()->json([$data], Response::HTTP_OK);
     }
}