<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    // โค้ดส่วนลด
    protected $table = "coupon";
    protected $primaryKey = "coupon_id";
}
