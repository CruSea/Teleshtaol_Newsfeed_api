<?php

namespace App\Http\Controllers\Newspost;

use App\User;
use App\NewsPostLike;
use Illuminate\Support\Facades\Validator;
use App\NewsPost;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class NewsPostLikeController extends Controller
{
    public function like()
    {
        $id=auth()->user()->id;
        try {
            $credential =  \request()->all();
            $rules = [
                'news_post_id' => 'int|required',
//                'user_id' => 'required'
            ];

            $validator = Validator::make($credential, $rules);
            if ($validator->fails()) {
                $error = $validator->messages();
                return response()->json(['error' => $error, 'message' => "Invalid format for post like"]);
            }
            $newspostlike = new NewsPostLike();
            $newspostlike->news_post_id = $credential['news_post_id'];
//            $newspostlike->user_id = $credential['user_id'];
            $newspostlike->user_id = $id;
            $state = $newspostlike->save();
            if ($state) {
                return response()->json(['status' => true, 'message' => 'like saved successfully', 'result' => $newspostlike], 200);
            }
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => 'Whoops! failed to create post like', 'error' => $exception->getMessage()], 500);
        }
    }

    public function unLike()
    {
        $id=auth()->user()->id;
        try {
            $credential =  request()->only('news_post_id');
            $rules = [
                'news_post_id' => 'required',
                //'user_id' => 'required'
            ];
            $validator = Validator::make($credential, $rules);
            if ($validator->fails()) {
                $error = $validator->messages();
                return response()->json(['success' => false, 'error' => $error, 'message' => "Invalid format for feed like"]);
            }

            //$this_user = Auth::user();
            $newspost = NewsPost::where('id', '=', $credential['news_post_id'])->first();
            if ($newspost instanceof NewsPost) {
                $old_like = NewsPostLike::where('news_post_id', '=', $newspost->id)->where('user_id', '=', $id)->get()->first();
                if ($old_like instanceof NewsPostLike) {
                    $state = $old_like->delete();
                    if ($state) {
                        return response()->json(['status' => true, 'message' => 'Unlike successfully', 'result' => $old_like], 200);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Whoops! failed to unlike feed'], 500);
                    }
                } {
                    return response()->json(['status' => false, 'message' => 'Whoops! You cannot unlike what you have not liked previously.'], 500);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Whoops! unable to find the news_feed'], 500);
            }
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => 'Whoops! failed to create feed like', 'error' => $exception->getMessage()], 500);
        }
    }
    public function isLikedByMe($id)
    {

        $credential =  request()->only('news_post_id', 'user_id');
        $rules = [
            'news_post_id' => 'required',
            'user_id' => 'required',
        ];
        $validator = Validator::make($credential, $rules);
        if ($validator->fails()) {
            $error = $validator->messages();
            return response()->json(['success' => false, 'error' => $error, 'message' => "Invalid format for feed like"]);
        }
        $newspost = NewsPost::findOrFail($id)->first();
        //return response()->json(['news'=> $newspost]);
        if (NewsPostLike::where()->exists()) {
            return 'true';
        }
        return 'false';
    }
    public function totallike($id)
    {
        $totallike = NewsPostLike::where('news_post_id', $id)->count();
        return response()->json([
            'total' => $totallike
        ]);
    }
    public function updatelike()
    {
        $credential = request()->only('id', 'status');
        $rules = [
            'id' => 'required',
        ];
        $validator = Validator::make($credential, $rules);
        if($validator->fails()) {
            $error = $validator->messages();
            return response()->json(['status'=>false, 'error'=> $error],500);
        }
        $this_user = Auth::user();
            
                $oldUser = User::where('id', '=',  $credential['id'])->where('id', '!=', $this_user->id)->first();
                if($oldUser instanceof User) {
                    $oldUser->status = isset($credential['status'])? $credential['status']: !$oldUser->status;
                    if($oldUser->update()){
                        return response()->json(['status'=> true, 'message'=> 'user successfully updated', 'user'=>$oldUser],200);
                    } else {
                        return response()->json(['status'=> false, 'message'=> 'unable to update user information', 'error'=>'something went wrong! please try again'],500);
                    }
                }else {
                    return response()->json(['status'=>false, 'message'=> 'Whoops! this email address is already taken', 'error'=>'email duplication'],500);
                }
            
    }
}
