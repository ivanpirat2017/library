<?php
use Illuminate\Support\Str;
use App\Models\Token;
use Illuminate\Support\Facades\URL;
use App\Models\User;
$rand = Str::random(64);
$user = User::find($userid);
$user->verificationkey = $rand;
$user->save();

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
        <a href="<?echo(URL::to('/api/sdfvsdfdsvfdscfdsvfsdvfdvfvdsfsds/'. $rand ));?>"> <button> войти </button></a>
    </div>

</body>

</html>

<?
