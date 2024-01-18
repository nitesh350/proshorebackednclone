<?php

use App\Http\Controllers\Api\Student\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\QuizController;
use App\Http\Controllers\Api\Admin\QuizCategoryController;
use App\Http\Controllers\Api\Admin\QuestionCategoryController;
use App\Http\Controllers\Api\Admin\QuestionController;
use App\Http\Controllers\Api\Student\UserDataController;

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

    Route::apiResource('/question-categories', QuestionCategoryController::class);
    Route::apiResource('/quiz-categories', QuizCategoryController::class);
    Route::apiResource('/quizzes', QuizController::class);
    Route::apiResource('/questions', QuestionController::class);
});

// Student Routes
Route::group(['prefix' => 'student', 'middleware' => 'auth:sanctum'], function () {

    Route::apiResource('/profile', ProfileController::class)->only(['store', 'update']);
});
