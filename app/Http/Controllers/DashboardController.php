<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    // หน้าแดชบอร์ด
    // ===================================================

    public function dashboard(){
    //     $from = date('2022-11-01');
    //     $to = date('2022-11-31');

    //     $booking = DB::table('booking') //อัพ Pv ของตัวเอง
    //     ->select('booking.*')
    //     ->leftJoin('booking_detail','booking_detail.booking_id', '=','booking.booking_id')
    //     ->whereBetween('booking_detail.booking_detail_date',[$from,$to])
    //     ->where('marketname_id','=',2)
    //     // ->where('booking_type','=','Regular')
    //     ->get();


    //     // dd($booking);
    //     $i = 0;
    //     foreach($booking as $value){
    //         $deleted = DB::table('booking')->where('booking_id', '=', $value->booking_id)->delete();
    //         $deleted2 = DB::table('booking_detail')->where('booking_id', '=', $value->booking_id)->delete();
    //         $i++;
    //     }
    //     dd('success'.$i);
        return view('backend/dashboard/dashboard');
    }
}
