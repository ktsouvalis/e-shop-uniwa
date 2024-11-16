<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function contents(){
        
        $items = json_decode($this->items, true);
        $productIds = array_column($items, 'product_id');
        $products = Product::whereIn('id', $productIds)->get();

        // Attach quantities to the products
        foreach ($products as $product) {
            $product->quantity = collect($items)->firstWhere('product_id', $product->id)['quantity'];
        }
        return collect($products);  
    }

    public function total(){
        $total = 0;
        foreach ($this->contents() as $product) {
            $total += $product->price * $product->quantity;
        }
        return $total;
    }
}
