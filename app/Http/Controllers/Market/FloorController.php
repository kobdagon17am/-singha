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
use App\Model\MK_Floor;


class FloorController extends Controller
{
    // Market Floor
    public function floor($id) {
        $market = MK_MarketName::find($id);
        return view('backend/market/floor',['market'=>$market]);
    }

    public function datatable() {

        $marketID = request('marketID');
        $market_floor = MK_Floor::where('marketname_id',$marketID)->get();
        $sQuery	 = Datatables::of($market_floor)


        // ชื่อ Floor
        ->editColumn('colum_name',function($data){
            return $data->name;
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
            return '<button type="button" class="btn-dark model-data" data-id='.$data->floor_id.' data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-edit"></i> แก้ไข</button>&nbsp;
                    <button type="button" class="btn-dark" onclick="status('.$data->floor_id. ',' ."'$data->name'".  ')"><i class="fa fa-wrench"></i> ใช้งาน/ยกเลิก</button>';
        });


        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request) {
        $floor = new MK_Floor;
        $floor->marketname_id = $request->marketname_id;
        $floor->name = $request->name;
        $floor->status = 'Y';
        $floor->save();

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function edit(Request $request) {
        $floor = MK_Floor::find($request->id);
        return Response::json($floor);
    }

    public function update(Request $request) {
        $floor = MK_Floor::find($request->id);
        $floor->name = $request->name;
        $floor->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function status(Request $request){
        $floor = MK_Floor::find($request->id);
        if($floor->status == "Y"){
            $floor->status = "N";
            $floor->save(); 
            $data['response'] = true;
            $data['title'] = "ยกเลิกใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }else{
            $floor->status = "Y";
            $floor->save(); 
            $data['response'] = true;
            $data['title'] = "เปิดใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว'; 
        }
        return Response::json($data);
    }
    
}
