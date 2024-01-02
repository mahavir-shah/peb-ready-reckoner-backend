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
        //echo Carbon::now()->addDays(2)->format('Y-m-d'); die();
        $user = User::find($id);
        
        $headers = array(
            "Content-Type: application/json",
            "x-client-id: ".env('CASHFREE_API_TEST_KEY'),
            "x-client-secret: ".env('CASHFREE_API_TEST_SECRET')
       );

       if($plan == 'basic'){
            $plan_details = SubscriptionPlan::where('plan_name',$plan)->get()->first();
            $amount = $plan_details->amount;
            $subscriptionId = 'pebr_sub_pebr_basic_'.$plan_details->amount.'_'.$id.rand(111,999);
            $planId = 'pebr_basic_'.$plan_details->amount;
       }
       if($plan == 'premium'){
            $plan_details = SubscriptionPlan::where('plan_name',$plan)->get()->first();
            $amount = $plan_details->amount;
            $subscriptionId = 'pebr_sub_pebr_premium_'.$plan_details->amount.'_'.$id.rand(111,999);
            $planId = 'pebr_premium_'.$plan_details->amount;
       }
       
       if($plan == 'pletinum'){
            $plan_details = SubscriptionPlan::where('plan_name',$plan)->get()->first();
            $amount = $plan_details->amount;
            $subscriptionId = 'pebr_sub_pebr_pletinum_'.$plan_details->amount.'_'.$id.rand(111,999);
            $planId = 'pebr_pletinum_'.$plan_details->amount;
       }

       $data = json_encode([
            "subscriptionId"=> $subscriptionId,
            "planId"=> $planId,
            "customerName"=> $user->name,
            "customerEmail"=> $user->email,
            "customerPhone"=> $user->mobile_no,
            "planDetails"=> [
                "planName"=> ucfirst($plan),
                "type"=> "PERIODIC",
                "maxCycles"=> 0,
                "recurringAmount"=> $amount,
                "mandateAmount"=> $amount,
                "intervalType"=> "MONTH",
                "intervals"=> 1
            ],
            "firstChargeDate"=> Carbon::now()->addDays(2)->format('Y-m-d'),
            "expiresOn"=> null,
            "authAmount"=> $amount,
            "returnUrl"=>env('API_URL').'/subscription/payments/return/?sid='.$subscriptionId.'&pid='.$planId.'&id='.$id,
            // "returnUrl"=>env('API_URL').'/subscription/payments/return/',
            "notificationChannels"=> []
        ]);

       $curl = curl_init();
                curl_setopt_array($curl, [
                CURLOPT_URL => "https://test.cashfree.com/api/v2/subscriptions/nonSeamless/subscription",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>$data,
                CURLOPT_HTTPHEADER => $headers,
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                echo "cURL Error #:" . $err;
                } else {
                    $data = json_decode($response,true);
                    //echo '<pre>'; print_r($data['data']); die();
                    $count = UserPlanDetail::where(['user_id'=> $id,'plan_name' => $plan])->count();
                        if($count == 0 || !isset($count)){
                            UserPlanDetail::create([
                                'user_id' => $id,
                                'plan_name' => $plan,
                                'subscriptionId' => $subscriptionId,
                                'planId' => $planId,
                                'subReferenceId' => $data['data']['subReferenceId'],
                                'authLink' => $data['data']['authLink'],
                                'payment_detail' => '',
                                'plan_expirey_date' => Carbon::now()->addMonths(1),
                            ]);
                        }else{
                            UserPlanDetail::where(['user_id'=> $id,'plan_name' => $plan])->update([
                                'user_id' => $id,
                                'plan_name' => $plan,
                                'subscriptionId' => $subscriptionId,
                                'planId' => $planId,
                                'subReferenceId' => $data['data']['subReferenceId'],
                                'authLink' => $data['data']['authLink'], 
                                'payment_detail' =>'',
                                'plan_expirey_date' => Carbon::now()->addMonths(1),
                            ]);
                        }

                    return redirect()->to($data['data']['authLink']);
                }
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

    public function subscriptionReturnUrl(Request $request){
        UserPlanDetail::where(['subscriptionId' => $request->subscriptionId ,'planId' => $request->planId,'user_id' => $request->id])->update([
            'plan_status' => 1
        ]);
        $UserPlanDetail = UserPlanDetail::where(['subscriptionId' => $request->sid ,'planId' => $request->pid,'user_id' => $request->id])->get()->first();
        //echo '<pre>'; print_r($request->all()); die();
        $headers = array(
            "Content-Type: application/json",
            "x-client-id: ".env('CASHFREE_API_TEST_KEY'),
            "x-client-secret: ".env('CASHFREE_API_TEST_SECRET')
       );
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://test.cashfree.com/api/v2/subscriptions/'.$UserPlanDetail->subReferenceId,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => $headers
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $data = json_decode($response,true);
        if($data['subscription']['status'] == 'ACTIVE'){
            // UserPlanHistory::create([
            //     'user_id' => $request->user_id,
            //     'plan_name' => $request->plan_name,
            //     'subscriptionId' => $request->subscriptionId,
            //     'planId' => $request->planId,
            //     'subReferenceId' => $UserPlanDetail->subReferenceId,
            //     'authLink' => $UserPlanDetail->authLink,
            //     'payment_detail' => '',
            //     'plan_expirey_date' => Carbon::now()->addMonths(1),
            // ]);
            // User::where('id',$request->user_id)->update([
            //     'selected_plan' => $request->plan_name,
            //     'plan_status' => 1
            // ]);
            return redirect()->route('afterSubscriptionSuccess');
        }else{
            return redirect()->route('afterSubscriptionCancel',$UserPlanDetail->authLink);
        }   
    }

    public function afterSubscriptionSuccess(){
        return view('admin.payment.subscription.sucess');
    }

    public function afterSubscriptionCancel($url){
        return view('admin.payment.subscription.cancel',compact('url'));
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