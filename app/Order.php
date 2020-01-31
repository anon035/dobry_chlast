<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'user_id',
        'address',
        'name',
        'email',
        'phone',
        'note',
        'card',
        'delivery',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function items()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    public function getSumAttribute()
    {
        $sum = 0;
        foreach ($this->items as $item) {
            $sum += $item->sum;
        }
        if ($this->delivery) {
            $sum += 5;
        }
        return $sum;
    }

    public function getPaidAttribute()
    {
        if (!$this->card) {
            return true;
        }
        return !($this->paid_sum < $this->sum);
    }

    public function getPaidSumAttribute()
    {
        $paidSum = 0.00;
        foreach ($this->payments as $payment) {
            if ($payment->paid) {
                $paidSum += $payment->sum;
            }
        }
        return $paidSum;
    }

    public function getIsVipAttribute()
    {
        foreach ($this->items as $item) {
            if ($item->product->is_vip) {
                return true;
            }
        }
        return false;
    }

    public function getProductPreviewAttribute()
    {
        $preview = '';
        $over = false;
        foreach ($this->items as $item) {
            if ($item->product) {
                $preview .= $item->product->name;
            }
            if (strlen($preview) > 50) {
                $over = true;
                break;
            }
        }
        if ($over) {
            return substr($preview, 0, 50) . '...';
        }
        return $preview;
    }
}
