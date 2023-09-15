<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\WebConfig;
use File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class WebConfigController extends Controller
{

    public function index(){
        return view('admin.web_config.index');
    }

    public function newsData(Request $request)
    {
        $user = DB::table('web_config');

            $user = $user->get();
            $data = array();
            foreach ($user as $row) {
                $sub_array = array();
                $sub_array[] = '<img src="'.asset('upload/logo/'.$row->logo).'" width="50px" height="50px">';
                $sub_array[] = $row->welcome_content;
                $sub_array[] = '
                <a href="'.route('admin.webConfigEdit',$row->id).'" class="mr-2"><i class="fa fa-edit"></i></a>';
                $data[] = $sub_array;
            }

            $output = array(
                "draw"    =>  intval($request->input('draw')),
                "recordsTotal"  =>  $user->count(),
                "recordsFiltered"  =>  $user->count(),
                "data"  =>  $data
            );

            echo json_encode($output);
        }

        public function create(Request $request){
            
            $app_data['welcome_content'] = $request->welcome_content;
            $data = WebConfig::find($request->id);
            if ($request->logo) {
                $logo = 'app_logo.'.$request->logo->getClientOriginalExtension();
                $request->logo->move(public_path('upload/logo/'), $logo);
    
                $app_data['logo'] =  $logo;
            }
            
            WebConfig::where('id',$request->id)->update($app_data);

            return redirect()->route('admin.webConfig');
        }

        public function edit($id){
            $data = WebConfig::find($id);
            return view('admin.web_config.create',compact('data'));
        }
    }

    