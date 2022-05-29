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
                Mail::send('authreg', ['userid' => $user->id, 'request' => $request], function ($message) use ($request, $user) {
                    $message->to($request->email, $user->last_name . ' ' . $user->first_name)->subject('Ваш ключ авторизации');
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
                    'Email некорректен',
                ]
            ]
        ], 401);
    }
    function reg(Request $request)
    {
        $messages = [
            'first_name' => 'имя',
            'last_name' => 'фамилия',
            'patronymic' => 'отчество',
            'email' => 'email',
        ];
        $valide = Validator::make($request->all(), [
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'patronymic' => 'required|max:100',
            'email' => 'required|max:100|email',
        ]);
        $valide->setAttributeNames($messages);
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
    public function tokenUpdate(Request $request)
    {
        Token::where('api_token', '=', $request->api_token)->update([
            'browser' => $request->browser
        ]);
        return '';
    }
    public function verification(Request $request, $id)
    {
        $user = User::where('verificationkey', '=', $id)->first();
        if ($user) {
            if ($user->verification == false) {
                $user->verification = true;
                $user->save();
            }
            $ipdata = getapidata($request->ip());
            $rand = Str::random(64);
            Token::create([
                'user_token_id' => $user->id,
                'api_token' => $rand,
                'browser' => '',
                'ip' => $request->ip(),
                'type' => 'IPv4',
                'continent' => $ipdata->continent ?? '',
                'country' => $ipdata->location->data->country ?? '',
                'city' => $ipdata->location->value ?? '',
                'latitude' =>  '',
                'longitude' =>   '',
                'postal' => $ipdata->location->data->postal_code ?? '',
                'flagimg' => $ipdata->location->data->country_iso_code ?? '',
                'del' => false,
            ]);
            $key  = Str::random(64);
            $user->verificationkey = $key;
            $user->save();
            return Redirect::to(URL::to('/authgenreratetoken/' . $rand));
        }
        return Redirect::to(URL::to('/'));
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
function getapidata($ip)
{
    $url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address?ip=" . $ip;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
        "Accept: application/json",
        "Authorization: Token 280f128a7d7f51a2fbd20567c3a9fbb7eeb9bc9c",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $resoult = curl_exec($curl);
    return json_decode($resoult);
}
