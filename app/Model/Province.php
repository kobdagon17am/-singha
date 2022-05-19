<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    // โค้ดส่วนลด
    protected $table = "province";
    protected $primaryKey = "id";
    public $timestamps = false;
}
