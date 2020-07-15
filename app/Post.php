<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //

    protected $guarded = [];

    public function user(){

        return $this->belongsTo(User::class);
    }

    // カラム名：「post_image」の場合
    public function getPostImageAttribute($value){
        return asset('/storage/'.$value);
    }

    // public function setPostImageAttribute($value) {
    //     $this->attributes['post_image'] = ('storage/'.$value);
    // }
}
