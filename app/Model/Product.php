<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // สินค้า
    protected $table = "product";
    protected $primaryKey = "product_id";

    public function type(){
        return $this->hasOne('App\Model\ProductType', 'type_id','type_id');
    }

    public function category(){
        return $this->hasOne('App\Model\ProductCategory', 'category_id','category_id');
    }
}
