<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Admin\QuizController;

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

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('/profile', ProfileController::class)->only(['store', 'update']);

});
Route::apiResource('/quizzes', QuizController::class);


Route::group(['prefix'=>'admin','middleware'=>'auth:sanctum'],function(){

});
