<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Award extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'award_user_id',
        'award_task_id',
    ];
    protected $with = [
        'taskitem', 'setuser',
    ];
    public function taskitem()
    {
        return  $this->hasOne(Task::class, 'id', 'award_task_id');
    }
    public function setuser()
    {
        return  $this->hasOne(User::class, 'id', 'award_user_id');
    }
    
}
