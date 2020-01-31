<?php

namespace App;

use App\Exceptions\FileUploadException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function setPhotoPathAttribute($file)
    {
        $tempPath = $file->path();
        $dbPath = 'storage/categories/' . time() . '_' . $file->hashName();
        $photoPath =  getcwd() . '/' . $dbPath;
        if (!move_uploaded_file($tempPath, $photoPath)) {
            throw new FileUploadException();
        }
        $this->attributes['photo_path'] = $dbPath;
    }

    public function getLowestPriceAttribute()
    {
        return $this->products->min('priceDot');
    }

    public function getHighestPriceAttribute()
    {
        return $this->products->max('priceDot');
    }

    public function getOrderedPricesAttribute()
    {
        return array_values($this->products->sortBy('priceDot')->pluck('priceDot')->map(function ($price) {
            return floor($price);
        })->unique()->toArray());
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            foreach ($category->products as $product) {
                $product->delete();
            }
        });

        static::addGlobalScope('nvip', function (Builder $builder) {
            $builder->where('id', '!=', 15);
        });
    }
}
