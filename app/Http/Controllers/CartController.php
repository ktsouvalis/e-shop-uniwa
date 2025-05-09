<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

/**
 * Class CartController
 *
 * @package App\Http\Controllers
 */
class CartController extends Controller
{
    /**
     * Add a product to the cart.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
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
                    'message' => 'Το προϊόν υπάρχει ήδη. Μπορείτε να ενημερώσετε την ποσότητα του προϊόντος όταν επισκεφθείτε το καλάθι σας.',
                    'new_stock' => $product->stock
                ]);
            }
        }
        if($product->stock < $quantity) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Το προϊόν δεν υπάρχει σε αρκετή ποσότητα',
                'new_stock' => $product->stock
            ]);
        }

        // Add the new product to the items array
        $items[] = [
            'product_id' => $productId,
            'quantity' => $quantity,
            'time_added' => now()
        ];

        // Save the updated items back to the cart
        $cart->items = json_encode($items);
        try{
            $cart->save();
        } 
        catch (\Exception $e) {
            Log::error($userId.' '.$e->getMessage());
            return response()->json([
                'status' => 'failure',
                'message' => 'Το προϊόν δεν προστέθηκε στο καλάθι, προσπαθήστε αργότερα',
                'new_stock' => $product->stock
            ]);
        }
       
        return response()->json([
            'status' => 'success',
            'message' => 'Το προϊόν προστέθηκε στο καλάθι!',
            
            'new_stock' => $product->stock
        ]);
    }

    /**
     * Update the quantity of a product in the cart.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $productId
     * @return \Illuminate\Http\RedirectResponse
     */
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
                $oldQuantity = $item['quantity'];
                $item['quantity'] = $quantity;
                break;
            }
        }

        // Check if the new quantity exceeds the available stock
        $product = Product::find($productId);
        if ($product->stock < $quantity) {
            return redirect(route('cart'))->with('failure', 'Το προϊόν δεν υπάρχει σε αρκετή ποσότητα: ' . $product->stock);
        }

        // Save the updated items back to the cart
        $cart->items = json_encode($items);
        try {
            $cart->save();
        } catch (Exception $e) {
            Log::error($userId.' '.$e->getMessage());
            return redirect(route('cart'))->with('failure', 'Το καλάθι σας δεν ενημερώθηκε, προσπαθήστε αργότερα');
        }

        return redirect(route('cart'))->with('success', 'Το καλάθι σας ενημερώθηκε');
    }

    /**
     * Remove a product from the cart.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove_item(Request $request, $productId)
    {
        $userId = auth()->id();

        // Fetch the user's cart
        $cart = Cart::where('user_id', $userId)->first();
        $items = json_decode($cart->items, true) ?? [];

        // Find the item to remove and its quantity
        $itemToRemove = null;
        foreach ($items as $item) {
            if ($item['product_id'] == $productId) {
                $itemToRemove = $item;
                break;
            }
        }

        // Remove the specified product from the cart
        $items = array_filter($items, function ($item) use ($productId) {
            return $item['product_id'] != $productId;
        });

        // Save the updated items back to the cart
        $cart->items = json_encode(array_values($items));
        try{
            $cart->save();
        }
        catch (\Exception $e) {
            Log::error($userId.' '.$e->getMessage());
            return redirect(route('cart'))->with('failure', 'Το προϊόν δεν αφαιρέθηκε από το καλάθι, προσπαθήστε αργότερα');
        }

        if(empty($items)) {
            try{
                $cart->delete();
            }
            catch (\Exception $e) {
                Log::error($userId.' '.$e->getMessage());
            }
        }
        return redirect(route('cart'))->with('success', 'Το προϊόν αφαιρέθηκε από το καλάθι');
    }
}