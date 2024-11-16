<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

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

    public function contents()
    {
        if (!$this->items) {
            return collect();
        }
        $items = json_decode($this->items, true);
        $productIds = array_column($items, 'product_id');
        $products = Product::whereIn('id', $productIds)->get();

        // Attach quantities to the products
        foreach ($products as $product) {
            $product->quantity = collect($items)->firstWhere('product_id', $product->id)['quantity'];
        }
        return collect($products);
    }
}
