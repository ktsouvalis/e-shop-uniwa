<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 *
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property string $items
 * @property int $order_status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\OrderStatus $status
 */
class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = [
        'id',
    ];

    /**
     * Get the user that owns the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the status of the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    /**
     * Get the contents of the order.
     *
     * @return \Illuminate\Support\Collection
     */
    public function contents()
    {
        $items = json_decode($this->items, true);
        $productIds = array_column($items, 'product_id');
        $products = Product::whereIn('id', $productIds)->get();

        // Attach quantities to the products
        foreach ($products as $product) {
            $product->quantity = collect($items)->firstWhere('product_id', $product->id)['quantity'];
        }
        return collect($products);  
    }

    /**
     * Calculate the total price of the order.
     *
     * @return float
     */
    public function total()
    {
        $total = 0;
        foreach ($this->contents() as $product) {
            $total += $product->price * $product->quantity;
        }
        return $total;
    }
}
