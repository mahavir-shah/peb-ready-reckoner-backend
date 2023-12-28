<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
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
}
