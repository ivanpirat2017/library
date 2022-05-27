<?php
use Illuminate\Support\Str;
use App\Models\Token;
use Illuminate\Support\Facades\URL;
use App\Models\User;
function getpi($ip)
{
    $url = 'http://ipwho.is/' . $ip;

    $curl = curl_init($url);
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => true,
    ]);
    $resoult = curl_exec($curl);
    return json_decode($resoult);
}
$user = User::find($userid);
$ipdata = getpi($request->ip());
$rand = Str::random(64);
$token = Token::create([
    'user_token_id' => $userid,
    'api_token' => $rand,
    'browser' => $request->browser,
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
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>send</title>
    <style>
        .send {
            padding: 20px;
            border-radius: 20px;
            background: #313d33;
            width: 500px;
        }

        h3 {
            color: white;
            font-size: 1.2rem
        }

        button {
            padding: 5px;
            border-radius: 5px;
            outline: none;
            background: white;
            border: none;
            color: black;
            font-size: 2rem
        }

    </style>
</head>

<body>
    <div class="send">

        <h3> Здравствуйте,
            <?echo($user->last_name.' '.$user->first_name)?>, вот ссылка для мгновенного входа
        </h3>
        <a href="<?echo(URL::to('/authgenreratetoken/'. $token->api_token));?>"> <button> войти </button></a>
    </div>

</body>

</html>
