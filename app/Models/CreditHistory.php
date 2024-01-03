<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class CreditHistory extends Model{
    
    use HasFactory;
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = ['user_id', 'amount', 'cf_order_id','order_id','order_token','payment_group','payment_method_details','transection_date'];

    protected $table = 'credit_history';
    
}