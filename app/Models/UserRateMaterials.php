<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class UserRateMaterials extends Model{
    
    use HasFactory;
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = ['user_id', 'main_frame_steel', 'cold_form_purlin', 'side_wall_girt', 'gable_end_girt', 'roofing_sheet', 'side_cladding_sheet', 'sag_rod', 'cold_form_stay_brace', 'anchor_bolt','cleat','x_bracing','finishing','tie_beam'];

    protected $table = 'user_rates_materials';
    
}