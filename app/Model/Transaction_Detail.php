<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction_Detail extends Model
{
    // แบนเนอร์
    protected $table = "transaction_details";
    protected $primaryKey = "trans_id";
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    public function transaction() {
        return $this->hasOne('App\Model\Transaction','trans_id','trans_id');
    }

    public function booking() {
        return $this->hasOne('App\Model\Booking','booking_id','booking_id');
    }

}
