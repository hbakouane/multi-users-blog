<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public function users() {
        return $this->belongsTo('\App\Models\User');
    }

    public function categories() {
        return $this->belongsTo('\App\Models\categories');
    }

    public function comments() {
        return $this->hasMany('App\Models\Comment');
    }

    public static function boot() {
        parent::boot();
        static::deleting(function (Post $post) {
            $post->comments()->delete();
        });
    }

}
