<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    // ประเภทสินค้า
    protected $table = "product_type";
    protected $primaryKey = "type_id";
}
