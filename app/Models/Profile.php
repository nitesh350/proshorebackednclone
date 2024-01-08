<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "profiles";

    protected $fillable = [
        'user_id', 'education', 'skills', 'experience', 'career'
    ];

    protected $casts = [
        'skills' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
