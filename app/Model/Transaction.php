<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // แบนเนอร์
    protected $table = "transaction_master";
    protected $primaryKey = "trans_id";
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    public function partner() {
        return $this->hasOne('App\Model\Partners','partners_id','partners_id');
    }
    public function transction_detail() {
        return $this->hasMany('App\Model\Transaction_Detail','trans_id','trans_id');
    }
}
