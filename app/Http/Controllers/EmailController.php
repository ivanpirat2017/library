<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class EmailController extends Controller
{
     public function sendEmail(){

        $userid= 1;

        Mail::send( 'sendemail',['userid'=>$userid], function ($message) {
            $message->to('ivan62196211@gmail.com', 'Ivan')->subject('тест EMAIL');
            $message->from('vera621962@gmail.com', 'vera');
        });

     }
}
