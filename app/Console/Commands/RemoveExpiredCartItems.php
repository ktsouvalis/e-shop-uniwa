<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;

class RemoveExpiredCartItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carts:expire-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $carts = Cart::all();
        $error = 0;
        foreach ($carts as $cart) {
            $items = $cart->contents();
            foreach ($items as $item) {
                if (Carbon::parse($item->time_added)->addMinutes(15)->isPast()) {
                    try{
                        $product = Product::find($item->id);
                        $product->stock += $item->quantity;
                        $product->save();
                        // Remove item from cart
                        $cartItems = json_decode($cart->items, true);
                        $cartItems = array_filter($cartItems, function($cartItem) use ($item) {
                            return $cartItem['product_id'] != $item->id;
                        });
                        $cart->items = json_encode(array_values($cartItems));
                        $cart->save();
                    } catch (\Exception $e) {
                        $error=1;
                        Log::error('Failed to remove item from cart: ' . $e->getMessage());
                        continue;
                    }
                }
            }
        }
        if ($error) {
            $this->error('Failed to remove some expired items from cart. Check Log for more information');
        } else {
            $this->info('Expired items removed from cart');
        }
    }
}
