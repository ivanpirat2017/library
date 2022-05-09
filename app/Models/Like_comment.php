<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like_comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'like_user_id',
        'like_comment_id',
    ];
}
