<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    protected $guarded = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contents(){
        $items = json_decode($this->items, true);
        $productIds = array_keys($items);
        $products = Product::whereIn('id', $productIds)->get();

        // Attach quantities to the products
        foreach ($products as $product) {
            $product->quantity = $items[$product->id];
        }
        return $products;
    }
}
