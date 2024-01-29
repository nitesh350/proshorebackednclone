<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\QuizController;
use App\Http\Controllers\Api\Admin\ResultController;
use App\Http\Controllers\Api\Admin\GetQuizCategories;
use App\Http\Controllers\Api\Admin\QuestionController;
use App\Http\Controllers\Api\Student\ProfileController;
use App\Http\Controllers\Api\Student\UserDataController;
use App\Http\Controllers\Api\Student\StartQuizController;
use App\Http\Controllers\Api\Admin\QuizCategoryController;
use App\Http\Controllers\Api\Student\GetQuizzesController;
use App\Http\Controllers\Api\Student\SubmitQuizController;
use App\Http\Controllers\Api\Admin\QuestionCategoryController;
use App\Http\Controllers\Api\Admin\GetRegisteredStudentController;
use App\Http\Controllers\Api\Admin\GetQuestionCategoriesController;
use App\Http\Controllers\Api\Admin\StudentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

require __DIR__ . '/auth.php';

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user', UserDataController::class);
});

// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => 'auth:sanctum'], function () {

    Route::get('/question-categories/all', GetQuestionCategoriesController::class)->middleware('ability:manage-question-categories,manage-questions');
    Route::apiResource('/question-categories', QuestionCategoryController::class)->middleware('ability:manage-question-categories');
    Route::get('/quiz-categories/all', GetQuizCategories::class)->middleware('ability:manage-quizzes,manage-quiz-categories');
    Route::apiResource('/quiz-categories', QuizCategoryController::class)->middleware('ability:manage-quiz-categories');
    Route::apiResource('/quizzes', QuizController::class)->middleware('ability:manage-quizzes');
    Route::apiResource('/questions', QuestionController::class)->middleware('ability:manage-questions');
    Route::apiResource('/results', ResultController::class)->only(['index'])->middleware('ability:manage-results');
    Route::apiResource('/students', StudentController::class)->only(['index'])->middleware('ability:manage-students');
});

Route::group(['prefix' => 'student', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/quizzes/{quiz}/start', StartQuizController::class)->middleware('ability:can-attempt-quiz');
    Route::apiResource('/profile', ProfileController::class)->only(['store', 'update'])->middleware('ability:manage-profile');
    Route::post('/quizzes/{quiz}/submit', SubmitQuizController::class)->middleware('ability:can-attempt-quiz');
    Route::get('/quizzes/all', GetQuizzesController::class)->middleware('abilities:can-attempt-quiz');
});
