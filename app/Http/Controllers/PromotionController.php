<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Default
use Response;
use Auth;
use Image;
use Yajra\Datatables\Datatables;

// Model
use App\Model\Promotion;

class PromotionController extends Controller
{
    //

    public function promotion(){
        return view('backend/promotion/promotion');
    }

    public function datatable(){

        // Query Status
        $date_status = request('status_val');
        if($date_status == 'T'){
            $promotion = Promotion::all();
        }elseif($date_status == 'Y'){
            $promotion = Promotion::where('status','Y')->get();
        }elseif($date_status == 'N'){
            $promotion = Promotion::where('status','N')->get();
        }elseif($date_status == 'W'){
            $promotion = Promotion::where('status','W')->get();
        }else{
            $promotion = Promotion::all();
        }
        $sQuery	 = Datatables::of($promotion)

        // รหัสโปรโมชั่น
        ->editColumn('colum_code',function($data){
            return $data->code;
        })

        // ชื่อโปรโมชั่น
        ->editColumn('colum_name',function($data){
            return $data->name;
        })

        // ราคาลด
        ->editColumn('colum_price',function($data){
            if($data->type_con == "1"){
                $type = "บาท";
            }else{
                $type = "%";
            }

            return $data->price." ".$type;
        })

        // วันที่เริ่ม
        ->editColumn('colum_date_start',function($data){
            return $data->date_start;
        })

        // วันที่สิ้นสุด
        ->editColumn('colum_date_end',function($data){
            return $data->date_end;
        })

        // สถานะ
        ->editColumn('colum_status',function($data){
            if($data->status == "W"){
                $status = '<font color="blue"><p title="ใช้งาน"><i class="fa fa-check-square-o"></i> รออนุมัติ</p></font>';
            }elseif($data->status == "Y"){
                $status = '<font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>';
            }elseif($data->status == "N"){
                $status = '<font color="red"><p title="ยกเลิก"><i class="fa fa-times-circle"></i> ยกเลิก</p></font>';
            }else{
                $status = "-";
            }
            return $status;
        })

        // จัดการ
        ->editColumn('colum_manage',function($data){

            if($data->status == "Y"){
                $event = '<a href="#!" class="dropdown-item waves-effect waves-light" onclick="data_cancel('.$data->promotion_id. ',' ."'$data->name'".')" ><i class="fa fa-times"></i>&nbsp;ยกเลิกใช้งาน</button></a>';
            }else{
                $event = '<a href="#!" class="dropdown-item waves-effect waves-light" onclick="data_confirm('.$data->promotion_id. ',' ."'$data->name'".')" ><i class="fa fa-check"></i>&nbsp;อนุมัติใช้งาน</button></a>'; 
            }

            return  '<div class="btn-group dropdown-split-inverse">
                        <button type="button" class="btn btn-inverse" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">จัดการ <i class="ti-angle-down"></i></button>
                        <div class="dropdown-menu"> 
                            <a href="#!" class="dropdown-item waves-effect waves-light model-data" data-id="'.$data->promotion_id.'" data-toggle="modal" data-target="#modal_edit"><i class="fa fa-edit"></i> แก้ไข</a>   
                            '.$event.'
                        </div>
                    </div>';
        });


        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request){
        $random = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        $randoms = substr(str_shuffle($random), 0, 7);
        $code_randoms = $randoms;

        $promotion = new Promotion;
        $promotion->code = 'PMT'.date('ydm').$code_randoms; // รหัสคูปอง // code
        $promotion->name = $request->name;
        $promotion->date_start = $request->date_start;
        $promotion->date_end = $request->date_end;
        $promotion->price = $request->price;
        $promotion->type_con = $request->type_con;
        $promotion->status = "W";
        $promotion->save();

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function edit(Request $request){
        $promotion = Promotion::find($request->id);
        return Response::json($promotion);
    }

    public function update(Request $request){
        $promotion = Promotion::find($request->id);
        $promotion->name = $request->name;
        $promotion->date_start = $request->date_start;
        $promotion->date_end = $request->date_end;
        $promotion->status = "W";
        $promotion->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function cancel(Request $request){
        $promotion = Promotion::find($request->id);
        $promotion->status = "N";
        $promotion->save(); 

        $data['response'] = true;
        $data['title'] = "ยกเลิกใช้งานสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function confirm(Request $request){
        $promotion = Promotion::find($request->id);
        $promotion->status = "Y";
        $promotion->save(); 

        $data['response'] = true;
        $data['title'] = "อนุมัติใช้งานสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }
}
