<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Booking_Status extends Model
{
    // แบนเนอร์
    protected $table = "bookingstatus";
    protected $primaryKey = "booking_status_id";
    // public $incrementing = false;
    // protected $keyType = 'string';

    // public function market() {
    //     return $this->hasOne('App\Model\MK_MarketName','marketname_id','marketname_id');
    // }

}
