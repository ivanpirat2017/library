<?php

namespace App\Http\Controllers;

use App\Http\Resources\AwardResource;
use App\Models\Award;
use App\Models\Collection;
use App\Models\Comment;
use App\Models\Like_comment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgressController extends Controller
{
    public function  getawards()
    {
        $users = User::select('id','first_name','last_name')->get();
        $arrusers = [];
        foreach ($users as $user) {
            $award['awardUsers']= $user;
            $award['sunPoints']= AllcheckAwardSumUser($user->id);
            array_push($arrusers, $award);
        }
        return    response()->json(['data' => $arrusers], 200);
    }

    public function Award($id)
    {
        if (Task::count() == 0) {
            start();
        }
        return    response()->json(['data' =>  Award::where('award_user_id', '=', $id)->get()], 200);
    }
}
function AllcheckAwardSumUser($id)
{
    $sumPoints = 0;
    $userId = $id;
    $userComments = Comment::where('user_comment_id', '=', $userId)->count();
    $userWatchbooks =  DB::table('watchbooks')->where('watch_user_id', '=', $userId)->count();
    $userLike = Like_comment::where('like_user_id', '=', $userId)->count();
    $userCollection = Collection::where('users_id', '=', $userId)->count();
    $userChatBooks  = DB::table('chat_books')->where('user_id', '=', $userId)->count();
    $sumPoints  += TaskCreate($userComments, 5, $userId, 1);
    $sumPoints  += TaskCreate($userComments, 20, $userId, 2);
    $sumPoints  += TaskCreate($userComments, 150, $userId, 3);
    $sumPoints  += TaskCreate($userComments, 500, $userId, 4);
    $sumPoints  += TaskCreate($userComments, 1000, $userId, 5);

    $sumPoints  += TaskCreate($userLike, 5, $userId, 6);
    $sumPoints  += TaskCreate($userLike, 20, $userId, 7);
    $sumPoints  += TaskCreate($userLike, 150, $userId, 8);
    $sumPoints  += TaskCreate($userLike, 500, $userId, 9);
    $sumPoints  += TaskCreate($userLike, 1000, $userId, 10);

    $sumPoints  += TaskCreate($userCollection, 1, $userId, 11);
    $sumPoints  += TaskCreate($userCollection, 2, $userId, 12);
    $sumPoints  += TaskCreate($userCollection, 5, $userId, 13);
    $sumPoints  += TaskCreate($userCollection, 10, $userId, 14);
    $sumPoints  += TaskCreate($userCollection, 20, $userId, 15);

    $sumPoints  += TaskCreate($userChatBooks,  50, $userId, 16);
    $sumPoints  += TaskCreate($userChatBooks,  150, $userId, 17);
    $sumPoints  += TaskCreate($userChatBooks,  500, $userId, 18);
    $sumPoints  += TaskCreate($userChatBooks,  1000, $userId, 19);
    $sumPoints  += TaskCreate($userChatBooks,  5000, $userId, 20);


    $sumPoints  += TaskCreate($userWatchbooks, 10, $userId, 21);
    $sumPoints  += TaskCreate($userWatchbooks, 100, $userId, 22);
    $sumPoints  += TaskCreate($userWatchbooks, 200, $userId, 23);
    $sumPoints  += TaskCreate($userWatchbooks, 500, $userId, 24);
    $sumPoints  += TaskCreate($userWatchbooks, 2000, $userId, 25);
    return   $sumPoints;
}
function start()
{
    Task::create(['name' => 'Прокомментировано 5 книг', 'player_points' => 10, 'level' => 0]); //1
    Task::create(['name' => 'Прокомментировано 20 книг', 'player_points' => 20, 'level' => 1]); //2
    Task::create(['name' => 'Прокомментировано 150 книг', 'player_points' => 50, 'level' => 2]); //3
    Task::create(['name' => 'Прокомментировано 500 книг', 'player_points' => 100, 'level' => 3]); //4
    Task::create(['name' => 'Прокомментировано 1000 книг', 'player_points' => 200, 'level' => 4]); //5
    //
    Task::create(['name' => 'Лайкнуто 5 комментариев', 'player_points' => 10, 'level' => 0]); //6
    Task::create(['name' => 'Лайкнуто 20 комментариев', 'player_points' => 20, 'level' => 1]); //7
    Task::create(['name' => 'Лайкнуто 150 комментариев', 'player_points' => 50, 'level' => 2]); //8
    Task::create(['name' => 'Лайкнуто 500 комментариев', 'player_points' => 100, 'level' => 3]); //9
    Task::create(['name' => 'Лайкнуто 1000 комментариев', 'player_points' => 200, 'level' => 4]); //10
    //
    Task::create(['name' => 'Создано и хранится 1 коллекция книг', 'player_points' => 10, 'level' => 0]); //11
    Task::create(['name' => 'Создано и хранится 2 коллекции книг', 'player_points' => 20, 'level' => 1]); //12
    Task::create(['name' => 'Создано и хранится 5 коллекций книг', 'player_points' => 50, 'level' => 2]); //13
    Task::create(['name' => 'Создано и хранится 10 коллекций книг', 'player_points' => 100, 'level' => 3]); //14
    Task::create(['name' => 'Создано и хранится 20 коллекций книг', 'player_points' => 200, 'level' => 4]); //15
    //
    Task::create(['name' => 'Написано 50 сообщений в чате', 'player_points' => 10, 'level' => 0]); //16
    Task::create(['name' => 'Написано 150 сообщений в чате', 'player_points' => 20, 'level' => 1]); //17
    Task::create(['name' => 'Написано 500 сообщений в чате', 'player_points' => 50, 'level' => 2]); //18
    Task::create(['name' => 'Написано 1000 сообщений в чате', 'player_points' => 100, 'level' => 3]); //19
    Task::create(['name' => 'Написано 5000 сообщений в чате', 'player_points' => 200, 'level' => 4]); //20
    //
    Task::create(['name' => 'Просмотрено 10 книг', 'player_points' => 10, 'level' => 0]); //21
    Task::create(['name' => 'Просмотрено 100 книг', 'player_points' => 20, 'level' => 1]); //22
    Task::create(['name' => 'Просмотрено 200 книг', 'player_points' => 50, 'level' => 2]); //23
    Task::create(['name' => 'Просмотрено 500 книг', 'player_points' => 100, 'level' => 3]); //24
    Task::create(['name' => 'Просмотрено 2000 книг', 'player_points' => 200, 'level' => 4]); //25
}

function TaskCreate($count, $need, $iduser, $n)
{
    $sum = 0;
    $istask =  Award::where('award_user_id', '=', $iduser)->where('award_task_id', '=', $n)->count();
    if ($count >= $need) {
        $task = Task::find($n);
        $sum = $task->player_points;
        if ($istask == 0) {
            Award::create(['award_user_id' => $iduser,  'award_task_id' => $n]);
        }
    }
    return $sum;
}
