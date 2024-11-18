<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cart;
use Carbon\Carbon;

class RemoveExpiredCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:empty-carts';

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
        $expiredCarts = Cart::where('created_at', '<', Carbon::now()->subMinutes(30))->get();

        foreach ($expiredCarts as $cart) {
            $cart->delete();
        }

        $this->info('Expired carts have been removed.');
    }
}
