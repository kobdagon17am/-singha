<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Partners extends Model
{
    // Partners
    protected $table = "partners";
    protected $primaryKey = "partners_id";

    public function partnertype() {
        return $this->hasOne('App\Model\PartnersType','partners_type_id','partners_type');
    }
    public function prtnersproduct() {
        return $this->hasOne('App\Model\PartnersProduct','partners_id','partners_id');
    }
    public function booking() {
        return $this->hasMany('App\Model\Booking','partners_id','partners_id');
    }
    public function bookdetail() {
        return $this->hasMany('App\Model\Booking_Detail','partners_id','partners_id');
    }
}
