<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Booking_Accessories extends Model
{
    // แบนเนอร์
    protected $table = "booking_accessories";
    protected $primaryKey = "booking_accessories_id";
    // public $incrementing = false;
    // protected $keyType = 'string';
    public function service() {
        return $this->hasOne('App\Model\MK_Service','service_id','service_id');
    }
    public function bookingdetail() {
        return $this->hasOne('App\Model\Booking_Detail','booking_id','booking_detail_id');
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
