<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookPreviewResource;
use App\Models\Book;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    function creatrCollection(Request $request)
    {
        Collection::create([
            'users_id' => Auth::user()->id,
            'namecollection' => $request->namecollection,
            'booksarr' => $request->booksarr,
        ]);
        return response()->json(null, 204);
    }
    function dellCollection($id)
    {
        Collection::where('users_id','=',Auth::user()->id)->where('id','=',$id)-> delete();
        return response()->json(null, 204);
    }
    function getCollection()
    {
        $array_push = [];
        $collections = Collection::where('users_id', '=', Auth::user()->id)->get();
        foreach ($collections as $item) {
            $books = Book::whereIn('id', json_decode($item->booksarr))->get();
            $collect['namecollection']= $item->namecollection;
            $collect['id']= $item->id;
            $collect['books']= BookPreviewResource::collection($books)  ;
            array_push($array_push, $collect);
        }
        return response()->json(['data'=> $array_push], 200);
    }
}
