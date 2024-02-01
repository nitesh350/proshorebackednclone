<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "profiles";

    protected $fillable = [
        'user_id', 'education', 'skills', 'experience', 'career', 'avatar'
    ];

    protected $casts = [
        'skills' => 'json'
    ];

    /**
     * @var string[]
     */
    public $appends = [
        'avatar_url'
    ];

    /**
     * @return string
     */
    public function getAvatarUrlAttribute(): string
    {
        return asset($this->avatar);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
