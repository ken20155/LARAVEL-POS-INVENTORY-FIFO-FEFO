<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController\MainController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('', [MainController::class, 'redirect']);
Route::any('auth/view/{param1}', [MainController::class, 'getAuthForm']);
Route::any('auth/run/{param1}', [MainController::class, 'authFn']);
Route::any('component/view/{param1}', [MainController::class, 'getContent']);
Route::any('component/run/{param1}/{param2}', [MainController::class, 'runComponentFunction']);
Route::any('pages/{param1}', [MainController::class, 'getPublicPages']);
Route::get('/{module}/js/custom', [MainController::class, 'serveCustomJS'])->name('js.custom');

