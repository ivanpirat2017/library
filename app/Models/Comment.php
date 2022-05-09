<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like_comment;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_comment_id',
        'book_comment_id',
        'message',
        'dell',
        'selection'
    ];
    protected $with = [
        'sum_like', 'user'
    ];
    public function sum_like()
    {
        return  $this->hasMany(Like_comment::class, 'like_comment_id', 'id');
    }
    public function user()
    {
        return  $this->hasOne(User::class, 'id', 'user_comment_id');
    }
    function dell()
    {
        $this->dell = true;
        $this->selection = false;
        $this->save();
    }
    function push()
    {
        $this->dell = false;
        $this->selection = true;
        $this->save();
    }
}
