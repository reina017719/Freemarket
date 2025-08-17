<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;

Route::get('/', [ItemController::class, 'index']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/item/search', [ItemController::class, 'search'])->name('items.search');
Route::get('/item/{item_id}', [ItemController::class, 'item']);

Route::middleware('auth')->group(function () {
    Route::get('/mypage/profile', [UserController::class, 'edit_profile']);
    Route::post('/profile', [UserController::class, 'create_profile']);
    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase']);
    Route::get('/purchase/address/{item_id}', [UserController::class, 'address']);
    Route::patch('/update', [UserController::class, 'update']);
    Route::get('/mypage', [UserController::class, 'mypage']);
    Route::get('/sell', [ItemController::class, 'sell']);
    Route::post('/sell', [ItemController::class, 'store']);
    Route::post('/comment', [ItemController::class, 'comment']);
    Route::post('/items/{item}/favorite', [ItemController::class, 'favorite']);
});