<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'passed',
        'total_question',
        'total_answered',
        'total_right_answer',
        'total_time'
    ];
}
