<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Designation extends Model{
    
    use HasFactory;
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = ['designation_title','is_deleted'];

    protected $table = 'designation';
    
}