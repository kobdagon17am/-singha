<?php

namespace App\Http\Controllers\Market;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarketGeneralController extends Controller
{
    // ข้อมูลทั่วไป
    // ===================================================

    public function market_general(){
        return view('backend/market/market_general');
    }

    public function update(){

    }
    
}
