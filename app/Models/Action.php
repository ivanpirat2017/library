<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title_action',
        'description_action',
        'img_action',
        'books_action',
    ];
}
