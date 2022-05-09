<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class CartController extends Controller
{
    function getIdfavourites(Request $request)
    {
        $books = DB::table('books')
        ->rightJoin('genres', 'books.genre_book_id', '=', 'genres.id')
        ->rightJoin('book_status', 'books.book_status_id', '=', 'book_status.id')
        ->whereIn('books.id',json_decode($request->favouritesId))
        ->select('books.id', 'books.title', 'books.bookimg', 'books.reting','books.author', 'books.release', 'genres.genre', 'book_status.status')
        ->orderBy('id', 'desc')->get();
        return response()->json(['data' => $books], 200);
    }
}
