<?php

function Roofling_purlin($fm_roof_purlin,$fc_roof_purlin,$span){
    return number_format((($fm_roof_purlin - $fc_roof_purlin) / ($span * 60)) + ($fc_roof_purlin / (60 * $span)),2);
}

function Side_wall_girt($fm_side_wall,$fc_side_wall,$span){
    return number_format((($fm_side_wall - $fc_side_wall) / ($span * 60)) + ($fc_side_wall / (60 * $span)),2);
}

function gable_end_girt($fm_gable_end_girt,$fc_gable_end_girt,$span){
    return number_format((($fm_gable_end_girt - $fc_gable_end_girt) / ($span * 60)) + ($fc_gable_end_girt / (60 * $span)),2);
}

function roofing_sheet($fm_total_roofing_sheet,$fc_total_roofing_sheet,$span){
    return number_format((($fm_total_roofing_sheet - $fc_total_roofing_sheet) / ($span * 60)) + ($fc_total_roofing_sheet / (60 * $span)),2);
}

function clading_sheet($fm_clading_sheet,$fc_clading_sheet,$span){
    return number_format((($fm_clading_sheet - $fc_clading_sheet) / ($span * 60)) + ($fc_clading_sheet / (60 * $span)),2);
}

function sag_rod($fm_sag_rod,$fc_sag_rod,$span){
    return number_format((($fm_sag_rod - $fc_sag_rod) / ($span * 60)) + ($fc_sag_rod / (60 * $span)),2);
}

function stay_brace($fm_stay_brace,$fc_stay_brace,$span){
    return number_format((($fm_stay_brace - $fc_stay_brace) / ($span * 60)) + ($fc_stay_brace / (60 * $span)),2);
}

function anchor_bolt($fm_anchor_bolt,$fc_anchor_bolt,$span){
    return number_format((($fm_anchor_bolt - $fc_anchor_bolt) / ($span * 60)) + ($fc_anchor_bolt / (60 * $span)),2);
}

function cleat_for_purlin_and_girt($fm_cleat,$fc_cleat,$span){
    return number_format((($fm_cleat - $fc_cleat) / ($span * 60)) + ($fc_cleat / (60 * $span)),2);
}

function x_bracing($fm_x_bracing,$fc_x_bracing,$span){
    return number_format((($fm_x_bracing - $fc_x_bracing) / ($span * 60)) + ($fc_x_bracing / (60 * $span)),2);
}

function finishing($fm_finishing,$fc_finishing,$span){
    return number_format((($fm_finishing - $fc_finishing) / ($span * 60)) + ($fc_finishing / (60 * $span)),2);
}

function total_quantity_m2(){
    
}