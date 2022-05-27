<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
use App\Http\Resources\BookAboutResource;
use App\Http\Resources\BookPreviewPaginateResource;
use App\Http\Resources\BookPreviewPaginResource;
use App\Http\Resources\BookPreviewResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Mockery\Undefined;
use ZipArchive;

class BookController extends Controller
{
    function  search()
    {
        $search = $_GET['query'];

        if ($search != null) {
            $books = DB::table('books')->orWhere('title', 'like', '%' . $search . '%')
                ->orWhere('title', 'like', '%' . $search . '%')
                ->orWhere('author', 'like', '%' . $search . '%')
                ->orWhere('release', 'like', '%' . $search . '%')
                ->rightJoin('genres', 'books.genre_book_id', '=', 'genres.id')
                ->rightJoin('book_status', 'books.book_status_id', '=', 'book_status.id')
                ->orWhere('genres.genrename', 'like', '%' . $search . '%')
                ->select('books.id', 'books.title', 'books.bookimg', 'books.reting', 'books.author', 'books.release', 'genres.genrename', 'book_status.status')->orderBy('id', 'desc')->limit(100)->get();
            return response()->json(['data' => $books, 200]);
        }

        return response()->json(['data' => [], 200]);
    }
    function getgenres()
    {
        $genres = DB::table('genres')->select('genre', 'id', 'genrename')->get()->values();
        return response()->json(['data' => $genres], 200);
    }
    function getgenre($genre)
    {
        $genres = DB::table('genres')->where('genres.genre', '=', $genre)->select('genre', 'id', 'genrename')->first();
        return response()->json(['data' => $genres], 200);
    }

    function creategenre(Request $request)
    {
        if (!Auth::user()->user->role == 'admin') {
            return response()->json([
                'error' => [
                    'code' => 401,
                    'message' => 'not admin',
                ]
            ], 401);
        }
        $valide = Validator::make($request->all(), ['genre' => 'required|max:100|unique:genres',]);

        if ($valide->fails()) {
            return response()->json(['error' => $valide->errors()], 422);
        }
        DB::table('genres')->insert($request->all());
        return response()->json(null, 204);
    }



    function createstatus(Request $request)
    {
        if (!Auth::user()->user->role == 'admin') {
            return response()->json([
                'error' => [
                    'code' => 401,
                    'message' => 'not admin',
                ]
            ], 401);
        }

        $valide = Validator::make($request->all(), ['status' => 'required|max:100|unique:book_status',]);

        if ($valide->fails()) {
            return response()->json(['error' => $valide->errors()], 422);
        }
        DB::table('book_status')->insert($request->all());
        return response()->json(null, 204);
    }

    function getStatus()
    {
        $status = DB::table('book_status')->get();
        return response()->json(['data' => $status], 200);
    }
    function getbookid($bookid)
    {

        return response()->json([
            'data' => BookAboutResource::make(Book::find((int)$bookid)),
            'watch' => DB::table('watchbooks')->where('watch_book_id', '=', $bookid)->get()->count()
        ], 200);
    }

    function createbook(Request $request)
    {
        if (!Auth::user()->user->role == 'admin') {
            return response()->json([
                'error' => [
                    'code' => 401,
                    'message' => 'not admin',
                ]
            ], 401);
        }

        $valide = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|',
            'genre_book_id' => 'required|',
        ]);
        if ($valide->fails()) {
            return response()->json(['error' => $valide->errors()], 422);
        }
        $bookimg = $request->bookimg ? $request->file('bookimg')->store('public/images')   : null;
        $bookurl = $request->bookurl ?    $request->file('bookurl')->store('public/path') : null;

        DB::table('books')->insert([
            'title' => $request->title,
            'description' => $request->description,
            'genre_book_id' => $request->genre_book_id,
            'book_status_id' => $request->book_status_id,
            'bookimg' =>   $bookimg,
            'bookurl' =>   $bookurl,
            'reting' => $request->reting,
            'release' => $request->release,
            'author' => $request->author,
        ]);
        return response()->json(null, 204);
    }

    function getgenrebooks($genreid)
    {
        $genres = DB::table('books')->rightJoin('genres', 'books.genre_book_id', '=', 'genres.id')
            ->rightJoin('book_status', 'books.book_status_id', '=', 'book_status.id')
            ->where('genres.genre', '=', $genreid)
            ->select('books.id', 'books.title', 'books.bookimg', 'books.reting', 'books.author', 'books.release', 'genres.genre', 'book_status.status');

        $genresdaat =    $genres->orderBy('reting', 'desc')->paginate(30);

        return response()->json([
            'data' => $genresdaat
        ], 200);
    }
    function getnewbooks()
    {
        return response()->json(['data' => BookAboutResource::collection(Book::inRandomOrder()->orderBy('id', 'desc')->limit(30)->get())], 200);
    }
    function getpopularbooks()
    {
        return response()->json(['data' => BookAboutResource::collection(Book::orderBy('reting', 'desc')->limit(30)->get())], 200);
    }
    function doumlonddook($id)
    {
        $book = DB::table('books')->find($id);
        if (is_null($book->bookurl)) {
            return;
        }
        return Storage::download($book->bookurl);
    }
    function read($id)
    {
        $book = DB::table('books')->find($id);
        $zip = new ZipArchive;
        if ($zip->open('./storage/' . $book->bookurl) === TRUE) {
            return response()->json(mb_convert_encoding($zip->getFromIndex(0), "utf-8", "windows-1251"), 200);
        } else {
            echo 'ошибка';
        }
    }


    function DeleteBooks($id)
    {
        if (!Auth::user()->user->role == 'admin') {
            return response()->json([
                'error' => [
                    'code' => 401,
                    'message' => 'not admin',
                ]
            ], 401);
        }
        DB::table('books')->delete($id);
        return response()->json(null, 204);
    }


    public function Update(Request $request)
    {

        if (request()->hasFile('bookimg')) {
            $request->bookimg = $request->bookimg ? $request->file('bookimg')->store('public/images')   : null;
        } else {
            $request->bookimg  = null;
        }
        if (request()->hasFile('bookurl')) {
            $request->bookurl = $request->bookurl ?    $request->file('bookurl')->store('public/path') : null;
        } else {
            $request->bookurl  = null;
        }
        Book::where('id', '=', $request->id)->first()->edit($request);
        return response()->json(null, 204);
    }







    function getbooksFilter($flter)
    {

        if ($flter == 'new') {
            return response()->json(['data' => BookAboutResource::collection(Book::orderBy('id', 'desc')->limit(30)->get())], 200);
        }
        if ($flter == 'popular') {
            return response()->json(['data' => BookAboutResource::collection(Book::orderBy('reting', 'desc')->limit(30)->get())], 200);
        }
        if ($flter == 'topview') {


            return   '';
            // return response()->json(['data' => BookAboutResource::collection(null)], 200);
        }
    }
}
