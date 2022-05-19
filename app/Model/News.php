<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    // News
    protected $table = "news";
    protected $primaryKey = "news_id";

    public function gallery(){
        return $this->hasMany('App\Model\NewsGallery','news_id','news_id');
    }

}
