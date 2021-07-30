<?php

use App\Http\Controllers\SendMessageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('send1', [SendMessageController::class, 'send1'])->name('send1');

Route::get('send2', [SendMessageController::class, 'send2'])->name('send2');

Route::get('report', [SendMessageController::class, 'report'])->name('report');

