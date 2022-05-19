<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Booking_Detail extends Model
{
    // แบนเนอร์
    protected $table = "booking_detail";
    protected $primaryKey = "booking_detail_id";
    // public $incrementing = false;
    // protected $keyType = 'string';
    public function bookingaccessories() {
        return $this->hasMany('App\Model\Booking_Accessories','booking_detail_id','booking_detail_id');
    }
    public function bookingdetail() {
        return $this->hasOne('App\Model\Booking','booking_id','booking_id');
    }
    public function booking() {
        return $this->hasOne('App\Model\Booking','booking_id','booking_id');
    }

    public function transactiondetail() {

        return $this->hasMany('App\Model\Transaction_Detail','booking_id','booking_id');
    }
    public function boothdetail() {
        return $this->hasOne('App\Model\MK_BoothDetail','booth_detail_id','booth_detail_id');
    }

    public function partners() {
        return $this->hasOne('App\Model\Partners','partners_id','partners_id');
    }

}
