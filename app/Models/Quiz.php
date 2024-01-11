<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "quizzes";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'category_id', 'thumbnail', 'description', 'time', 'retry_after', 'status'
    ];

    public $appends = [
        'thumbnail_url'
    ];

    public function getThumbnailUrlAttribute(): string
    {
        return asset($this->thumbnail);
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(QuizCategory::class, 'category_id');
    }

    /**
     * @return BelongsToMany
     */
    public function questionCategories(): BelongsToMany
    {
        return $this->belongsToMany(QuestionCategory::class);
    }
}
