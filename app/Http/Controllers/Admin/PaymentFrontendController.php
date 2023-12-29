<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use Session;
use App\Models\User;
use App\Models\UserPlanDetail;
use App\Models\UserPlanHistory;
use App\Models\CreditHistory;
use App\Models\SubscriptionPlan;
use Helper;
use Hash;
use Validator;
use Carbon\Carbon;

class PaymentFrontendController extends Controller
{
    public function payment($plan,$id){
        $user = User::where('id',$id)->get()->first();
        $price = SubscriptionPlan::select('amount')->where('plan_name',$plan)->first()->amount;
        $currentDateTime = Carbon::now();
        $expirt_date = Carbon::now()->addMonths(1)->format('d/m/Y');
        return view('payment',compact('user','plan','price','expirt_date'));
    }

    public function paymentProcess(Request $request) {
        $count = UserPlanDetail::where('user_id',$request->user_id)->count();
        if($count == 0){
            UserPlanDetail::create([
                'user_id' => $request->user_id,
                'plan_name' => $request->plan_name,
                'payment_detail' => '',
                'plan_expirey_date' => Carbon::now()->addMonths(1),
            ]);
        }else{
             UserPlanDetail::where('user_id',$request->user_id)->update([
                'user_id' => $request->user_id,
                'plan_name' => $request->plan_name,
                'payment_detail' =>'',
                'plan_expirey_date' => Carbon::now()->addMonths(1),
            ]);
        }
        UserPlanHistory::create([
            'user_id' => $request->user_id,
            'plan_name' => $request->plan_name,
            'payment_detail' => '',
            'plan_expirey_date' => Carbon::now()->addMonths(1),
        ]);

        User::where('id',$request->user_id)->update([
            'selected_plan' => $request->plan_name,
            'plan_status' => 1
        ]);

        echo "Payment Done";
        // return redirect('http://localhost:5173/');
    }

    public function addCredit($amount,$id) {
        $user = User::find($id);
        
        $headers = array(
            "Content-Type: application/json",
            "x-api-version: 2022-01-01",
            "x-client-id: ".env('CASHFREE_API_TEST_KEY'),
            "x-client-secret: ".env('CASHFREE_API_TEST_SECRET')
       );
       $url = "https://sandbox.cashfree.com/pg/orders";
       
       $data = json_encode([
            'order_id' =>  'order_'.rand(1111111111,9999999999),
            'order_amount' => $amount,
            "order_currency" => "INR",
            "customer_details" => [
                 "customer_id" => 'customer_'.rand(111111111,999999999),
                 "customer_name" => $user->name,
                 "customer_email" => $user->email,
                 "customer_phone" => $user->mobile_no,
            ],
            "order_meta" => [
                 "return_url" => env('API_URL').'/credit/payments/return/?order_id={order_id}&order_token={order_token}'
            ]
       ]);
      
       $curl = curl_init($url);

       curl_setopt($curl, CURLOPT_URL, $url);
       curl_setopt($curl, CURLOPT_POST, true);
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

       $resp = curl_exec($curl);

       curl_close($curl);
       //echo '<pre>'; print_r($resp); die();
       return redirect()->to(json_decode($resp)->payment_link);
    }
    public function returnUrl(Request $request){
        //dd($request->all());
        $headers = array(
            "Content-Type: application/json",
            "x-api-version: 2022-01-01",
            "x-client-id: ".env('CASHFREE_API_TEST_KEY'),
            "x-client-secret: ".env('CASHFREE_API_TEST_SECRET')
       );

        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => "https://sandbox.cashfree.com/pg/orders/".$request->order_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {

        echo "cURL Error #:" . $err;
        } else {
            $order_details = json_decode($response,true);
          // echo '<pre>'; print_r($order_details);
           if($order_details['order_status'] == 'PAID'){
                $user = User::select('id','credit')->where(['email' => $order_details['customer_details']['customer_email'], 'name' => $order_details['customer_details']['customer_name'], 'mobile_no' => $order_details['customer_details']['customer_phone']])->get()->first();
                CreditHistory::create([
                    'user_id' => $user->id,
                    'amount' => $order_details['order_amount'],
                    'cf_order_id' => $order_details['cf_order_id'],
                    'order_id' => $order_details['order_id'],
                    'order_token' => $order_details['order_token'],
                    'transection_date' => now(),
                ]);
                User::where('id',$user->id)->update([
                    'credit' => $user->credit + $order_details['order_amount'],
                ]);
                return redirect()->route('afterSuccess');
           }else{
                return redirect()->route('afterCancel');
           }
        }
    }

    public function afterSuccess(){
        return view('admin.payment.sucess');
    }

    public function afterCancel(){
        return view('admin.payment.cancel');
    }
}