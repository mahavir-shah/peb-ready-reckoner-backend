<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class UserPlanDetail extends Model{
    
    use HasFactory;
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = ['user_id', 'plan_name', 'subscriptionId','planId','subReferenceId','authLink','plan_status','payment_detail', 'plan_expirey_date'];

    protected $table = 'user_plan_detail';
}