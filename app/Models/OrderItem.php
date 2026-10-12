<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    // Item ini merujuk ke suatu pesanan
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Item ini merujuk ke produk tertentu
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
