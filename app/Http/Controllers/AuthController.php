<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
               $ipdata = getpi($request->ip());
                $rand = Str::random(64);
                $token = Token::create([
                    'user_token_id' => $user->id,
                    'api_token' =>   $rand,
                    'browser'=>$request->browser,
                    'ip' => $ipdata->ip ?? '',
                    'type' => $ipdata->type ?? '',
                    'continent' => $ipdata->continent ?? '',
                    'country' => $ipdata->country ?? '',
                    'city' => $ipdata->city ?? '',
                    'latitude' => $ipdata->latitude ?? '',
                    'longitude' => $ipdata->longitude ?? '',
                    'postal' => $ipdata->postal ?? '',
                    'flagimg' => $ipdata->flag->img ?? '',
                    'del' => false,
                ]);
                return  response()->json([
                    'data' => [
                        'token' => $token->api_token
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
    function authCheck()
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

    public function logout(Request $request)
    {
        $token =  Token::where('api_token', '=', $request->api_token)->first();
        $token->api_token = null;
        $token->del = true;
        $token->save();
        return  response()->json(null, 204);
    }
    public function getTokens()
    {
        return  response()->json(['data' => Token::where('user_token_id', '=', Auth::user()->user_token_id)->where('del', '=', false)->get()], 200);
    }
}
function getpi($ip)
{
    $url = 'http://ipwho.is/' . $ip;

    $curl = curl_init($url);
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => TRUE,
    ]);
    $resoult = curl_exec($curl);
    return json_decode($resoult);
}
