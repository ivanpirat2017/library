<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ParserController extends Controller
{
    function getBookParser(Request $request)
    {


        $resoult =  getPage($request->url);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($resoult);
        $xpath = new DOMXPath($dom);
        libxml_use_internal_errors(true);
        $link =  $xpath->query('//*[@class="btitle"]/a', $dom);
        foreach ($link as $key) {
            getparsbook($key->getAttribute('href'), $request->gnr);
        }
        return   'ok';
    }
    function setuser()
    {
        for ($i = 0; $i < 100; $i++) {
            $user = json_decode(getPage('https://randomuser.me/api/'));
            $img = getPage($user->results[0]->picture->large);
            $nameimg = Str::random(32) . '.jpg';
            Storage::put('public/picture/' . $nameimg,  $img);
            User::create([
                'avatar' => 'public/picture/' . $nameimg,
                'first_name' => $user->results[0]->name->first,
                'last_name' => $user->results[0]->name->last,
                'patronymic' => ' ',
                'email' => $user->results[0]->email,
                'password' =>   Hash::make($user->results[0]->login->password)
            ]);
        }

        return 'ok';
    }
    function setucoment()
    {

        $books = DB::table('books')->inRandomOrder()
            ->limit(5000)->select('id')
            ->get();
        foreach ($books as $bookid) {
            $users = DB::table('users')->select('id')->get()->random(5);
            foreach ($users as $userid) {
                DB::table('comments')->insert([
                    'user_comment_id' => $userid->id,
                    'book_comment_id' => $bookid->id,
                    'message' => randComent(),
                    'selection' => true
                ]);
            }
        }
        return  'ok';
    }
    function setWath()
    {

        $books = DB::table('books')->inRandomOrder()->limit(5000)->select('id') ->get();
        foreach ($books as $bookid) {
            $users = DB::table('users')->select('id')->get()->random(20);
            foreach ($users as $userid) {
                DB::table('watchbooks')->insert([
                    'watch_user_id' => $userid->id,
                    'watch_book_id' => $bookid->id,
                ]);
            }
        }
        return  'ok';
    }
}

function getparsbook($urlrequest, $gnr)
{
    $resoult =  getPage($urlrequest);
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($resoult);
    $xpath = new DOMXPath($dom);
    libxml_use_internal_errors(true);
    $title =  $xpath->query('//*[@id="dle-content"]/div[1]/div[1]/div[2]/h1', $dom)->item(0);
    $dsc =  $xpath->query(' //*[@id="dle-content"]/div[1]/div[1]/div[3]/div[3]/div', $dom)->item(0);
    $author = $xpath->query('//*[@id="dle-content"]/div[1]/div[1]/div[2]/div[1]/a/span', $dom)->item(0);
    $dowl =  $xpath->query('//*[@id="dle-content"]/div[2]/div/div/div[1]/div/div[1]/a[2]', $dom)->item(0)->getAttribute('href');
    $imgpars =  $xpath->query('//*[@id="dle-content"]/div[1]/div[1]/div[1]/img', $dom)->item(0)->getAttribute('src');

    $genres = DB::table('genres')->where('genrename', '=', $gnr)->first();
    libxml_use_internal_errors(true);
    if (!$genres) {
        $genres = DB::table('genres')->insert([
            'genre' => str_replace(' ', '', translit($gnr)),
            'genrename' => $gnr
        ]);
    }

    if (DB::table('books')->where('title', '=', $title->textContent)->first()) {
    } else {

        $img = getPage('https://bookfor.ru' . $imgpars);
        $nameimg = Str::random(32) . '.jpg';
        Storage::put('public/img/' . $nameimg,  $img);
        $file = dowloude('https://bookfor.ru/' . $dowl);
        $nameFilee = Str::random(32) . '.zip';
        Storage::put('public/book/' . $nameFilee,  $file);
        DB::table('books')->insert([
            'title' =>  $title->textContent,
            'description' => $dsc->textContent,
            'genre_book_id' => $genres->id,
            'book_status_id' => 1,
            'bookimg' =>    'public/img/' . $nameimg,
            'bookurl' =>   'public/book/' . $nameFilee,
            'reting' => randomFloat(3, 5),
            'release' => date("d/m/Y"),
            'author' => $author->textContent,
        ]);
        libxml_use_internal_errors(true);
    }
}
function randComent()
{
    $text1 = ['привет,', 'здравствуйте', 'салют', 'привет,', 'здравствуйте',  'здравствуйте', 'привет,', 'привет'];
    $text2 = [
        'в книге все как-то очень быстро произошло', 'ну читать можно', 'не дочитал пока что', 'Как всегда у автора фантазия на высоте, весьма необычный сюжет и слог хорош.', 'очень не стандартная история, мне понравилась.', 'прочитал, доволен', 'в принципе неплохо', 'Понравилось', 'очень понравилось. Космос, динамика, приключения, любовь.', 'как всегда, серия великолепна!', 'С фантазией и юмором у автора всё очень хорошо.',   'книга забавная.', 'Читается легко.', 'ну сюжет не плохой, но очень растянутый, читать можно через страницу', 'В какой-то момент стало скучно.'
    ];
    $text3 = ['рекомендую к прочтению',  'советую', "на разный вкус книга.", "есть продолжение?"];

    return  $text1[rand(0, count($text1) - 1)] . ', ' . $text2[rand(0, count($text2) - 1)] . ', ' . $text3[rand(0, count($text3) - 1)];
}

function translit($value)
{
    $converter = array(
        'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
        'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
        'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
        'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
        'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
        'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
        'э' => 'e',    'ю' => 'yu',   'я' => 'ya',

        'А' => 'A',    'Б' => 'B',    'В' => 'V',    'Г' => 'G',    'Д' => 'D',
        'Е' => 'E',    'Ё' => 'E',    'Ж' => 'Zh',   'З' => 'Z',    'И' => 'I',
        'Й' => 'Y',    'К' => 'K',    'Л' => 'L',    'М' => 'M',    'Н' => 'N',
        'О' => 'O',    'П' => 'P',    'Р' => 'R',    'С' => 'S',    'Т' => 'T',
        'У' => 'U',    'Ф' => 'F',    'Х' => 'H',    'Ц' => 'C',    'Ч' => 'Ch',
        'Ш' => 'Sh',   'Щ' => 'Sch',  'Ь' => '',     'Ы' => 'Y',    'Ъ' => '',
        'Э' => 'E',    'Ю' => 'Yu',   'Я' => 'Ya',
    );

    $value = strtr($value, $converter);
    return $value;
}
function randomFloat($min = 0, $max = 1)
{
    return round($min + mt_rand() / mt_getrandmax() * ($max - $min), 2);
}
function dowloude($urldw)
{
    $ch = curl_init();
    $options = [
        CURLOPT_URL            => $urldw,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 5.1; rv:34.0) Gecko/20100101 Firefox/34.0'
        ]
    ];
    curl_setopt_array($ch, $options);
    $file = curl_exec($ch);
    return $file;
}
function getPage($url)
{
    $user_agent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML,like  Gecko) Chrome/79.0.3945.130 Safari/537.36';
    $curl = curl_init($url);
    curl_setopt_array($curl, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_FOLLOWLOCATION => TRUE,
        CURLOPT_USERAGENT      => $user_agent,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_TIMEOUT        => 10,
    ]);
    $resoult = curl_exec($curl);
    return $resoult;
}