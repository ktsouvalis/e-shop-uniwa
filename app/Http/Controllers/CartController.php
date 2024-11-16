<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add_to_cart(Request $request, Product $product)
    {
        $userId = auth()->id();
        $productId = $product->id;
        $quantity = $request->input('quantity');

        // Fetch the user's cart
        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        // Decode the existing items
        $items = json_decode($cart->items, true) ?? [];

        // Check if the product is already in the cart
        foreach ($items as $item) {
            if ($item['product_id'] == $productId) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Το προϊόν υπάρχει ήδη στο καλάθι'
                ]);
            }
        }

        // Add the new product to the items array
        $items[] = [
            'product_id' => $productId,
            'quantity' => $quantity
        ];

        // Save the updated items back to the cart
        $cart->items = json_encode($items);
        $cart->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Το προϊόν προστέθηκε στο καλάθι!'
        ]);
    }

    public function update_quantity(Request $request, $productId)
    {
        $userId = auth()->id();
        $quantity = $request->input('quantity');

        // Fetch the user's cart
        $cart = Cart::where('user_id', $userId)->first();
        $items = json_decode($cart->items, true) ?? [];

        // Update the quantity for the specified product
        foreach ($items as &$item) {
            if ($item['product_id'] == $productId) {
                $item['quantity'] = $quantity;
                break;
            }
        }
        if(Product::find($productId)->stock < $quantity){
            return response()->json(['status' => 'failure', 'message'=>'Το προϊόν δεν υπάρχει σε αρκετή ποσότητα']);  
        }
        // Save the updated items back to the cart
        $cart->items = json_encode($items);
        try{
            $cart->save();
        }
        catch(Exception $e){
            return response()->json(['status' => 'failure', 'message'=>'Το καλάθι σας δεν ενημερώθηκε, προσπαθήστε αργότερα']);  
        }

        return response()->json(['status' => 'success', 'message'=>'Το καλάθι σας ενημερώθηκε']);
    }

    public function remove_item($productId)
    {
        $userId = auth()->id();

        // Fetch the user's cart
        $cart = Cart::where('user_id', $userId)->first();
        $items = json_decode($cart->items, true) ?? [];

        // Remove the specified product from the cart
        $items = array_filter($items, function ($item) use ($productId) {
            return $item['product_id'] != $productId;
        });

        // Save the updated items back to the cart
        $cart->items = json_encode(array_values($items));
        $cart->save();

        return response()->json(['status' => 'success']);
    }
}