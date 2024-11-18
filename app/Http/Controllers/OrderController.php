<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try{
            $order = Order::create([
                'user_id' => auth()->id(),
                'items' => $user->cart->items,
                'ship_to' => $validated['address'],
                'order_status_id' => 1,
            ]);


            $user->cart->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout')->with('failure', 'Αποτυχία αποστολής παραγγελίας, δοκιμάστε αργότερα '.$e->getMessage());
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
}
