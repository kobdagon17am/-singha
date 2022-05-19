<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // หน้าแดชบอร์ด
    // ===================================================

    public function dashboard(){
        return view('backend/dashboard/dashboard');
    }
}
