<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Notification extends Model
{

    // notification
    protected $table = "notification";
    protected $primaryKey = "notification_id";


    public function user(){
        return $this->hasOne('App\Model\Admin', 'id', 'user_id');
    }
}
