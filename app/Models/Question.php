<?php

namespace App\Models;

use App\Models\QuestionCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory,SoftDeletes;

     /**
     * @var string
     */
    protected $table = "questions";

    /**
     * @var string[]
     */
    protected $casts = [
        'options' => "json"
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        "title","category_id","slug","description","options","answer","status","weightage"
    ];

    /**
     * @return BelongsTo
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo(QuestionCategory::class,'category_id');
    }
}
