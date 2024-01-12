<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionCategory extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "question_categories";

    /**
     * @var string[]
     */
    protected $fillable=[
        'title',
        'slug'
    ];

    public function quizzes():BelongsToMany{
     return $this->belongsToMany(Quiz::class,"question_category_quiz");
    }
}
