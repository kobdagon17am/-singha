<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MK_MarketName extends Model
{
    // รายชื่อตลาด
    protected $table = "mk_marketname";
    protected $primaryKey = "marketname_id";

    public function adminrule() {
        return $this->hasMany('App\Model\AdminRule','marketname_id','marketname_id');
    }

}
