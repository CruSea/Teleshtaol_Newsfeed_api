<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class NewsPost extends Model
{
    public function likes() {
        return $this->hasMany(NewsPostLike::class, 'news_post_id');
    }
    public function comments() {
        return $this->hasMany(NewsPostComment::class);
    }
    protected $appends = ['liked_by_auth_user'];
    public function getLikedByAuthUserAttribute()
    {
        $user = auth()->user();
        if($user instanceof User){
            $userId = $user->id;
            $myLike = $this->likes->first(function ($key) use ($userId){
                return $key->user_id === $userId;
            });
            if($myLike){
                return true;
            }
        }
        return false;
    }
}
