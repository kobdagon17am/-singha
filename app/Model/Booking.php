<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    // แบนเนอร์
    protected $table = "booking";
    protected $primaryKey = "booking_id";
    public $incrementing = false;
    protected $keyType = 'string';

    public function bookdetail() {
        return $this->hasMany('App\Model\Booking_Detail','booking_id','booking_id');
    }

    public function boothdetail() {
        return $this->hasOne('App\Model\MK_BoothDetail','booth_detail_id','booth_detail_id');
    }

    public function market() {
        return $this->hasOne('App\Model\MK_MarketName','marketname_id','marketname_id');
    }

    public function partners() {
        return $this->hasOne('App\Model\Partners','partners_id','partners_id');
    }

    public function status() {
        return $this->hasOne('App\Model\Booking_Status','booking_status_id','booking_status_id');
    }


    public function transaction() {
        return $this->hasMany('App\Model\Transaction','booking_id','booking_id');
    }
}
