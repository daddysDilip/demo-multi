<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title', 'skucode', 'category', 'tags', 'description','sizes', 'price', 'offer_price', 'selling_price', 'stock', 'tax', 'shipping_cost', 'feature_image', 'policy', 'featured', 'views', 'created_at', 'updated_at', 'status','metatitle','metadec','metakey'];

    public static $withoutAppends = false;


    public function getCategoryAttribute($category)
    {
        if(self::$withoutAppends){
            return $category;
        }
        return explode(',',$category);
    }

    public static function Cost($id)
    {
        $product = Product::findOrFail($id);
        $fees = Settings::findOrFail(1);
        $finalcost = $product->price + (($fees->dynamic_commission / 100) * $product->price) + (($fees->tax / 100) * $product->price) + $fees->fixed_commission;
        return round($finalcost,2);
    }

    public static function Filter($price)
    {
        $fees = Settings::findOrFail(1);
        $finalcost = $price - (($fees->dynamic_commission / 100) * $price) - (($fees->tax / 100) * $price) - $fees->fixed_commission;
        return ceil($finalcost);
    }

}
