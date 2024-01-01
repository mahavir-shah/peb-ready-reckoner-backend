<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\UserPlanHistory;
use App\Models\SubscriptionPlan;
use App\Models\CreditHistory;
use Auth;
use File;

class PaymentController extends Controller{

    public function getPaymentHistory(Request $request){
        $data = UserPlanHistory::select('id','plan_name','created_at','plan_expirey_date')->where('user_id',$request->id)->get();
        foreach($data as $key=>$payment){
            $pdata[$key]['id'] = ucfirst($payment->id);
            $pdata[$key]['plan_name'] = ucfirst($payment->plan_name);
            $pdata[$key]['amount'] = SubscriptionPlan::select('amount')->where('plan_name',$payment->plan_name)->first()->amount;
            $pdata[$key]['created_date'] = date('d M Y', strtotime($payment->created_at));
            $pdata[$key]['plan_expirey_date'] = date('d M Y', strtotime($payment->plan_expirey_date));
        }
        return response()->json($pdata, Response::HTTP_OK);
    }
    public function getPlanName(){
        $data = SubscriptionPlan::select('id','plan_name','amount','duration','estimate_per_day')->get();
        foreach($data as $key=>$payment){
            $data[$key]['id'] = ucfirst($payment->id);
            $data[$key]['plan_name'] = ucfirst($payment->plan_name);
            $data[$key]['amount'] = $payment->amount;
        }
        return response()->json($data, Response::HTTP_OK);
    }
    public function getUserDetails(Request $request){
        $user_data = User::where('id', $request->id)->first();

        if($user_data->profile_img != null){
            $user_data['profile_img'] = env('APP_URL').'/upload/profile_img/'.$user_data->profile_img;
        }else{
            $user_data['profile_img'] = env('APP_URL').'/images/dummy_profile.png';
        }
		return response()->json([$user_data]);
    }

    public function getUserCredit(Request $request){
        $credit = CreditHistory::where()->get();
    }
}