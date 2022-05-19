<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Officers extends Model
{
    // Officer
    protected $table = "tbusersystem";
    protected $primaryKey = "userid";
    public $timestamps = false;
}
