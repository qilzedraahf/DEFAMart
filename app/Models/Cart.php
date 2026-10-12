<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id'];

    // Keranjang dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Keranjang memiliki banyak item produk
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}