<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'author',
        'description',
        'genre_book_id',
        'book_status_id',
        "bookimg",
        "bookurl",
        "reting",
        "release",
        "price_book",

    ];
    
    protected $with = [
        'grtStatus', 'getGenre'
    ];
    public function grtStatus()
    {
        return  $this->hasOne(Book_statu::class, 'id', 'book_status_id');
    }
    public function getGenre()
    {
        return  $this->hasOne(Genre::class, 'id', 'genre_book_id');
    }
}
