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
use App\Http\Controllers\AddressController;

// Διαδρομή αρχικής σελίδας
Route::get('/', function (Request $request) {
    $categoryId = $request->query('category');
    $limit = $request->query('limit', 5); // Προεπιλογή 5 αν δεν παρέχεται
    $page = $request->query('page', 1); // Προεπιλογή 1 αν δεν παρέχεται
    $search = $request->query('search'); // Get the search query

    $query = Product::query();

    if ($categoryId) {
        $category = Category::find($categoryId);
        if ($category) {
            $query = $category->products();
        }
    }

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%');
        });
    }

    $products = $query->paginate($limit, ['*'], 'page', $page);

    // Έλεγχος αν ο ζητούμενος αριθμός σελίδας είναι έγκυρος
    if ($products->lastPage() < $page) {
        return redirect()->route('index', array_merge($request->except('page'), ['page' => $products->lastPage()]));
    }

    return view('index', [
        'products' => $products,
        'search' => $search,
        'categoryId' => $categoryId,
        'limit' => $limit,
        'page' => $page
    ]);
})->name('index');

// Διαδρομή σελίδας εγγραφής
Route::view('/register', 'auth.register')->middleware('guest')->name('register');

// Διαχείριση υποβολής φόρμας εγγραφής
Route::post('/register', [UserController::class, 'register'])->middleware('guest');

// Διαδρομή σελίδας σύνδεσης
Route::view('/login','auth.login')->middleware('guest')->name('login');

// Διαχείριση υποβολής φόρμας σύνδεσης
Route::post('/login', [UserController::class, 'login'])->middleware('guest');

// αποσύνδεσης
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');

// Διαδρομή αλλαγής κωδικού πρόσβασης
Route::post('/change-password', [UserController::class, 'change_password'])->middleware('auth')->name('change-password');

Route::view('/reset-password', 'auth.reset-password')->middleware('guest')->name('reset-password');

Route::post('/reset-password', [UserController::class, 'reset_password'])->middleware('guest');

// Διαδρομή προσθήκης προϊόντος στο καλάθι
Route::post('/add_to_cart/{product}', [CartController::class, 'add_to_cart'])->middleware('auth')->name('add_to_cart');

// Διαδρομή σελίδας καλαθιού
Route::view('/cart', 'cart')->middleware('auth')->name('cart');

// Διαδρομή ενημέρωσης ποσότητας προϊόντος στο καλάθι
Route::post('/cart/update-quantity/{id}', [CartController::class, 'update_quantity'])->name('cart.update_quantity');

// Διαδρομή αφαίρεσης προϊόντος από το καλάθι
Route::post('/cart/remove-item/{id}', [CartController::class, 'remove_item'])->name('cart.remove_item');

// Διαδρομή σελίδας ολοκλήρωσης αγοράς
Route::get('/checkout', function () {
    $cart = Auth::user()->cart()->firstOrFail();
    return view('checkout')->with('cart', $cart);
})->middleware('auth')->name('checkout');

// Διαδρομή αποθήκευσης παραγγελίας
Route::post('/order/store', [OrderController::class, 'store'])->middleware('auth')->name('order.store');

// Διαδρομή σελίδας παραγγελιών
Route::get('/orders', function () {
    $orders = Auth::user()->orders;
    return view('orders')->with('orders', $orders);
})->middleware('auth')->name('orders');

// Διαδρομές πόρων διεύθυνσης
Route::resource('address', AddressController::class)->middleware('auth');

// Διαδρομή σελίδας προφίλ
Route::get('/profile', function(){
    $user = Auth::user();
    return view('profile')->with('user', $user);
})->middleware('auth')->name('profile');