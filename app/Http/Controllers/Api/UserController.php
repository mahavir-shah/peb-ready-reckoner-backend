<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
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

        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = [
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
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

}