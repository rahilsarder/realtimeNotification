<?php

use App\Events\PostCreated;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->prefix('chat')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('chat.index');
    Route::post('/createRoom', [PostController::class, 'createRoom'])->name('chat.createRoom');
    Route::get('/{roomID}', [PostController::class, 'create'])->name('chat.index');
    Route::post('/{roomID}', [PostController::class, 'store'])->name('chat.create');
});

Route::get('/test', function () {
    event(new PostCreated('Hello World'));
    return 'Fired';
});


Route::get('uuid', function () {
    return Str::uuid();
});
