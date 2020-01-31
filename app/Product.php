<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{

    protected $appends = ['is_vip'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function getCategoryNameAttribute()
    {
        if ($this->category_id == 15) {
            $category = Category::withoutGlobalScope('nvip')->where('id', 15)->first();
        } else {
            $category = $this->category;
        }

        if (!$category) {
            return '';
        }
        return $category->name;
    }

    public function setPhotoPathAttribute($file)
    {
        $tempPath = $file->path();
        $dbPath = 'storage/products/' . time() . '_' . $file->hashName();
        $photoPath =  getcwd() . '/' . $dbPath;
        if (!move_uploaded_file($tempPath, $photoPath)) {
            throw new FileUploadException();
        }
        $this->attributes['photo_path'] = $dbPath;
    }

    public function setPriceAttribute($price)
    {
        $this->attributes['price'] = str_replace(',', '.', $price);
    }

    public function getPriceAttribute($price)
    {
        return number_format((float) $price, 2, ',', '');
    }

    public function getPriceDotAttribute()
    {
        return ((float) str_replace(',', '.', $this->price));
    }

    public function setStockAttribute($stock)
    {
        if ($stock > 0) {
            $this->attributes['stock'] = $stock;
        } else {
            $this->attributes['stock'] = 0;
        }
    }

    public function getIsVipAttribute()
    {
        return $this->category_name == 'VIP';
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('without_nvip', function (Builder $builder) {
            $builder->whereHas('category', function ($query) {
                $query->withoutGlobalScope('nvip');
            });
        });
    }
}
