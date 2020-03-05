<?php

namespace App\Http\Controllers\Newspost;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\NewsPost;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class NewsPostController extends Controller
{
    /* public function __construct()
    {
        $this->middleware('auth:api');
    } */
    public function show(){
        try{
        $newsposts = NewsPost::all();
        return response()->json(['status'=>true ,'news'=> $newsposts],200);      
      } catch(\Exception $exception){
          return response()->json(['status'=>true, 'message'=> 'Something Went Wrong!!','error'=> $exception->getMessage()],500);
       }
    }
    public function create(Request $request){
        
        $newspost=new NewsPost();
        //$image_url = isset($credential['image_url'])? $credential['image_url']: null;
        $image_file = $request->File('image_file');
        
        if($image_file){
        $image_file = $request->File('image_file');
        $extension=$image_file->getClientOriginalExtension();
        $filename=time().'.'.$extension;
        $image_file->move('uploads',$filename); 
        $image_url = 'http://127.0.0.1:8000/uploads/' .$filename;
        }else{
            //return response()->json(['message' => 'Newspost not found']);
            $image_url = 'http://127.0.0.1:8000/uploads/noimage.jpg';
            //$newspost->image='noimage.jpg';
        }
        $newspost->title=$request->input('title'); 
        $newspost->video_url=$request->input('video_url');
        $newspost->content=$request->input('content');
        $newspost->image_url = $image_url;
        
        $newspost->save();
        return response()->json(['post'=>$newspost],201);
        
    }
    public function update() {
        $credential =  request()->only('id', 'title', 'content', 'image_url', 'video_url', 'approval', 'image_file');
        $rules = [
            'id' => 'required',
        ];
        $validator = Validator::make($credential, $rules);
            if($validator->fails()) {
                $error = $validator->messages();
                return response()->json(['error'=> $error, 'message'=>"Invalid format for new news_feed"]);
            }
            $old_news_feed = NewsPost::where('id', '=', $credential['id'])->first();
            //return response()->json(['success'=> $old_news_feed]);

            if($old_news_feed instanceof NewsPost) {
                $image_url = isset($credential['image_url'])? $credential['image_url']:
                $image_url = 'http://127.0.0.1:8000/uploads/noimage.jpg';
                $image_file = request()->file('image_file');
                if ($image_file) {
                    $file_extension = strtolower($image_file->getClientOriginalExtension());
                    if($file_extension == "jpg" || $file_extension == "png") {
                        $posted_file_name = str_random(30) . '.' . $file_extension;
                        $destinationPath = public_path('/uploads');
                        $image_file->move($destinationPath, $posted_file_name);
                        $image_url = 'http://127.0.0.1:8000/uploads/' . $posted_file_name;
                    } else {
                        $image_url = 'http://127.0.0.1:8000/noimage.jpg/' . $posted_file_name;
                    }
                }
                $old_news_feed->title = isset($credential['title'])? $credential['title']:  $old_news_feed->title;
                $old_news_feed->content = isset($credential['content'])? $credential['content']:   $old_news_feed->content;
                $old_news_feed->image_url = $image_url;
                $old_news_feed->video_url = isset($credential['video_url'])? $credential['video_url']:  $old_news_feed->video_url;
                $old_news_feed->approval = isset($credential['approval'])? $credential['approval']: $old_news_feed->approval;
                //$old_news_feed->post_type_id = isset($credential['post_type_id'])? $credential['post_type_id']: $old_news_feed->post_type_id;
                //$old_news_feed->updated_by = $this_user->id;
                if($old_news_feed->update()){
                    return response()->json(['status'=> true,'message'=> 'news_feed updated successfully', 'news_post'=>$old_news_feed], 200);
                } else {
                    return response()->json(['status'=> false,'message'=> 'Whoops! failed to update post'], 500);
                }
            } else {
                return response()->json(['status'=> false,'message'=> 'Whoops! unable to find news post with this id'], 500);
            }
    }
            
    public function delete($id) {
        
            $newspost = NewsPost::find($id);
            if(!$newspost){
                return response()->json(['message' => 'Newspost not found']);
            }

            $newspost ->delete();
            return response()->json(["status" => true, "message"=>'newspost deleted successfully']);

    } 
}