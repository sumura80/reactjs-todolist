<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable=[
        // 'title','body','category_id','modified_at'
        'title','body','category_id','modified_at'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }


    public function getRouteKeyName(){
        return 'slug';
    }

    protected $dates = [
        'modified_at'
    ];
}
