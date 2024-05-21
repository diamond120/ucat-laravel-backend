<?php

use App\Http\Controllers\SectionController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ResponseController;

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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
  Route::post('register', [AuthController::class, 'register']);
  Route::post('forget', [AuthController::class, 'forget']);
  Route::post('login', [AuthController::class, 'login']);
  Route::post('logout', [AuthController::class, 'logout']);
  Route::post('refresh', [AuthController::class, 'refresh']);
  Route::get('me', [AuthController::class, 'me']);
});

Route::get('/packages', [PackageController::class, 'list']);
Route::get('/packages/{pid}', [PackageController::class, 'get']);

Route::post('/sessions', [SessionController::class, 'create']);
Route::get('/sessions', [SessionController::class, 'list']);
Route::get('/sessions/{sid}', [SessionController::class, 'get']);
Route::put('/sessions/{sid}/sections/{nid}', [SessionController::class, 'navigate']);
Route::put('/sessions/{sid}', [SessionController::class, 'finish']);

Route::get('/sessions/{sid}/questions/{qid}', [ResponseController::class, 'read']);
Route::post('/sessions/{sid}/questions/{qid}', [ResponseController::class, 'write']);