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
    protected $fillable = ['user_id', 'project_name', 'project_location', 'code_of_design', 'type_of_frame', 'wind_speed', 'span', 'width', 'height	', 'length_of_building'];

    protected $table = 'project_estimantion';
    
}