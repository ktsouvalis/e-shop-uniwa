<?php

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/{category?}', function (Category $category = null) {
    if($category) {
        $products = $category->products;
    } else {
        $products = Product::all();
    }
    return view('index')->with('products', $products);
})->name('index');

Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');

Route::get('/logout', [UserController::class, 'logout'])->middleware('auth');

Route::post('/add_to_cart',function(Request $request){
    dd($request->all());
})->middleware('auth')->name('add_to_cart');

