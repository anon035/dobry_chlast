<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    protected $fillable = [
        'order_id',
        'product_id',
        'count',
    ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function getSumAttribute()
    {
        if ($this->product) {
            return $this->product->priceDot * $this->count;
        }
        return 0;
    }
}
