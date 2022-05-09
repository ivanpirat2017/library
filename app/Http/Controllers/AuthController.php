<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function login(Request $request)
    {



        $valide = Validator::make($request->all(), [
            'email' => 'required|max:100|email',
            'password' => 'required|max:100'
        ]);
        if ($valide->fails()) {
            return  response()->json([
                'error' => $valide->errors()
            ], 422);
        }
        if ($user = User::where('email', '=', $request->email)->first()) {
            if (Hash::check($request->password, $user->password)) {
                return  response()->json([
                    'data' => [
                        'token' =>  $user->gettoken()
                    ]
                ], 200);
            }
        }
        return response()->json([
            'error' => [
                'code' => 401,
                'message' => 'Unauthorized',
                'email' => [
                    'email or password incorrect',
                ]
            ]
        ], 401);
    }
    function reg(Request $request)
    {


        $valide = Validator::make($request->all(), [
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'patronymic' => 'required|max:100',
            'email' => 'required|max:100|email|unique:users',
            'password' => 'required|max:100'
        ]);
        if ($valide->fails()) {
            return  response()->json([
                'error' => $valide->errors()
            ], 422);
        }
        $request['password'] = Hash::make($request->password);
        $userNull = User::all()->count();
        if ($userNull == 0) {
            $request['role'] = 'admin';
        }
        User::create($request->all());
        return  response()->json(null, 204);
    }
    function authCheck( )
    {
        return  response()->json([
            'data' => Auth::check()
        ], 200);
    }
    function authAdminCheck(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            return  response()->json([
                'data' => Auth::check()
            ], 200);
        }
        return response()->json([
            'error' => [
                'code' => 401,
                'message' => 'not admin',
            ]
        ], 401);
    }
    public function logout()
    {
        Auth::user()->api_token = null;
        Auth::user()->save();
        return  response()->json(null, 204);
    }
}
