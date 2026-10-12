<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $fillable = ['cart_id', 'product_id', 'quantity'];

    // Item ini milik suatu keranjang
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // Item ini merujuk ke produk tertentu
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}