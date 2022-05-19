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
use App\Model\MK_Pictures;

class PicturesController extends Controller
{
    // รูปภาพ/กิจกรรม
    // ===================================================

    public function pictures_event(){
        return view('backend/market/pictures_event');
    }

    public function datatable(){
        // Query Status
        $date_status = request('status_val');
        if($date_status == 'T'){
            $pictures = MK_Pictures::all();
        }elseif($date_status == 'Y'){
            $pictures = MK_Pictures::where('status','Y')->get();
        }elseif($date_status == 'N'){
            $pictures = MK_Pictures::where('status','N')->get();
        }else{
            $pictures = MK_Pictures::all();
        }
        $sQuery	 = Datatables::of($pictures)
        // ===================================================

        // สถานะ
        ->editColumn('colum_status',function($data){
            if($data->status == "Y"){
                $status_t = '<font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>
                            <a href="#!" onclick="status('.$data->pictures_id.')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>';
            }else{
                $status_t = '<font color="red"><p title="ยกเลิก"><i class="fa fa-times-circle"></i> ยกเลิก</p></font>
                            <a href="#!" onclick="status('.$data->pictures_id.')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>';
            }
            return $status_t;
        })

        // รูปภาพ
        ->editColumn('colum_image',function($data){
            if($data->image != null){
                $path_image = asset('storage/uploadfile/pictures/'.$data->image);
                $data_image = "<img src='".$path_image."' style='height:250px; width:500px;'>";
            }else{
                $path_image = asset('public/assets/backend/img/wait_img.png');
                $data_image = "<img src='".$path_image."' style='height:250px; width:500px;'>";
            }
            return $data_image;
        })

        // จัดการ
        ->editColumn('colum_manage',function($data){
            return '<button type="button" class="btn-dark model-data" data-id='.$data->pictures_id.' data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-edit"></i> แก้ไข</button>';
        });

        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request){

        $path = "storage/uploadfile/pictures/";
        if(!empty($request->file('fileimg_gallery'))){
            foreach ($request->file('fileimg_gallery') as $key => $media) {
                if(!empty($media)){
                    $type         = explode('.',$media->getClientOriginalName());
                    $size         = sizeof($type);
                    $new_img      = $media->getClientOriginalName();
                    $new_imgs   = date('dmYHis').$key.'imgs.'.$type[$size-1];
                    $image_resize = Image::make($media->getRealPath());
                    $image_resize->save($path.$new_imgs);

                    $pictures = New MK_Pictures;
                    $pictures->image  = $new_imgs;
                    $pictures->status = "Y";
                    $pictures->save();
                }
            }
        }

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function edit(Request $request){
        $pictures = MK_Pictures::find($request->id);
        return Response::json($pictures);
    }

    public function update(Request $request){
        // dd($request);
        $path = "storage/uploadfile/pictures/";
        if(!empty($request->file('fileimg_gallery'))){
            $image  = $request->file('fileimg_gallery');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $new_imgs = date('dmYHis').'img.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save($path.$new_imgs);

            $oldpic = 'storage/uploadfile/pictures/'.$request->fileold;
            if(is_file($oldpic)){
                unlink($oldpic);
            }
        }else{
            $new_imgs = $request->fileold;
        }

        $pictures = MK_Pictures::find($request->id);
        $pictures->image = $new_imgs;
        $pictures->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function status(Request $request){
        $pictures = MK_Pictures::find($request->id);
        if($pictures->status == "Y"){
            $pictures->status = "N";
            $pictures->save();
            $data['response'] = true;
            $data['title'] = "ยกเลิกใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }else{
            $pictures->status = "Y";
            $pictures->save();
            $data['response'] = true;
            $data['title'] = "เปิดใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }
        return Response::json($data);
    }
}
