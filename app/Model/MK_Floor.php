<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MK_Floor extends Model
{
    protected $table = "mk_floor";
    protected $primaryKey = "floor_id";

    public function zone(){
        return $this->hasMany('App\Model\MK_Zone','floor_id','floor_id');
    }

    public function market(){
        return $this->hasOne('App\Model\MK_MarketName','marketname_id','marketname_id');
    }
}
