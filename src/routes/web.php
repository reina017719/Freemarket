<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;

//トップ画面(商品一覧)
Route::get('/', [ItemController::class, 'index']);
//会員登録
Route::post('/register', [UserController::class, 'register']);
//検索フォーム
Route::get('/item/search', [ItemController::class, 'search'])->name('items.search');
//商品詳細
Route::get('/item/{item_id}', [ItemController::class, 'item']);


Route::middleware('auth')->group(function () {
    //プロフィール編集
    Route::get('/mypage/profile', [UserController::class, 'edit_profile']);
    Route::post('/profile', [UserController::class, 'create_profile']);
    //商品購入画面
    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase']);
    //住所変更ページ
    Route::get('/purchase/address/{item_id}', [UserController::class, 'address']);
    Route::patch('/update', [UserController::class, 'update']);
    //プロフィール画面（購入／出品タブ切替はクエリ ?tab=buy / ?tab=sell）
    Route::get('/mypage', [UserController::class, 'mypage']);
    //商品出品ページ
    Route::get('/sell', [ItemController::class, 'sell']);
    Route::post('/sell', [ItemController::class, 'store']);
    Route::post('/comment', [ItemController::class, 'comment']);
    Route::post('/items/{item}/favorite', [ItemController::class, 'favorite']);
});