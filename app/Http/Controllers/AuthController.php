<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    function login(Request $request)
    {
        $valide = Validator::make($request->all(), [
            'email' => 'required|max:100|email',
        ]);
        if ($valide->fails()) {
            return  response()->json([
                'error' => $valide->errors()
            ], 422);
        }
        if ($user = User::where('email', '=', $request->email)->first()) {
            if ($user->verification) {
                Mail::send('sendemail', ['userid' => $user->id, 'request' => $request], function ($message) use ($request) {
                    $message->to($request->email, 'Ivan')->subject('Ваш ключ авторизации');
                    $message->from('libraru@kursk-library.ru', 'libraru');
                });
                return  response()->json(null, 204);
            }
            return response()->json([
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                    'email' => [
                        'email  не подтвержден',
                    ]
                ]
            ], 401);
        }
        return response()->json([
            'error' => [
                'code' => 401,
                'message' => 'Unauthorized',
                'email' => [
                    'email  incorrect',
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
            'email' => 'required|max:100|email',
        ]);
        if ($valide->fails()) {
            return  response()->json([
                'error' => $valide->errors()
            ], 422);
        }
        $userNull = User::all()->count();
        if ($userNull == 0) {
            $request['role'] = 'admin';
        }

        User::where('email', '=', $request->email)->where('verification', '=', null)->delete();
        $userid =  User::create($request->all());

        Mail::send('authreg', ['userid' => $userid->id, 'request' => $request], function ($message) use ($request) {
            $message->to($request->email, 'Ivan')->subject('Подтвердите Email');
            $message->from('libraru@kursk-library.ru', 'libraru');
        });
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
        if (Auth::user()->user->role == 'admin') {
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

    public function verification(Request $request, $id)
    {
        $user = User::where('verificationkey', '=', $id)->first();
        if ($user) {
            $user->verification = true;
            $user->save();
            $ipdata = getpi($request->ip());
            $rand = Str::random(64);
            Token::create([
                'user_token_id' => $user->id,
                'api_token' => $rand,
                'browser' => '',
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
            return Redirect::to(URL::to('/authgenreratetoken/' . $rand));
        }
        return  'ошибка';
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
