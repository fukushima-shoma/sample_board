<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;
use App\Like;

class Post extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
   protected $fillable = [
      'user_id', 'category_id', 'content', 'title', 'image'
      ];

    public function category(){

        return $this->belongsTo(\App\Category::class,'category_id');
      }

      public function user(){

          return $this->belongsTo(\App\User::class,'user_id');
      }

      public function comments(){

          return $this->hasMany(\App\Comment::class,'post_id', 'id');
      }

      public function likes(){
     return $this->hasMany('App\Like');
      }

   public function like_by(){
     return Like::where('user_id', Auth::user()->id)->first();
      }


}
