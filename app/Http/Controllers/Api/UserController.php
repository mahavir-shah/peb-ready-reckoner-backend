<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\CompanyDetails;
use App\Models\CompanyName;
use App\Models\Designation;
use App\Models\UserRateMaterials;
use App\Handlers\Admin\AuthHandler;
use Firebase\JWT\JWT;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use Auth;
use File;

class UserController extends Controller{

    public function updateProfile(Request $request){

        $user = [
            'name' => $request->name,
            'email' => $request->email
        ];
        if ($request->profile_img) {
            $image_data = User::find(Auth::id());
            if(isset($image_data->profile_img)){
                $profile_img = public_path('upload/profile_img/'.$image_data->profile_img);
                if (File::exists($profile_img)) { // unlink or remove previous image from folder
                    unlink(public_path('upload/profile_img/'.$image_data->profile_img));
                }
            }
            $profile_img = time().'.'.$request->profile_img->getClientOriginalExtension();
            $request->profile_img->move(public_path('upload/profile_img/'), $profile_img);

            $user['profile_img'] =  $profile_img;
        }

        User::where('id',Auth::id())->update($user);
        $updated_data = User::select('id','name','email','mobile_no','profile_img')->where('id',Auth::id())->first();

        if($updated_data->profile_img != null){
            $updated_data['profile_img'] = env('APP_URL').'/upload/profile_img/'.$updated_data->profile_img;
        }else{
            $updated_data['profile_img'] = env('APP_URL').'/images/dummy_profile.jpg';
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile Updated Sucessfully',
            'user_data' => $updated_data
        ], Response::HTTP_OK);
    }

    public function userRateMaterial(Request $request){
       $user =  UserRateMaterials::updateOrCreate(
        ['user_id' => $request->user_id],
        [
            'user_id' => $request->user_id,
            'main_frame_steel' => $request->main_frame_steel,
            'cold_form_purlin' => $request->cold_form_purlin,
            'side_wall_girt' => $request->side_wall_girt,
            'gable_end_girt' => $request->gable_end_girt,
            'roofing_sheet' => $request->roofing_sheet,
            'side_cladding_sheet' => $request->side_cladding_sheet,
            'sag_rod' => $request->sag_rod,
            'cold_form_stay_brace' => $request->cold_form_stay_brace,
            'anchor_bolt' => $request->anchor_bolt,
            'cleat' => $request->cleat,
            'x_bracing' => $request->x_bracing,
            'finishing' => $request->finishing,
            'tie_beam' => $request->tie_beam,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Updated Sucessfully'
        ], Response::HTTP_OK);
    } 

    public function getUserRateMaterial(){
        $data =  UserRateMaterials::select('main_frame_steel','cold_form_purlin','side_wall_girt','gable_end_girt','roofing_sheet', 'side_cladding_sheet','sag_rod','cold_form_stay_brace','anchor_bolt','cleat','x_bracing','finishing','tie_beam')->where('user_id',Auth::id())->get();
        return response()->json($data, Response::HTTP_OK);
    }

    public function getProfile(){
        $data = User::select('users.name','users.mobile_no','users.email','users.profile_img','company_name.id as company_id','company_name.company_title','designation.id as designation_id','designation.designation_title','company_details.description','company_details.ragistration_office','company_details.gst_number')->leftjoin('company_details','company_details.user_id','=','users.id')->leftjoin('company_name','company_name.id','=','company_details.company_name')->leftjoin('designation','designation.id','=','company_details.designation')->where('users.id',Auth::id())->first();

        if($data->profile_img != null){
            $data['profile_img'] = env('APP_URL').'/upload/profile_img/'.$data->profile_img;
        }else{
            $data['profile_img'] = env('APP_URL').'/images/dummy_profile.jpg';
        }

        return response()->json($data, Response::HTTP_OK);
    }

    public function updateCompanyDetails(Request $request){

        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'designation_id' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $user = [
            'ragistration_office' => $request->ragistration_office,
            'gst_number' => $request->gst_number,
            'description' => $request->description,
        ];
        if ($request->company_logo) {
            $image_data = CompanyDetails::find(Auth::id());
            if(isset($image_data->company_logo)){
                $company_logo = public_path('upload/user_company_logo/'.$image_data->company_logo);
                if (File::exists($company_logo)) { // unlink or remove previous image from folder
                    unlink(public_path('upload/user_company_logo/'.$image_data->company_logo));
                }
            }
            $company_logo = time().'.'.$request->company_logo->getClientOriginalExtension();
            $request->company_logo->move(public_path('upload/user_company_logo/'), $company_logo);

            $user['company_logo'] =  $company_logo;
        }

        if($request->company_id == 0){
            $company_data = CompanyName::where('company_title',$request->company_name)->first();
            if($company_data->count() == 0){
                $company_id = CompanyName::create([
                    'company_title' => $request->company_name 
                ])->id;
            }else{
                $company_id = $company_data->id; 
            }
       }else{
        $company_id = $request->company_id;
       }
       $user['company_name'] = $company_id;

       if($request->designation_id == 0){
        $designation_data = Designation::where('designation_title',$request->designation)->first();
            if($designation_data->count() == 0){
                $designation_id = Designation::create([
                    'designation_title' => $request->designation 
                ])->id;
            }else{
                $designation_id = $designation_data->id; 
            }
        }else{
            $designation_id = $request->designation_id;
        }
        $user['designation'] = $designation_id;

        CompanyDetails::where('user_id',Auth::id())->update($user);

        return response()->json([
            'success' => true,
            'message' => 'Profile Updated Sucessfully',
        ], Response::HTTP_OK);
    }

}