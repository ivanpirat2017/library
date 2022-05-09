<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WatchBookController extends Controller
{
    function addwatchBook($id)
    {
        DB::table('watchbooks')->insert([
            'watch_user_id' => Auth::user()->id,
            'watch_book_id' => $id,
        ]);
        return response()->json(null, 204);
    }
}
