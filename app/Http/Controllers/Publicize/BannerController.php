<?php

namespace App\Http\Controllers\Publicize;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Default
use Session;
use Response;
use Auth;
use Image;
use Yajra\Datatables\Datatables;

use App\Model\Banner;

class BannerController extends Controller
{
    // แบนเนอร์
    // ===================================================

    public function banner(){
        return view('backend/publicize/banner');
    }

    public function datatable(){

        // Query Status
        $date_status = request('status_val');
        if($date_status == 'T'){
            $banner = Banner::all();
        }elseif($date_status == 'Y'){
            $banner = Banner::where('status','Y')->get();
        }elseif($date_status == 'N'){
            $banner = Banner::where('status','N')->get();
        }else{
            $banner = Banner::all();
        }
        $sQuery	 = Datatables::of($banner)
        // ===================================================


        // รูปภาพ
        ->editColumn('colum_image',function($data){
            if($data->image != null){
                $path_image = asset('storage/uploadfile/banner/'.$data->image);
                $data_image = "<img src='".$path_image."' style='height:250px; width:455px;'>";
            }else{
                $path_image = asset('public/assets/backend/img/wait_img.png');
                $data_image = "<img src='".$path_image."' style='height:250px; width:450px;'>";
            }
            return $data_image;
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
            return '<button type="button" class="btn-dark model-data" data-id='.$data->banner_id.' data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-edit"></i> แก้ไข</button>&nbsp;
                    <button type="button" class="btn-dark" onclick="status('.$data->banner_id.')"><i class="fa fa-wrench"></i> ใช้งาน/ยกเลิก</button>
                    <button type="button" class="btn-dark" onclick="datadelete('.$data->banner_id.')"><i class="fa fa-trash-o"></i> ลบ</button>';
        });

        return $sQuery->escapeColumns([])->make(true);

    }

    public function add(Request $request){
        $path = "storage/uploadfile/banner/";
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

        $banner = new Banner;
        $banner->image  = $new_imgs;
        $banner->status = "Y";
        $banner->save();

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function edit(Request $request){
        $banner = Banner::find($request->id);
        return Response::json($banner);
    }

    public function update(Request $request){
        $path = "storage/uploadfile/banner/";
        if(!empty($request->file('image_file'))){
            $image  = $request->file('image_file');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $new_imgs = date('dmYHis').'img.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());     
            $image_resize->save($path.$new_imgs);	

            $oldpic = 'storage/uploadfile/banner/'.$request->fileold;
            if(is_file($oldpic)){
                unlink($oldpic);					
            }
        }else{
            $new_imgs = $request->fileold;
        }

        $banner = Banner::find($request->id);
        $banner->image  = $new_imgs;
        $banner->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function status(Request $request){
        $banner = Banner::find($request->id);
        if($banner->status == "Y"){
            $banner->status = "N";
            $banner->save(); 
            $data['response'] = true;
            $data['title'] = "ยกเลิกใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }else{
            $banner->status = "Y";
            $banner->save(); 
            $data['response'] = true;
            $data['title'] = "เปิดใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว'; 
        }
        return Response::json($data);
    }

    public function delete(Request $request){
        $banner = Banner::find($request->id);
        $oldpic = 'storage/uploadfile/banner/'.$banner->image;
        if(is_file($oldpic)){
            unlink($oldpic);					
        }
        $banner->delete();

        $data['response'] = true;
        $data['title'] = "ลบข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }
}
