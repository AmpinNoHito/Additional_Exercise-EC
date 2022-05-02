<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'caption',
        'description',
        'image',
        'created_at',
        'updated_at',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('product_quantity');
    }

    public function orderProducts()
    {
        return $this->hasMany(orderDetail::class);
    }
}
