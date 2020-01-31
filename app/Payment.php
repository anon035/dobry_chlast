<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $fillable = ['sum'];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function getSumAttribute($sum)
    {
        return number_format($sum, 2, '.', '');
    }

}
