<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
class UserController extends Controller
{
    function updateprofile(Request $request)
    {
        if (request()->hasFile('avatar')) {
            $avatar = $request->avatar ?  $request->file('avatar')->store('public/images') : null;
        }
        if (request()->hasFile('about_img')) {
            $about_img = $request->about_img ?  $request->file('about_img')->store('public/images') : null;
        }
        $userid = DB::table('users')->find(Auth::user()->id);
        DB::table('users')->where('id', '=', Auth::user()->id)->update([
            'avatar' => $avatar ?? $userid->avatar,
            'about_title' => $request->about_title ?? $userid->about_title,
            'about_information' => $request->about_information ?? $userid->about_information,
            'about_img' => $about_img ?? $userid->about_img,
            'first_name' => $request->first_name ?? $userid->first_name,
            'last_name' => $request->last_name ?? $userid->last_name,
            'patronymic' => $request->patronymic ?? $userid->patronymic,
            'email' => $request->email ?? $userid->email,
            'password' => $request->password ? Hash::make($request->password) :   $userid->password
        ]);
        return response()->json(null, 204);
    }
    function getprofile()
    {
        $user = DB::table('users')->where('id', '=',  Auth::user()->id)->first();
        return response()->json([
            'data' => [
                'id' => $user->id,
                'first_name' => ucfirst($user->first_name),
                'last_name' => ucfirst($user->last_name),
                'patronymic' => ucfirst($user->patronymic),
                'email' => $user->email,
                'avatar' => $user->avatar,
                'about_img' => $user->about_img,
                'about_title' => $user->about_title,
                'about_information' => $user->about_information,
            ]
        ], 200);
    }
    function getUser($id)
    {
        $user = DB::table('users')->find($id);

        return response()->json([
            'data' => [
                'first_name' =>  ucfirst($user->first_name),
                'last_name' =>  ucfirst($user->last_name),
                'avatar' => $user->avatar,
                'about_img' => $user->about_img,
                'about_information' => $user->about_information,
                'sum_likes' => DB::table('like_comments')->where('like_user_id', '=', $id)->get()->count(),
                'sum_comments' => DB::table('comments')->where('user_comment_id', '=', $id)->get()->count(),
                'sum_watchbooks' => [
                    'allWatch' => DB::table('watchbooks')->where('watch_user_id', '=', $id)->get()->count(),
                    'uniqueWatch' => DB::table('watchbooks')->where('watch_user_id', '=', $id)->get()->unique('watch_book_id')->count(),
                ],
            ]
        ], 200);
    }
}
