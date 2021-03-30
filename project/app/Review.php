<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['productid', 'name', 'email', 'review', 'rating', 'review_date','status'];
    public $timestamps = false;

    public static function reviewCount($productid){
        $total = Review::where('productid',$productid)->where('status',1)->count();
        return $total;
    }

    public static function ratings($productid){
        $stars = Review::where('productid',$productid)->where('status',1)->avg('rating');
        $ratings = number_format((float)$stars, 1, '.', '')*20;
        return $ratings;
    }

    public static function totalratings($productid){
        $stars = Review::where('productid',$productid)->where('status',1)->avg('rating');
        $ratings = number_format((float)$stars, 1, '.', '');
        return $ratings;
    }

    public static function reviewByratings($productid,$rating){
        $stars = Review::where('productid',$productid)->where('rating',$rating)->where('status',1)->avg('rating');
        $ratings = number_format((float)$stars, 1, '.', '')*20;
        return $ratings;
    }

    public static function reviewCountByratings($productid,$rating){
        $total = Review::where('productid',$productid)->where('rating',$rating)->where('status',1)->count();
        return $total;
    }
}
