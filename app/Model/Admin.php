<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $guard    = "admin";
    protected $table    = "admin";
    protected $fillable = ['name', 'email', 'username','password',];
    protected $hidden   = ['password', 'remember_token',];

    public function adminrule() {
        return $this->hasMany('App\Model\AdminRule','admin_id','id');
    }

}
