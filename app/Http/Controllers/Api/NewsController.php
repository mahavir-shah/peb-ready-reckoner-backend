<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\News;
use Illuminate\Support\Facades\Validator;
use Auth;
use File;

class NewsController extends Controller{

    public function getNews(){
        $news = News::select('id','image','title','content')->get();

        foreach($news as $key=>$data){
            $news[$key]['image'] = env('APP_URL').'/upload/news/'.$data->image;  
            $news[$key]['content'] = strip_tags($data->content);
       }
        return response()->json([
            'success' => true,
            'data' => $news,
        ], Response::HTTP_OK);
    }

}