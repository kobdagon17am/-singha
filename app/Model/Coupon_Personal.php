<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Coupon_Personal extends Model
{
    // โค้ดส่วนลด
    protected $table = "coupon_personal_right";
    protected $primaryKey = "coupon_id";

    public function partners(){
        return $this->hasOne('App\Model\Partners', 'partners_id', 'partners_id');
    }
}
