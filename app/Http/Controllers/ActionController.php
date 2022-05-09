<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BookPreviewResource;

class ActionController extends Controller
{
    function createaction(Request $request)
    {
        $valide = Validator::make($request->all(), [
            'title_action' => 'required',
            'description_action' => 'required|',
            'books_action' => 'required|',
        ]);
        if ($valide->fails()) {
            return response()->json(['error' => $valide->errors()], 422);
        }
        $img_action = $request->img_action ?  $request->file('img_action')->store('public/images') : null;
        Action::create([
            'title_action' => $request->title_action,
            'description_action' => $request->description_action,
            'books_action' => $request->books_action,
            'img_action' =>   $img_action,
        ]);
        return response()->json(null, 204);
    }
    function geteaction(Request $request)
    {
        $array_push = [];

        $actions = Action::orderByRaw("RAND()")->limit(10)->get();
        foreach ($actions as $item) {
            $books = Book::whereIn('id', json_decode($item->books_action))->get();
            $action =  $item;
            $action['books'] = BookPreviewResource::collection($books);
            array_push($array_push, $action);
        }
        return response()->json(['data' => $array_push], 200);
    }
    function getActionId($id)
    {
        $action = Action::firstWhere('id', $id);
        $books = Book::whereIn('id', json_decode($action->books_action))->get();
        $action['books'] = BookPreviewResource::collection($books);
        return response()->json(['data' => $action], 200);
    }
}
