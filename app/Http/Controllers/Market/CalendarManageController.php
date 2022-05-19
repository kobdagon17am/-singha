<?php

namespace App\Http\Controllers\Market;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Default
use Response;
use Auth;
use Image;
use Yajra\Datatables\Datatables;
use DB;

// Model
use App\Model\MK_MarketName;
use App\Model\MK_Calender;

class CalendarManageController extends Controller
{
    // จัดการวันหยุด
    public function calendar_manage($id) {
        $market = MK_MarketName::find($id);
        $year = MK_Calender::whereYear('created_at','!=',date('Y'))->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y')"))->get();
        // dd($year);
        $data = ['market'=>$market,'year'=>$year];
        return view('backend/market/calendar_manage',$data);
    }

    public function datatable(Request $request) {
        // dd( $request);
        $marketID = request('marketID');

        $market_calendar = MK_Calender::where('marketname_id',$marketID)->orderBy('date_start', 'ASC');
        if ($request->month_serach != null) {
            $date_start = $request->month_serach;
            $market_calendar = MK_Calender::where('marketname_id',$marketID)
            // ->whereMonth('date_start',date("n", strtotime($date_start)))
            ->whereYear('date_start',$date_start)->orderBy('date_start', 'ASC');
        }
        $sQuery	 = Datatables::of($market_calendar)

        // วันเริ่มต้น
        ->editColumn('colum_date_startr',function($data){
            return DateThai($data->date_start);
        })

        // 	ถึงวันที่
        ->editColumn('colum_date_end',function($data){
            return DateThai($data->date_end);
        })

        // สถานะ
        ->editColumn('colum_status',function($data){
            if($data->status == "Y"){
                $status_t = '<font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>';
            }else{
                $status_t = '<font color="red"><p title="ปิดใช้งาน"><i class="fa fa-times-circle"></i> ปิดใช้งาน</p></font>';
            }
            return $status_t;
        })

        // จัดการ
        ->editColumn('colum_manage',function($data){
            return '<button type="button" class="btn-dark model-data" data-id='.$data->calendar_id.' data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-edit"></i> แก้ไข</button>&nbsp;
                    <button type="button" class="btn-dark" onclick="deletedata('.$data->calendar_id.')"><i class="fa fa-trash-o"></i> ลบ</button>';



        });


        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request) {
        if($request->date_start){
            $start = $request->date_start.' 00:00:00';
        }

        if($request->date_end){
            $end = $request->date_end.' 23:59:59';
        }
        $calender = new MK_Calender;
        $calender->marketname_id = $request->marketname_id;
        $calender->date_start = $start;
        $calender->date_end = $end;
        $calender->status = "Y";
        $calender->save();

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function edit(Request $request) {
        $calender = MK_Calender::find($request->id);
        return Response::json($calender);
    }

    public function update(Request $request) {

        if($request->date_start){
            $start = $request->date_start.' 00:00:00';
        }

        if($request->date_end){
            $end = $request->date_end.' 23:59:59';
        }

        $calender = MK_Calender::find($request->id);
        $calender->date_start = $start;
        $calender->date_end = $end;
        $calender->status = $request->status;
        $calender->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function delete(Request $request) {
        $calender = MK_Calender::Find($request->id);
        $calender->delete();

        $data['response'] = true;
        $data['title'] = "ลบข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }
}
