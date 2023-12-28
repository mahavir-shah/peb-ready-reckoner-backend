<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\Events;
use App\Models\News;
use App\Handlers\Admin\AuthHandler;
use Firebase\JWT\JWT;
use JWTAuth;
use App\Models\UserOtp;
use App\Models\CompanyName;
use App\Models\Designation;
use App\Models\CompanyDetails;
use Tymon\JWTAuth\Exceptions\JWTException;
use Craftsys\Msg91\Facade\Msg91;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Auth;

class OtpController extends Controller{

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['SendOtp','login','register','getCompanyName','getdesignation']]);
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile_no' => 'required|unique:users|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'email' => 'required|email|unique:users',
            'company_name' => 'required',
            'designation' => 'required',
            'company_id' => 'required',
            'designation_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

       $user = User::create([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email
       ])->id;

       if($request->company_id == 0){
            $company_data = CompanyName::where('company_title',$request->company_name)->get()->first();
            if(isset($company_data)){
                $company_id = $company_data->id; 
            }else{
                $company_id = CompanyName::create([
                    'company_title' => $request->company_name 
                ])->id;
            }
       }else{
        $company_id = $request->company_id;
       }

       if($request->designation_id == 0){
        $designation_data = Designation::where('designation_title',$request->designation)->get()->first();
            if(isset($designation_data)){
                $designation_id = $designation_data->id; 
            }else{
                $designation_id = Designation::create([
                    'designation_title' => $request->designation 
                ])->id;
            }
        }else{
            $designation_id = $request->designation_id;
        }

       CompanyDetails::create([
            'user_id' => $user,
            'company_name' => $company_id,
            'designation' => $designation_id
        ]);

        //UserOtp::where('user_id', $user->id)->delete();
        $otp = rand(1234, 9999);
        //$otp = 1234;
        $otp_data = UserOtp::create([
            'user_id' => $user,
            'otp' => $otp
        ]);

        $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.authkey.io/request?authkey=c9f946d397cec9f1&mobile='.$request->mobile_no.'&country_code=91&sid=9561&company=PEBRR&otp='.$otp,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);

        // $mailData = [
        //     'name' => $request->name
        // ];

        // Mail::to($request->email)->send(new WelcomeMail($mailData));

        return response()->json([
            'success' => true,
            'message' => 'User Registerd Successfully',
            'mobile_no' => $request->mobile_no
        ], Response::HTTP_OK);
    }

    public function SendOtp(Request $request){
        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $user = User::where('mobile_no', $request->mobile_no)->first();

        if($user == null){
             return response()->json([
                'success' => false,
                'message' => 'Mobile no is not registered',
            ], 400);
        }
  
        UserOtp::where('user_id', $user->id)->delete();
        $otp = rand(1234, 9999);
        //$otp = 1234;
        $otp_data = UserOtp::create([
            'user_id' => $user->id,
            'otp' => $otp
        ]);

        if($otp_data){
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.authkey.io/request?authkey=c9f946d397cec9f1&mobile='.$user->mobile_no.'&country_code=91&sid=9561&company=PEBRR&otp='.$otp,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);
        }

        return response()->json([
            'success' => true,
            'message' => 'Otp Send successfully',
            'mobile_no' => $request->mobile_no
        ], Response::HTTP_OK);
    }

    public function login(Request $request){

         $validator = Validator::make($request->all(), [
            'otp' => 'required'
        ]);
        $input = $request->only('mobile_no');
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        
        $user_id = User::where('mobile_no', $request->mobile_no)->first();
        if($user_id == null){
            return response()->json(['error' => 'Mobile no is not correct'], 400);
        }
        $user_data = UserOtp::where('user_id', $user_id->id)->where('otp', $request->otp)->first();
        if (!$user_data) {
            return response()->json(['error' => 'Your OTP is not correct'], 400);
        }else{
            if ($token = JWTAuth::fromUser($user_id)) {
                return $this->createNewToken($token);
            }
        }
    }

    protected function createNewToken($token){
		
        $user_data = User::where('id', JWTAuth::setToken($token)->toUser()->id)->first();

        if($user_data->profile_img != null){
            $user_data['profile_img'] = env('APP_URL').'/upload/profile_img/'.$user_data->profile_img;
        }else{
            $user_data['profile_img'] = env('APP_URL').'/images/dummy_profile.png';
        }
		return response()->json([
            'success' => true,
            'token_type' => 'bearer',
            'token' => $token,
            'expires_in' => auth('api')->factory()->getTTL() * env('JWT_TTL'),
            'user_data' => $user_data
        ]);
    }

    public function logout(){
        auth()->logout();

        return response()->json(['message' => 'User successfully logged out.']);
    }

    public function getCompanyName(){

        $company = CompanyName::select('id','company_title as name')->get();

        return response()->json($company, Response::HTTP_OK);

    }

    public function getdesignation(){

        $designation = Designation::select('id','designation_title as name')->get();

        return response()->json($designation, Response::HTTP_OK);

    }

}