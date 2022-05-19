<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    // หมวดหมู่สินค้า
    protected $table = "product_category";
    protected $primaryKey = "category_id";

    public function type()
    {
        return $this->hasOne('App\Model\ProductType', 'type_id','type_id');
    }
}
