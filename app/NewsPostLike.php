<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsPostLike extends Model
{
    public function newspost(){
        return $this->belongsTo('App\NewsPost','news_post_id','id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
