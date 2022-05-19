<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MK_BoothDetail extends Model
{
    protected $table = "mk_booth_detail";
    protected $primaryKey = "booth_detail_id";

    public function booth() {
        return $this->hasOne('App\Model\MK_Booth','booth_id','booth_id');
    }
    public function bookingdetail() {
        return $this->hasMany('App\Model\Booking_Detail','booth_detail_id','booth_detail_id');
    }
    public function producttype() {
        return $this->hasOne('App\Model\ProductType','type_id','product_type');
    }

    public function productcategory() {
        return $this->hasOne('App\Model\ProductCategory','category_id','product_category');
    }
}
