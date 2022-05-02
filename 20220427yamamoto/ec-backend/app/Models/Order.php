<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
    ];

    public $incrementing = false;
    protected $keyType = 'uuid';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['product_quantity']);
    }

    public function orderProducts()
    {
        return $this->hasMany(orderDetail::class);
    }
}
