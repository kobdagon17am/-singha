<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PartnersProduct extends Model
{
    // Partners
    protected $table = "partners_product";
    protected $primaryKey = "partners_id";


    public function product() {
        return $this->hasOne('App\Model\Product','product_id','product_id');
    }

}
