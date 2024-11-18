<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class MoveOrderToNextStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:next-status {order} {status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mock the process of setting order to the next status.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $order = Order::find($this->argument('order'));
        if(!$order) {
            $this->error('Order not found.');
            return;
        }
        if(!in_array($this->argument('status'), [1, 2, 3])) {
            $this->error('Invalid status provided.');
            return;
        }
        if($this->argument('status') == $order->order_status_id) {
            $this->error('Order is already in this status.');
            return;
        }
        
        $order->order_status_id = $this->argument('status');
        $order->save();

        $this->info('Order status set to: '.$order->status->name);
    }
}
