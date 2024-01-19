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

$adminAbilities = ['manage-quiz-categories', 'manage-quiz', 'manage-questions', 'manage-question-categories', 'view-results'];
$studentAbilities = ['view-quizzes', 'can-attempt-quiz', 'view-quiz-results', 'manage-profile'];

// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'abilities:' . implode(',', $adminAbilities)]], function () {

    Route::apiResource('/question-categories', QuestionCategoryController::class);
    Route::apiResource('/quiz-categories', QuizCategoryController::class);
    Route::apiResource('/quizzes', QuizController::class);
    Route::apiResource('/questions', QuestionController::class);
});

// Student Routes
Route::group(['prefix' => 'student', 'middleware' => ['auth:sanctum', 'abilities:' . implode(',', $studentAbilities)]], function () {

    Route::apiResource('/profile', ProfileController::class)->only(['store', 'update']);
});
