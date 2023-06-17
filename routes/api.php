<?php

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\JobController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('user-category/update', [UserController::class, 'updateCategory']);

Route::get('categories', [CategoryController::class, 'list']);

Route::get('jobs', [JobController::class, 'list']);
Route::post('jobs/likes/update', [JobController::class, 'job_likes']);
Route::post('generate-result', [JobController::class, 'generateResult']);
Route::post('cloud-result', [JobController::class, 'generateViewCloudResult']);
