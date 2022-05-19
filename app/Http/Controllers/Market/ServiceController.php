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
use App\Model\MK_Service;


class ServiceController extends Controller
{
    // บริการเสริม
    // ===================================================

    public function addservice(){
        return view('backend/market/addservice');
    }

    public function datatable(){
        // Query Status
        $date_status = request('status_val');
        if($date_status == 'T'){
            $service = MK_Service::all();
        }elseif($date_status == 'Y'){
            $service = MK_Service::where('status','Y')->get();
        }elseif($date_status == 'N'){
            $service = MK_Service::where('status','N')->get();
        }else{
            $service = MK_Service::all();
        }
        $sQuery	 = Datatables::of($service)
        // ===================================================

        // ชื่อสินค้า
        ->editColumn('colum_name',function($data){
            return $data->name;
        })

        // ราคา
        ->editColumn('colum_price',function($data){
            return $data->price;
        })

        // จำนวน
        ->editColumn('colum_amount',function($data){
            return $data->amount;
        })

        // วัน/เวลา ทำการ
        ->editColumn('colum_created_at',function($data){
            return $data->created_at;
        })

        // สถานะ
        ->editColumn('colum_status',function($data){
            if($data->status == "Y"){
                $status_t = '<font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>
                            <a href="#!" onclick="status('.$data->service_id. ','."'$data->name'".')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>';
            }else{
                $status_t = '<font color="red"><p title="ยกเลิก"><i class="fa fa-times-circle"></i> ยกเลิก</p></font>
                            <a href="#!" onclick="status('.$data->service_id. ','."'$data->name'".')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>';
            }
            return $status_t;
        })

        // รูปภาพ
        ->editColumn('colum_image',function($data){
            if($data->image != null){
                $path_image = asset('storage/uploadfile/service/'.$data->image);
                $data_image = "<img src='".$path_image."' style='height:100px; width:100px;'>";
            }else{
                $path_image = asset('public/assets/backend/img/wait_img.png');
                $data_image = "<img src='".$path_image."' style='height:100px; width:100px;'>";
            }
            return $data_image;
        })

        // จัดการ
        ->editColumn('colum_manage',function($data){
            return '<button type="button" class="btn-dark model-data" data-id='.$data->service_id.' data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-edit"></i> แก้ไข</button>';
        });

        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request){
        $path = "storage/uploadfile/service/";
        if(!empty($request->file('image_file'))){
            $image  = $request->file('image_file');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $new_imgs = date('dmYHis').'img.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save($path.$new_imgs);
        }else{
            $new_imgs = null;
        }

        $service = new MK_Service;
        $service->service = $request->service;
        $service->name = $request->name;
        $service->amount = $request->amount;
        $service->price = $request->price;
        $service->vat = $request->vat;
        $service->image = $new_imgs;
        $service->status = "Y";
        $service->service_space_id =  $request->space_id_service;
        $service->save();

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);

    }

    public function edit(Request $request){
        $service = MK_Service::find($request->id);
        return Response::json($service);
    }

    public function update(Request $request){
        $path = "storage/uploadfile/service/";
        if(!empty($request->file('image_file'))){
            $image  = $request->file('image_file');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $new_imgs = date('dmYHis').'img.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save($path.$new_imgs);

            $oldpic = 'storage/uploadfile/service/'.$request->fileold;
            if(is_file($oldpic)){
                unlink($oldpic);
            }
        }else{
            $new_imgs = $request->fileold;
        }

        $service = MK_Service::find($request->id);
        $service->service = $request->service;
        $service->name = $request->name;
        $service->amount = $request->amount;
        $service->price = $request->price;
        $service->vat = $request->vat;
        $service->image = $new_imgs;
        $service->service_space_id =  $request->space_id_service;
        $service->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);

    }

    public function status(Request $request){
        $service = MK_Service::find($request->id);
        if($service->status == "Y"){
            $service->status = "N";
            $service->save();
            $data['response'] = true;
            $data['title'] = "ยกเลิกใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }else{
            $service->status = "Y";
            $service->save();
            $data['response'] = true;
            $data['title'] = "เปิดใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }
        return Response::json($data);
    }
}
