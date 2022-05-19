<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminRule extends Authenticatable
{
    use Notifiable;
    // protected $guard    = "admin"
    protected $table    = "admin_rule";
    // protected $fillable = ['name', 'email', 'username','password',];
    // protected $hidden   = ['password', 'remember_token',];

    public function market() {
        return $this->hasOne('App\Model\MK_MarketName','marketname_id','marketname_id');
    }

}
