<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'total_price', 'status', 'shipping_address'];

    // Pesanan milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Pesanan memiliki banyak item detail barang
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
