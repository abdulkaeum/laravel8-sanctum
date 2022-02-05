<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GalaxyController;
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

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'store'])->name('login');


// authenticate users access using tokens via the sanctum authenticated guard
Route::group(['middleware' => ['auth:sanctum']], function (){
    Route::get('profile', function (){
        return auth()->user();
    });

    Route::apiResource('galaxies', GalaxyController::class);

    Route::post('destroy', [AuthController::class, 'destroy'])->name('logout');
});
