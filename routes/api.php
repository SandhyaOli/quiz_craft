<?php

use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\ResponseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/welcome', function () {
    return response()->json(['message' => 'Hello!'], 200);
});

Route::post('/questionnaires/generate', [QuestionnaireController::class, 'generate']);
Route::get('/questionnaires/active', [QuestionnaireController::class, 'active']);

Route::get('/questionnaires/{questionnaire}/invite', [QuestionnaireController::class, 'sendInvitations']);

Route::get('/questionnaires/{questionnaire}/student/{student}', [QuestionnaireController::class, 'show']);
Route::post('/responses/store', [ResponseController::class, 'store']);