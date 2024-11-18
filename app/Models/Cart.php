<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

/**
 * Class Cart
 *
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property string $items
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 */
class Cart extends Model
{
    protected $table = 'carts';
    protected $guarded = [
        'id',
    ];

    /**
     * Get the user that owns the cart.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the contents of the cart.
     *
     * @return \Illuminate\Support\Collection
     */
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
