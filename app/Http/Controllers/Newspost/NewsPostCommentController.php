<?php

namespace App\Http\Controllers\Newspost;

use App\NewsPostComment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsPostCommentController extends Controller
{
    public function index(){
        $comment = NewsPostComment::all();
        return response()->json($comment);
    }

    public function store()
    {
        $id=auth()->user()->id;
        $credential =  request()->only('news_post_id', 'comment');
        $rules = [
            'comment' => 'required|max:255',
            'news_post_id' => 'required',
        ];

        $validator = Validator::make($credential, $rules);
        if ($validator->fails()) {
            $error = $validator->messages();
            return response()->json(['error' => $error, 'message' => "Invalid format for post Comment"]);
        }

        $comment = new NewsPostComment();
        $comment->comment  = $credential['comment'];
        $comment->news_post_id = $credential['news_post_id'];
        $comment->user_id =$id;
        $comment->save();
        return response()->json(['message' => 'Comment saved successfully', 'result' => $comment], 200);
    }


    public function getCommentsList($id)
    {
        try {
            $newspostcomments = NewsPostComment::with('user')->where('news_post_id', $id)->get();
            return response()->json(['status' => true, 'message' => 'news_feeds fetched successfully', 'comments' => $newspostcomments], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => false, 'message' => 'Whoops! failed to find news_feeds'], 500);
        }
    }
   
    public function delete($id)
    {
        try {
            $newspostcomment = NewsPostComment::where('id', '=', $id)->first();
            if ($newspostcomment instanceof NewsPostComment) {
                if ($newspostcomment->delete()) {
                    return response()->json(["status" => true, "message" => 'news_feed_comment deleted successfully']);
                }
            } else {
                return response()->json(["status" => false, "message" => 'whoops! unable to delete news_feed_comment'], 500);
            }
        } catch (\Exception $exception) {
            return response()->json(["status" => false, "message" => 'Whoops! Failed to delete', "error" => $exception->getMessage()]);
        }
    }
}
