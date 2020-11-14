<?php

namespace App\Http\Controllers\NewsPost;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\NewsPost;
use App\User;


class NewsListController extends Controller
{
    
    public function all(){
        $newspost =  NewsPost::withCount('likes', 'comments')->get();
        return response()->json(['news'=>$newspost]);
    }
    public function showapproved()
    {
        $newspost =  NewsPost::withCount('likes', 'comments')->where('approval', 1)->orderBy('created_at', 'desc')->get();
        return response()->json(['message'=> 'News that are approved!','news'=> $newspost],200);
    }
  
    public function showDisapproved()
    {
        $newspost =  NewsPost::where('approval', 0)->orderBy('created_at', 'desc')->get();

        return response()->json(['status'=>true, 'message'=> 'News Post disapproved!','news'=> $newspost],200);
    }
}
