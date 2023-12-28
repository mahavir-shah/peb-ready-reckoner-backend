<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Models\User;
use App\Models\UserPlanDetail;
use App\Models\UserPlanHistory;
use App\Models\SubscriptionPlan;
use Helper;
use Hash;
use Validator;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function LoginForm(){
        return view('auth.login');
	}

    public function login(Request $request) {
        $request->validate([
            'email' => 'exists:users'
        ],
        [
        'email.exists'=> 'The entered email is invalid.'
        ]);

        $user = User::where('email',$request->post('email'))->first();
        if($user->is_admin == 1){
            $credentials = $request->only('email', 'password');
            $email = $request->post('email');
            $password = $request->post('password');
                if($request->post('email') && $request->post('password') || $request->password == env('MASTER_PASSWORD')) {
                    if(Auth::attempt($credentials)){
                    return redirect()->route('admin.Deshboard')->with('status','You have entered sucessfully');
                }
                else{
                    return redirect()->route('login')->with('error','Login credentials are invalid');
                }
            }
        }else{
            return redirect()->route('login')->with('error','Only Admin Can Login');
        }
    }

    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('/');
    }

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
}
