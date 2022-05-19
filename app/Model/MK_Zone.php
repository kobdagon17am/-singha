<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MK_Zone extends Model
{
    //
    protected $table = "mk_zone";
    protected $primaryKey = "zone_id";

    public function floor(){
        return $this->hasOne('App\Model\MK_Floor','floor_id','floor_id');
    }
}
