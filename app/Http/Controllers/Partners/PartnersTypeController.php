<?php

namespace App\Http\Controllers\Partners;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Default
use Response;
use Auth;
use Image;
use Yajra\Datatables\Datatables;

// Model
use App\Model\PartnersType;


class PartnersTypeController extends Controller
{
    // จัดการผู้เช่า ประเภท
    // ===================================================

    public function partners_type(){
        return view('backend/partners/partners_type');
    }

    public function datatable(){
        // Query Status
        $date_status = request('status_val');
        if($date_status == 'T'){
            $partnerstype = PartnersType::all();
        }elseif($date_status == 'Y'){
            $partnerstype = PartnersType::where('status','Y')->get();
        }elseif($date_status == 'N'){
            $partnerstype = PartnersType::where('status','N')->get();
        }else{
            $partnerstype = PartnersType::all();
        }
        $sQuery	 = Datatables::of($partnerstype)
        // ===================================================

        // ชื่อ
        ->editColumn('colum_name',function($data){
            return $data->name;
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
            return '<button type="button" class="btn-dark model-data" data-id='.$data->partners_type_id.' data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-edit"></i> แก้ไข</button>';
        });

        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request){
        $partnerstype = new PartnersType;
        $partnerstype->name = $request->name;
        $partnerstype->status = "Y";
        $partnerstype->save();

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return response()->json($data);
    }

    public function edit(Request $request){
        $partnerstype = PartnersType::find($request->id);
        return response()->json($partnerstype);
    }

    public function update(Request $request){
        $partnerstype = PartnersType::find($request->id);
        $partnerstype->name = $request->name;
        $partnerstype->status = $request->status;
        $partnerstype->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return response()->json($data);
    }
 
}
