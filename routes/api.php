<?php

use App\Http\Controllers\ActionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ParserController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\WatchBookController;
Route::get('generate', function (){
    \Illuminate\Support\Facades\Artisan::call('storage:link');

    echo 'ok';
});

Route::middleware('auth:api')->post('/creatrCollection', [CollectionController::class ,'creatrCollection']);
Route::middleware('auth:api')->get('/getcollection', [CollectionController::class ,'getCollection']);
Route::middleware('auth:api')->get('/dellCollection/{id}', [CollectionController::class ,'dellCollection']);
Route::middleware('auth:api')->get('/deletebooks/{id}', [BookController::class ,'DeleteBooks']);
Route::post('/login', [AuthController::class ,'login']);
Route::post('/register', [AuthController::class ,'reg']);
Route::middleware('auth:api')->get('/gettokens', [AuthController::class ,'getTokens']);
Route::middleware('auth:api')->post('/logout', [AuthController::class ,'logout']);
Route::middleware('auth:api')->get('/authcheck', [AuthController::class ,'authCheck']);
Route::middleware('auth:api')->get('/authadmincheck', [AuthController::class ,'authAdminCheck']);
Route::get('/doumlonddook/{id}', [BookController::class ,'doumlonddook']);
Route::get('/getbooksfilter/{flter}', [BookController::class ,'getbooksFilter']);
Route::middleware('auth:api')->post('/creategenre', [BookController::class ,'creategenre']);
Route::middleware('auth:api')->post('/createbook', [BookController::class ,'createbook']);
Route::middleware('auth:api')->post('/createstatus', [BookController::class ,'createstatus']);
Route::post('/getbookparser', [ParserController::class ,'getBookParser']);
Route::get('/setuser', [ParserController::class ,'setuser']);
Route::get('/setucoment', [ParserController::class ,'setucoment']);
Route::get('/setwath', [ParserController::class ,'setWath']);
Route::get('/getstatus', [BookController::class ,'getStatus']);
Route::get('/getbookid/{bookid}', [BookController::class ,'getbookid']);
Route::get('/getgenrebooks/{genre}', [BookController::class ,'getgenrebooks']);
Route::get('/getnewbooks', [BookController::class ,'getnewbooks']);
Route::get('/getgenres', [BookController::class ,'getgenres']);
Route::get('/getgenre/{genre}', [BookController::class ,'getgenre']);
Route::get('/getpopularbooks', [BookController::class ,'getpopularbooks']);
Route::get('/searchbook', [BookController::class ,'search']);
Route::post('/favourites', [CartController::class ,'getIdfavourites']);
Route::get('/getcommentbook/{bookid}', [CommentController::class ,'getcommentbook']);
Route::middleware('auth:api')->post('/likecoment', [CommentController::class ,'createlikecoment']);
Route::middleware('auth:api')->post('/addcoment', [CommentController::class ,'addcoment']);
Route::middleware('auth:api')->get('/getcommentadmin/{cmd}', [CommentController::class ,'getcommentAdmin']);
Route::middleware('auth:api')->post('/updateprofile', [UserController::class ,'updateprofile']);
Route::middleware('auth:api')->get('/getprofile', [UserController::class ,'getprofile']);
Route::middleware('auth:api')->get('/getuser/{id}', [UserController::class ,'getUser']);
Route::middleware('auth:api')->get('/getmessages/{id}', [ChatController::class ,'getmessages']);
Route::middleware('auth:api')->post('/addmessage', [ChatController::class ,'addmessage']);
Route::middleware('auth:api')->post('/updatacommentadmin', [CommentController::class ,'UpdataCommentAdmin']);
Route::post('/createaction', [ActionController::class ,'createaction']);
Route::get('/getaction', [ActionController::class ,'geteaction']);
Route::get('/getactionid/{id}', [ActionController::class ,'getActionId']);
Route::get('/fffffffff', [ProgressController::class ,'fdssssdsds']);

Route::middleware('auth:api')->get('/addwatchbook/{id}', [WatchBookController::class ,'addwatchBook']);
Route::middleware('auth:api')->get('/award/{id}', [ProgressController::class ,'Award']);
Route::middleware('auth:api')->get('/getawards', [ProgressController::class ,'getawards']);

Route::middleware('auth:api')->post('/bookupdate', [BookController::class ,'Update']);

Route::get('/readbook/{id}', [BookController::class ,'read']);
Route::get('/sdfvsdfdsvfdscfdsvfsdvfdvfvdsfsds/{id}', [AuthController::class ,'verification']);

Route:: post('/tokenupdate', [AuthController::class ,'tokenUpdate']);
