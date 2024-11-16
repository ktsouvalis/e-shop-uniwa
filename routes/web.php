<?php

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;

Route::get('/', function (Request $request) {
    $categoryId = $request->query('category');
    if ($categoryId) {
        $category = Category::find($categoryId);
        $products = $category ? $category->products : collect();
    } else {
        $products = Product::all();
    }
    return view('index')->with('products', $products);
})->name('index');

Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');

Route::post('/login', [UserController::class, 'login'])->middleware('guest');

Route::get('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');

Route::post('/add_to_cart/{product}', [CartController::class, 'add_to_cart'])->middleware('auth')->name('add_to_cart');

Route::get('/cart', function () {
    $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
    return view('cart')->with('cart', $cart);
})->middleware('auth')->name('cart');

Route::post('/cart/update-quantity/{id}', [CartController::class, 'update_quantity'])->name('cart.update_quantity');
Route::post('/cart/remove-item/{id}', [CartController::class, 'remove_item'])->name('cart.remove_item');

