<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MK_Booth extends Model
{
    protected $table = "mk_booth";
    protected $primaryKey ="booth_id";

    public function market() {
        return $this->hasOne('App\Model\MK_MarketName','marketname_id','marketname_id');
    }

    public function floor() {
        return $this->hasOne('App\Model\MK_Floor','floor_id','floor_id');
    }

    public function zone() {
        return $this->hasOne('App\Model\MK_Zone','zone_id','zone_id');
    }

    public function boothtype() {
        return $this->hasOne('App\Model\MK_BoothType','booth_type_id','booth_type_id');
    }

    public function boothdetail() {
        return $this->hasMany('App\Model\MK_BoothDetail','booth_id','booth_id');
    }
}
