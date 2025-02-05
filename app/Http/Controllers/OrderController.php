<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class OrderController
 *
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    /**
     * Store a new order.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'address' => 'required|exists:addresses,id',
            'cardNumber' => 'required|digits:16',
            'cardName' => 'required|string|max:255',
            'expiryDate' => 'required|date_format:m/y',
            'cvv' => 'required|digits:3',
        ]);
        Address::find($validated['address'])->address;
        DB::beginTransaction();
        try{
            foreach (json_decode($user->cart->items, true) as $item) {
                $product = Product::find($item['product_id']);
                $this->decreaseProductStock($product, $item['quantity']);
            }
            $order = Order::create([
                'user_id' => auth()->id(),
                'items' => $user->cart->items,
                'ship_to' => Address::find($validated['address'])->address,
                'order_status_id' => 1,
            ]);
            $user->cart->delete();
            DB::commit();
        } catch (Exception $e) {
            Log::error($user->id.' '.$e->getMessage());
            DB::rollBack();
            return redirect()->route('cart')->with('failure', $e->getMessage());
        }

        return redirect()->route('index')->with('success', 'Η παραγγελία σας ολοκληρώθηκε με επιτυχία');
    }

    /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $orders = auth()->user()->orders()->with('orderStatus')->get();
        return view('orders', compact('orders'));
    }

    /**
     * Decrease the stock of a product.
     *
     * @param \App\Models\Product $product
     * @param int $quantity
     * @return void
     */
    private function decreaseProductStock(Product $product, $quantity)
    {
        $product->stock -= $quantity;
        if($product->stock < 0){
            throw new Exception('Το προϊόν δεν είναι διαθέσιμο στην ποσότητα που επιλέξατε');
        }
        else{
            $product->save();
            return 1;
        }
    }
}
