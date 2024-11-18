<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;

class RemoveExpiredCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carts:empty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Empty carts that have been inactive for 30 minutes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredCarts = Cart::where('created_at', '<', Carbon::now()->subMinutes(30))->get();
        if($expiredCarts->isEmpty()) {
            $this->info('No expired carts found.');
            return;
        }
        foreach ($expiredCarts as $cart) {
            $items = json_decode($cart->items, true) ?? [];

            // Restore the stock for each item in the cart
            foreach ($items as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->stock += $item['quantity'];
                    $product->save();
                }
            }

            // Empty the cart
            $cart->items = json_encode([]);
            $cart->save();

            // Delete the cart
            $cart->delete();
        }

        $this->info('Expired carts have been removed.');
    }
}
