<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\Designation;

class DesignationController extends Controller
{

    public function index(){
        return view('admin.designation.index');
    }

    public function designationData(Request $request)
    {
        $user = DB::table('designation')->where('is_deleted',0);

        $column = array("designation_title");

        if ($request->input("order")) {
            $user = $user->orderby($column[$request->input('order')[0]['column']], $request->input('order')[0]['dir']);
        } else {
            $user = $user->orderby('id', 'asc');
        }

        if ($request->input("search")["value"] && $request->input("value") == '') {
            $user = $user->where('designation_title', 'like', '%' . $request->input("search")["value"] . '%');
        }

            $filter_count = $user->get()->count();
            if ($request->input('length') != -1) {
                $user = $user->offset($request->input('start'))->limit($request->input('length'));
            }

            $user = $user->get();
            $data = array();
            foreach ($user as $row) {
                $sub_array = array();
                $sub_array[] = '<input class="border-0 bg-transparent designation_name_inp" readonly value="'.$row->designation_title.'">'; 
                $sub_array[] = '
                <a href="javascript:void(0)" class="mr-2 designation_edit"><i class="fa fa-edit"></i></a>
                <a rel="'.$row->id.'" href="javascript:void(0)" class="mr-2 designation_update d-none"><i class="fa fa-save"></i></a>
                <a href="javascript:void(0)" class="designation-delete user-delete-icon-'.$row->id.'"  rel="'.$row->id.'"><i class="fa fa-trash"></i></a>';
                $data[] = $sub_array;
            }

            $output = array(
                "draw"    =>  intval($request->input('draw')),
                "recordsTotal"  =>  Designation::where('is_deleted',0)->count(),
                "recordsFiltered"  =>  $filter_count,
                "data"  =>  $data
            );

            echo json_encode($output);
        }
    public function create(Request $request){
        Designation::create([
            'designation_title' => $request->designation_title
        ]);
        echo json_encode(true);
    }

    public function update(Request $request){
        $news_data = Designation::where('id',$request->id)->update([
            "designation_title" => $request->designation_title
        ]);
        echo json_encode(true);
    }

    public function delete(Request $request){
        Designation::where('id',$request->id)->update([
            'is_deleted' => 1
        ]);
        echo json_encode(true);
    }

    public function designationArcadeData(Request $request)
    {
        $user = DB::table('designation')->where('is_deleted',1);

        $column = array("designation_title");

        if ($request->input("order")) {
            $user = $user->orderby($column[$request->input('order')[0]['column']], $request->input('order')[0]['dir']);
        } else {
            $user = $user->orderby('id', 'asc');
        }

        if ($request->input("search")["value"] && $request->input("value") == '') {
            $user = $user->where('designation_title', 'like', '%' . $request->input("search")["value"] . '%');
        }

            $filter_count = $user->get()->count();
            if ($request->input('length') != -1) {
                $user = $user->offset($request->input('start'))->limit($request->input('length'));
            }

            $user = $user->get();
            $data = array();
            foreach ($user as $row) {
                $sub_array = array();
                $sub_array[] = $row->designation_title; 
                $sub_array[] = '
                <a href="javascript:void(0)" class="designation-arcade user-arcade-icon-'.$row->id.'"  rel="'.$row->id.'"><i class="fa fa-undo"></i></a>';
                $data[] = $sub_array;
            }

            $output = array(
                "draw"    =>  intval($request->input('draw')),
                "recordsTotal"  =>  Designation::where('is_deleted',1)->count(),
                "recordsFiltered"  =>  $filter_count,
                "data"  =>  $data
            );

            echo json_encode($output);
    }

    public function restore(Request $request){
        Designation::where('id',$request->id)->update([
            'is_deleted' => 0
        ]);
        echo json_encode(true);
    }

}

    