<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Helper;
use Mail;
use Auth;
use App\Models\User;
use App\Models\News;
use File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{

    public function index(){
        return view('admin.news.index');
    }

    public function newsData(Request $request)
    {
        $user = DB::table('news');

        $column = array("title","created_at");

        if ($request->input("order")) {
            $user = $user->orderby($column[$request->input('order')[0]['column']], $request->input('order')[0]['dir']);
        } else {
            $user = $user->orderby('id', 'asc');
        }

        if ($request->input("search")["value"] && $request->input("value") == '') {
            $user = $user->where('title', 'like', '%' . $request->input("search")["value"] . '%');
        }

            $filter_count = $user->get()->count();
            if ($request->input('length') != -1) {
                $user = $user->offset($request->input('start'))->limit($request->input('length'));
            }

            $user = $user->get();
            $data = array();
            foreach ($user as $row) {
                $sub_array = array();
                $sub_array[] = $row->title;
                $sub_array[] = $row->content;
                $sub_array[] = '<img src="'.asset('upload/news/'.$row->image).'" width="50px" height="50px">';
                $sub_array[] = date('d-m-Y', strtotime($row->created_at));
                $sub_array[] = '
                <a href="'.route('admin.newsEdit',$row->id).'" class="mr-2"><i class="fa fa-edit-icon"></i></a>
                <a href="javascript:void(0)" class="user-delete user-delete-icon-'.$row->id.'"  rel="'.$row->id.'"><i class="fa fa-trash"></i></a>';
                $data[] = $sub_array;
            }

            $output = array(
                "draw"    =>  intval($request->input('draw')),
                "recordsTotal"  =>  News::count(),
                "recordsFiltered"  =>  $filter_count,
                "data"  =>  $data
            );

            echo json_encode($output);
        }

        public function add(){
            return view('admin.news.create');
        }
        public function create(Request $request){
            //echo '<pre>'; print_r($request->all());
            //die();
            $validated = $request->validate([
                'content' => 'required'
            ]);
            $user_data = [
                'title' => $request->title,
                'content' => $request->content
            ];
            $news_data = News::find($request->id);
            if ($request->image) {
                if(isset($news_data->image)){
                    $image = public_path('upload/news/'.$news_data->image);
                    if (File::exists($image)) { // unlink or remove previous image from folder
                        unlink(public_path('upload/news/'.$news_data->image));
                    }
                }
                $image = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('upload/news/'), $image);
    
                $user_data['image'] =  $image;
            }
            
            if($request->id == ''){
                News::create($user_data);
            }else{
                News::where('id',$request->id)->update($user_data);
            }

            return redirect()->route('admin.news');
        }

        public function edit($id){
            $news_data = News::find($id);
            return view('admin.news.create',compact('news_data'));
        }

        public function deleteNews(Request $request){
            $news_data = News::find($request->id);
            $image = public_path('upload/news/'.$news_data->image);
            if (File::exists($image)) { // unlink or remove previous image from folder
                unlink(public_path('upload/news/'.$news_data->image));
            }
            News::where('id',$request->id)->delete();
            echo json_encode(true);
        }
    }

    