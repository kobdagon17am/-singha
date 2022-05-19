<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CouponSend extends Model
{
    protected $table = "coupon_send";
    protected $primaryKey = "coupon_send_id";

    public function partners(){
        return $this->hasOne('App\Model\Partners', 'partners_id', 'partners_id');
    }

    public function coupon(){
        return $this->hasOne('App\Model\Coupon', 'coupon_id', 'coupon_id');
    }
}
