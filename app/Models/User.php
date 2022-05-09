<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'patronymic',
        'email',
        'password',
        'avatar',
        'about_img',
        'role',
        'about_title',
        'about_information',
        'api_token',
    ];
    function  gettoken()
    {
        $this->api_token = Str::random(64);
        $this->save();
        return $this->api_token;
    }
    function  getAdminBool()
    {
        if ($this->role == 'admin') {
            return  true;
        }
        return  false;
    }
}
