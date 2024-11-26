<?php

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

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

Route::get('/register', function () {
    return view('auth.register');
})->middleware('guest')->name('register');

Route::post('/register', [UserController::class, 'register'])->middleware('guest');

Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

Route::post('/login', [UserController::class, 'login'])->middleware('guest');

Route::get('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');

Route::post('/add_to_cart/{product}', [CartController::class, 'add_to_cart'])->middleware('auth')->name('add_to_cart');

Route::get('/cart', function () {
    return view('cart');
})->middleware('auth')->name('cart');

Route::post('/cart/update-quantity/{id}', [CartController::class, 'update_quantity'])->name('cart.update_quantity');
Route::post('/cart/remove-item/{id}', [CartController::class, 'remove_item'])->name('cart.remove_item');

Route::post('/cart/clear', function(){
    Artisan::call('carts:empty');
    return response()->json([
        'status' => 'success',
        'message' => 'Το καλάθι άδειασε επιτυχώς'
    ]);
})->name('clear-carts');

Route::get('/checkout', function () {
    $cart = Auth::user()->cart;
    return view('checkout')->with('cart', $cart);
})->middleware('auth')->name('checkout');

Route::post('/order/store', [OrderController::class, 'store'])->middleware('auth')->name('order.store');

Route::get('/orders', function () {
    $orders = Auth::user()->orders;
    return view('orders')->with('orders', $orders);
})->middleware('auth')->name('orders');

