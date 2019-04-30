<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['brand_id', 'image', 'description', 'price', 'name'];

    public function brand(){
        return $this->belongsTo('App\Brand');
    }

    public function categories(){
        return $this->belongsToMany('App\Category')->withPivot('category_id');;
    }
}
