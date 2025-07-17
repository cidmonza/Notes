<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIfNotLogged;
use App\Http\Middleware\CheckIsLogged;
use Illuminate\Support\Facades\Route;

// Auth routes - user not logged
Route::middleware([CheckIfNotLogged::class])->group(function(){
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/loginSubmit', [AuthController::class, 'loginSubmit']);
});

// app routes - user logged
Route::middleware([CheckIsLogged::class])->group(function() {
    // home
    Route::get('/', [MainController::class, 'index'])->name('home');

    // new note
    Route::get('/newNote', [MainController::class, 'newNote'])->name('new');
    Route::post('/newNoteSubmit', [MainController::class, 'newNoteSubmit'])->name('newNoteSubmit');

    // edit note
    // O professor Spowkinthere está utilizando get para put (update) e delete, mais a frente vou ver como fazer da forma correta RESTful
    Route::get('/editNote/{id}', [MainController::class, 'editNote'])->name('edit');
    Route::post('/editNoteSubmit/{id}', [MainController::class, 'editNoteSubmit'])->name('editNoteSubmit');

    // delete note
    Route::get('/deleteNote/{id}', [MainController::class, 'deleteNote'])->name('delete');
    Route::get('/deleteNoteConfirm/{id}', [MainController::class, 'deleteNoteConfirm'])->name('deleteConfirm');

    //logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
