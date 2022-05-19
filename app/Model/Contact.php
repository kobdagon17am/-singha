<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    // ผู้ติดต่อ
    protected $table = "contact";
    protected $primaryKey = "contact_id";
}
