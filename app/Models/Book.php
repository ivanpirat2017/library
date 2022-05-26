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

    public function edit($request)
    {
        $request->title ?  $this->title = $request->title : null;
        $request->author ? $this->author = $request->author : null;
        $request->description ? $this->description = $request->description : null;
        $request->genre_book_id ? $this->genre_book_id = $request->genre_book_id : null;

        $request->book_status_id ? $this->book_status_id = $request->book_status_id : null;
        $request->bookimg ? $this->bookimg = $request->bookimg : null;
        $request->reting ? $this->reting = $request->reting : null;
        $request->release ? $this->release = $request->release : null;
        $this->save();
    }
}
