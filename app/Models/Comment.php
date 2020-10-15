<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "comments";

    public function posts() {
        return $this->belongsTo('\App\Models\Post');
    }

    public function users() {
        return $this->belongsTo('\App\Models\User');
    }

}
