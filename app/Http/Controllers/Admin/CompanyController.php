<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\CompanyName;

class CompanyController extends Controller
{

    public function index(){
        return view('admin.company.index');
    }

    public function companyData(Request $request)
    {
        $user = DB::table('company_name')->where('is_deleted',0);

        $column = array("company_title");

        if ($request->input("order")) {
            $user = $user->orderby($column[$request->input('order')[0]['column']], $request->input('order')[0]['dir']);
        } else {
            $user = $user->orderby('id', 'asc');
        }

        if ($request->input("search")["value"] && $request->input("value") == '') {
            $user = $user->where('company_title', 'like', '%' . $request->input("search")["value"] . '%');
        }

            $filter_count = $user->get()->count();
            if ($request->input('length') != -1) {
                $user = $user->offset($request->input('start'))->limit($request->input('length'));
            }

            $user = $user->get();
            $data = array();
            foreach ($user as $row) {
                $sub_array = array();
                $sub_array[] = '<input class="border-0 bg-transparent company_name_inp" readonly value="'.$row->company_title.'">'; 
                $sub_array[] = '
                <a href="javascript:void(0)" class="mr-2 company_edit"><i class="fa fa-edit"></i></a>
                <a rel="'.$row->id.'" href="javascript:void(0)" class="mr-2 company_update d-none"><i class="fa fa-save"></i></a>
                <a href="javascript:void(0)" class="company-delete user-delete-icon-'.$row->id.'"  rel="'.$row->id.'"><i class="fa fa-trash"></i></a>';
                $data[] = $sub_array;
            }

            $output = array(
                "draw"    =>  intval($request->input('draw')),
                "recordsTotal"  =>  CompanyName::where('is_deleted',0)->count(),
                "recordsFiltered"  =>  $filter_count,
                "data"  =>  $data
            );

            echo json_encode($output);
    }
    public function create(Request $request){
        CompanyName::create([
            'company_title' => $request->company_title
        ]);
        echo json_encode(true);
    }

    public function update(Request $request){
        $news_data = CompanyName::where('id',$request->id)->update([
            "company_title" => $request->company_title
        ]);
        echo json_encode(true);
    }

    public function delete(Request $request){
        CompanyName::where('id',$request->id)->update([
            'is_deleted' => 1
        ]);
        echo json_encode(true);
    }

    public function companyArcadeData(Request $request)
    {
        $user = DB::table('company_name')->where('is_deleted',1);

        $column = array("company_title");

        if ($request->input("order")) {
            $user = $user->orderby($column[$request->input('order')[0]['column']], $request->input('order')[0]['dir']);
        } else {
            $user = $user->orderby('id', 'asc');
        }

        if ($request->input("search")["value"] && $request->input("value") == '') {
            $user = $user->where('company_title', 'like', '%' . $request->input("search")["value"] . '%');
        }

            $filter_count = $user->get()->count();
            if ($request->input('length') != -1) {
                $user = $user->offset($request->input('start'))->limit($request->input('length'));
            }

            $user = $user->get();
            $data = array();
            foreach ($user as $row) {
                $sub_array = array();
                $sub_array[] = $row->company_title; 
                $sub_array[] = '
                <a href="javascript:void(0)" class="company-arcade user-arcade-icon-'.$row->id.'"  rel="'.$row->id.'"><i class="fa fa-undo"></i></a>';
                $data[] = $sub_array;
            }

            $output = array(
                "draw"    =>  intval($request->input('draw')),
                "recordsTotal"  =>  CompanyName::where('is_deleted',1)->count(),
                "recordsFiltered"  =>  $filter_count,
                "data"  =>  $data
            );

            echo json_encode($output);
    }

    public function restore(Request $request){
        CompanyName::where('id',$request->id)->update([
            'is_deleted' => 0
        ]);
        echo json_encode(true);
    }

}

    