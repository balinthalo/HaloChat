<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/logout',[AuthenticationController::class, 'logout'])->name('logout');
    Route::controller(ChatController::class)->group(function(){
        Route::get('/', 'index')->name('chat.index');
        Route::get('/chat/create','create')->name('chat.create');
        Route::post('/chat/store','store')->name('chat.store');
        Route::get('/chat/{chat}/edit','edit')->name('chat.edit');
        Route::post('/chat/{chat}/update','update')->name('chat.update');
        Route::delete('/chat/{chat}/delete','delete')->name('chat.delete');
        Route::get('/chat/{chat}/invite', 'invite')->name('chat.invite');
        Route::post('/chat/{chat}/invite', 'add')->name('chat.add');
        Route::get('/chat/{chat}/show', 'show')->name('chat.show');
    });
    Route::controller(MessageController::class)->group(function(){
        Route::post('/chat/{chat}/message/store', 'store')->name('message.store');
        Route::get('/chat/{chat}/download', 'download')->name('message.download');
    });
});

Route::middleware(['guest'])->group(function () {
    Route::controller(AuthenticationController::class)->group(function(){
        Route::get('/login', 'loginView')->name('login');
        Route::get('/log', 'login')->name('log');
        Route::get('/registration', 'registrationView')->name('registration');
        Route::get('/reg', 'registration')->name('reg');
    });
});
