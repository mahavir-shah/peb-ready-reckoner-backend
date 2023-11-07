<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class ProjectEstimantion extends Model{
    
    use HasFactory;
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = ['user_id', 'project_name', 'project_location', 'code_of_design', 'type_of_frame', 'wind_speed', 'span', 'width', 'height', 'length_of_building', 'main_frame_steel_m2', 'main_frame_steel_kg', 'top_purlin_m2', 'top_purlin_kg', 'side_wall_girt_m2', 'side_wall_girt_kg', 'gable_end_girt_m2', 'gable_end_girt_kg', 'roofing_sheet_m2', 'roofing_sheet_kg', 'clading_sheet_m2', 'clading_sheet_kg', 'sag_rod_m2', 'sag_rod_kg', 'stay_brace_m2', 'stay_brace_kg', 'anchor_bolt_m2', 'anchor_bolt_kg', 'cleat_m2', 'cleat_kg', 'x_bracing_m2', 'x_bracing_kg','tie_strut_m2','tie_strut_kg','gantry_girder_m2','gantry_girder_kg', 'finishing_m2', 'finishing_kg', 'total_quantity_m2', 'atotal_quantity_kg','gantry_girder_in_all_days','no_gable_on_both_side','city','state'];

    protected $table = 'project_estimantion';
    
}