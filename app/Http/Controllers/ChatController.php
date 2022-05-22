<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    function addmessage(Request $request)
    {

        DB::table('chat_books')->insert([
            'user_id' => Auth::user()->user_token_id,
            'book_id' => $request->book_id,
            'messages' => $request->messages,
            'del' => false,
        ]);
        return response()->json(null, 204);
    }
    function getmessages($id)
    {
        $messages = DB::table('chat_books')->rightJoin('users', 'chat_books.user_id', '=', 'users.id')
            ->where('chat_books.book_id', '=', $id)
            ->select('chat_books.id', 'chat_books.book_id','chat_books.id', 'chat_books.messages', 'users.first_name', 'users.id', 'users.last_name', 'chat_books.created_at')->orderBy('chat_books.id')->limit(100)->get();
        return response()->json(['data' => $messages,'author'=>Auth::user()->user_token_id], 200);
    }
}
