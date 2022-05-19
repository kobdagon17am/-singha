<?php

namespace App\Http\Controllers\Market;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Default
use Response;
use Auth;
use Image;
use Yajra\Datatables\Datatables;

// Model
use App\Model\MK_MarketName;
use App\Model\MK_Calender;

class CalendarHolidayController extends Controller
{

    // ปฏิทินวันหยุด
    public function calander_holiday($id) {

        $market = MK_MarketName::find($id);
        $calender = MK_Calender::where('marketname_id',$id)->where('status','Y')->get();

        $arrayData = array();
        foreach($calender as $calenders) {
            $data = array(
                'title'=> 'วันหยุด',
                'start' => $calenders->date_start,
                'end'=> $calenders->date_end,
                'constraint' => 'availableForMeeting',
                'editable' => false,
                'borderColor' => '#4680ff',
                'backgroundColor' => '#4680ff',
                'textColor' => '#fff'
            );
            array_push($arrayData,$data);
        }
        $myJSON = json_encode($arrayData);

        return view('backend/market/calander_holiday',['market'=>$market,'calender'=>$calender ,'myJSON' => $myJSON]);
    }
}
