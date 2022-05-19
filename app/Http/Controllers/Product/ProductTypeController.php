<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Default
use Session;
use Response;
use Auth;
use Yajra\Datatables\Datatables;

// Model
use App\Model\ProductType;
use App\Model\PartnersType;

class ProductTypeController extends Controller
{
    // ประเภทสินค้า
    // ===================================================

    public function product_type(){
        $partnerstype = PartnersType::all();
        $data = array(
            'partnerstype' => $partnerstype,
        );
        return view('backend/product/product_type',$data);
    }

    public function dadatable(){

        // Query Status
        $date_status = request('status_val');
        if($date_status == 'T'){
            $dataQuery = ProductType::all();
        }elseif($date_status == 'Y'){
            $dataQuery = ProductType::where('status','Y')->get();
        }elseif($date_status == 'N'){
            $dataQuery = ProductType::where('status','N')->get();
        }else{
            $dataQuery = ProductType::all();
        }
        $sQuery	 = Datatables::of($dataQuery)
        // ===================================================

        // ชื่อ
        ->editColumn('colum_name',function($data){
            return $data->name;
        })
 // ชื่อ
        ->editColumn('partners_type',function($data){

            if ($data->partners_type == "T") {
                $value = "ทั้งหมด";
            }else{
                $partnersType = PartnersType::find($data->partners_type);
                $value = $partnersType->name;
            }

            return $value;
        })
        // สถานะ
        ->editColumn('colum_status',function($data){
            if($data->status == "Y"){
                $status_t = '<font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>
                            <a href="#!" onclick="status('.$data->type_id. ',' ."'$data->name'".')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>';
            }else{
                $status_t = '<font color="red"><p title="ยกเลิก"><i class="fa fa-times-circle"></i> ยกเลิก</p></font>
                            <a href="#!" onclick="status('.$data->type_id. ',' ."'$data->name'".')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>';
            }
            return $status_t;
        })

        // จัดการ
        ->editColumn('colum_manage',function($data){
            return '<button type="button" class="btn-dark model-data" data-id='.$data->type_id.' data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-edit"></i> แก้ไข</button>';
        });

        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request){
        $dataQuery = new ProductType;
        $dataQuery->name = $request->name;
        $dataQuery->partners_type = $request->partners_type;
        $dataQuery->status = "Y";
        $dataQuery->save();

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return response()->json($data);

    }

    public function edit(Request $request){
        $dataQuery = ProductType::find($request->id);
        return response()->json($dataQuery);
    }

    public function update(Request $request){
        $dataQuery = ProductType::find($request->id);
        $dataQuery->name = $request->name;
        $dataQuery->partners_type = $request->partners_type;
        $dataQuery->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return response()->json($data);

    }

    public function status(Request $request){
        $dataQuery = ProductType::find($request->id);
        if($dataQuery->status == "Y"){
            $dataQuery->status = "N";
            $dataQuery->save();
            $data['response'] = true;
            $data['title'] = "ยกเลิกใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }else{
            $dataQuery->status = "Y";
            $dataQuery->save();
            $data['response'] = true;
            $data['title'] = "เปิดใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }
        return response()->json($data);
    }


}
