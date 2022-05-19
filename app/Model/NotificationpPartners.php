<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class NotificationpPartners extends Model
{

    // notification
    protected $table = "notification_partners";
    protected $primaryKey = "notification_id";
    public $timestamps = false;


    public function user(){
        return $this->hasOne('App\Model\Admin', 'id', 'user_id');
    }
}
