<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

// 商品一覧ページへのルーティング
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 商品登録ページのルート
Route::get('/products/register', [ProductController::class, 'create'])->name('products.create');

// 商品登録処理のルート
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');

// 商品詳細画面表示
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// 商品編集画面表示
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');

// 商品情報更新
Route::post('/products/{id}', [ProductController::class, 'update'])->name('products.update');

// 商品削除
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

// 商品情報更新の PUT ルート（もし必要なら）
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
