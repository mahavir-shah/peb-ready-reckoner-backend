<?php

function Roofling_purlin($fm_roof_purlin,$fc_roof_purlin,$span,$lenght,$gable,$standing_seam){
    if($standing_seam == 1){
        $formula = (($fm_roof_purlin - $fc_roof_purlin) / ($span * 60));
    }else{
        $formula = ((($fm_roof_purlin - $fc_roof_purlin) / ($span * 60)) + ($fc_roof_purlin / ($lenght * $span)));
    }
    if($gable == 0){
        return number_format($formula,2);
    }else{
        return number_format($formula * 1.25,2);
    }
}

function Side_wall_girt($fm_side_wall,$fc_side_wall,$span,$lenght,$standing_seam){
    if($standing_seam == 1){
        return number_format((($fm_side_wall - $fc_side_wall) / ($span * 60)),2);
    }else{
        return number_format((($fm_side_wall - $fc_side_wall) / ($span * 60)) + ($fc_side_wall / ($lenght * $span)),2);
    }
}

function gable_end_girt($fm_gable_end_girt,$fc_gable_end_girt,$span,$lenght,$standing_seam){
    if($standing_seam == 1){
        return number_format((($fm_gable_end_girt - $fc_gable_end_girt) / ($span * 60)),2);
    }else{
        return number_format((($fm_gable_end_girt - $fc_gable_end_girt) / ($span * 60)) + ($fc_gable_end_girt / ($lenght * $span)),2);
    }
}

function roofing_sheet($fm_total_roofing_sheet,$fc_total_roofing_sheet,$span,$lenght,$standing_seam){
    if($standing_seam == 1){
        return number_format((($fm_total_roofing_sheet - $fc_total_roofing_sheet) / ($span * 60)),2);
    }else{
        return number_format((($fm_total_roofing_sheet - $fc_total_roofing_sheet) / ($span * 60)) + ($fc_total_roofing_sheet / ($lenght * $span)),2);
    }
}

function clading_sheet($fm_clading_sheet,$fc_clading_sheet,$span,$lenght,$standing_seam){
    if($standing_seam == 1){
        return number_format((($fm_clading_sheet - $fc_clading_sheet) / ($span * 60)),2);
    }else{
        return number_format((($fm_clading_sheet - $fc_clading_sheet) / ($span * 60)) + ($fc_clading_sheet / ($lenght * $span)),2);
    }
    return number_format((($fm_clading_sheet - $fc_clading_sheet) / ($span * 60)) + ($fc_clading_sheet / ($lenght * $span)),2);
}

function sag_rod($fm_sag_rod,$fc_sag_rod,$span,$lenght,$standing_seam){
    if($standing_seam == 1){
        return number_format((($fm_sag_rod - $fc_sag_rod) / ($span * 60)),2);
    }else{
        return number_format((($fm_sag_rod - $fc_sag_rod) / ($span * 60)) + ($fc_sag_rod / ($lenght * $span)),2);
    }
    return number_format((($fm_sag_rod - $fc_sag_rod) / ($span * 60)) + ($fc_sag_rod / ($lenght * $span)),2);
}

function stay_brace($fm_stay_brace,$fc_stay_brace,$span,$lenght,$standing_seam){
    if($standing_seam == 1){
        return number_format((($fm_stay_brace - $fc_stay_brace) / ($span * 60)),2);
    }else{
        return number_format((($fm_stay_brace - $fc_stay_brace) / ($span * 60)) + ($fc_stay_brace / ($lenght * $span)),2);
    }
    return number_format((($fm_stay_brace - $fc_stay_brace) / ($span * 60)) + ($fc_stay_brace / ($lenght * $span)),2);
}

function anchor_bolt($fm_anchor_bolt,$fc_anchor_bolt,$span,$lenght,$standing_seam){
    if($standing_seam == 1){
        return number_format((($fm_anchor_bolt - $fc_anchor_bolt) / ($span * 60)),2);
    }else{
        return number_format((($fm_anchor_bolt - $fc_anchor_bolt) / ($span * 60)) + ($fc_anchor_bolt / ($lenght * $span)),2);
    }
    return number_format((($fm_anchor_bolt - $fc_anchor_bolt) / ($span * 60)) + ($fc_anchor_bolt / ($lenght * $span)),2);
}

function cleat_for_purlin_and_girt($fm_cleat,$fc_cleat,$span,$lenght,$standing_seam){
    if($standing_seam == 1){
        return number_format((($fm_cleat - $fc_cleat) / ($span * 60)),2);
    }else{
        return number_format((($fm_cleat - $fc_cleat) / ($span * 60)) + ($fc_cleat / ($lenght * $span)),2);
    }
    return number_format((($fm_cleat - $fc_cleat) / ($span * 60)) + ($fc_cleat / ($lenght * $span)),2);
}

function x_bracing($fm_x_bracing,$fc_x_bracing,$span,$lenght,$standing_seam){
    if($standing_seam == 1){
        return number_format((($fm_x_bracing - $fc_x_bracing) / ($span * 60)),2);
    }else{
        return number_format((($fm_x_bracing - $fc_x_bracing) / ($span * 60)) + ($fc_x_bracing / ($lenght * $span)),2);
    }
    return number_format((($fm_x_bracing - $fc_x_bracing) / ($span * 60)) + ($fc_x_bracing / ($lenght * $span)),2);
}

function tie_strut($fm_tie_strut,$fc_tie_strut,$span,$lenght,$standing_seam){
    if($standing_seam == 1){
        return number_format((($fm_tie_strut - $fc_tie_strut) / ($span * 60)),2);
    }else{
        return number_format((($fm_tie_strut - $fc_tie_strut) / ($span * 60)) + ($fc_tie_strut / ($lenght * $span)),2);
    }
    return number_format((($fm_tie_strut - $fc_tie_strut) / ($span * 60)) + ($fc_tie_strut / ($lenght * $span)),2);
}

function gantry_girder($fm_gantry_girder,$fc_gantry_girder,$span,$lenght,$standing_seam){
    if($standing_seam == 1){
        return number_format((($fm_gantry_girder - $fc_gantry_girder) / ($span * 60)),2);
    }else{
        return number_format((($fm_gantry_girder - $fc_gantry_girder) / ($span * 60)) + ($fc_gantry_girder / ($lenght * $span)),2);
    }
    return number_format((($fm_gantry_girder - $fc_gantry_girder) / ($span * 60)) + ($fc_gantry_girder / ($lenght * $span)),2);
}

function finishing($fm_finishing,$fc_finishing,$span,$lenght,$standing_seam){
    if($standing_seam == 1){
        return number_format((($fm_finishing - $fc_finishing) / ($span * 60)),2);
    }else{
        return number_format((($fm_finishing - $fc_finishing) / ($span * 60)) + ($fc_finishing / ($lenght * $span)),2);
    }
    return number_format((($fm_finishing - $fc_finishing) / ($span * 60)) + ($fc_finishing / ($lenght * $span)),2);
}

function with_ganty($fm_gantry_girder,$fc_gantry_girder,$span,$gantry,$lenght,$standing_seam){
    if($gantry == 1){
        if($standing_seam == 1){
            return number_format((($fm_gantry_girder - $fc_gantry_girder) / ($span * 60)),2);
        }else{
            return number_format((($fm_gantry_girder - $fc_gantry_girder) / ($span * 60)) + ($fc_gantry_girder / ($lenght * $span)),2);
        }
        return number_format((($fm_gantry_girder - $fc_gantry_girder) / ($span * 60)) + ($fc_gantry_girder / ($lenght * $span)),2);
    }else{
        return 0;
    }
}