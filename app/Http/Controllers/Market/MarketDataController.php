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
use App\Model\MK_MarketData;

class MarketDataController extends Controller
{
    // ข้อมูลตลาด
    // ===================================================

    public function market_data(){
        return view('backend/market/market_data');
    }

    public function datatable(){
        // Query Status
        $date_status = request('status_val');
        if($date_status == 'T'){
            $marketdata = MK_MarketData::all();
        }elseif($date_status == 'Y'){
            $marketdata = MK_MarketData::where('status','Y')->get();
        }elseif($date_status == 'N'){
            $marketdata = MK_MarketData::where('status','N')->get();
        }else{
            $marketdata = MK_MarketData::all();
        }
        $sQuery	 = Datatables::of($marketdata)
        // ===================================================
  
        // ชื่อตึก
        ->editColumn('colum_building',function($data){
            return $data->building;
        })

        // ชื่อตลาด
        ->editColumn('colum_name_market',function($data){
            return $data->name_market;
        })

        // สถานะ
        ->editColumn('colum_status',function($data){
            if($data->status == "Y"){
                $status_t = '<font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>';
            }else{
                $status_t = '<font color="red"><p title="ยกเลิก"><i class="fa fa-times-circle"></i> ยกเลิก</p></font>';
            }
            return $status_t;
        })

        // จัดการ
        ->editColumn('colum_manage',function($data){
            return '<button type="button" class="btn-primary model-data" data-id='.$data->marketdata_id.' data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-edit"></i> แก้ไข</button>&nbsp;
            <button type="button" class="btn-danger" onclick="status('.$data->marketdata_id. ',' ."'$data->name_market'".  ')"><i class="fa fa-wrench"></i> ใช้งาน/ยกเลิก</button>';
        });

        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request){
        $marketdata = new MK_MarketData;
        $marketdata->building = $request->building;
        $marketdata->name_market = $request->name_market;
        $marketdata->status = "Y";
        $marketdata->save();

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }
    
    public function edit(Request $request){
        $marketdata = MK_MarketData::find($request->id);
        return Response::json($marketdata);
    }

    public function update(Request $request){
        $marketdata = MK_MarketData::find($request->id);
        $marketdata->building = $request->building;
        $marketdata->name_market = $request->name_market;
        $marketdata->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);

    }

    public function status(Request $request){
        $marketdata = MK_MarketData::find($request->id);
        if($marketdata->status == "Y"){
            $marketdata->status = "N";
            $marketdata->save(); 
            $data['response'] = true;
            $data['title'] = "ยกเลิกใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }else{
            $marketdata->status = "Y";
            $marketdata->save(); 
            $data['response'] = true;
            $data['title'] = "เปิดใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว'; 
        }
        return Response::json($data);
    }
}
