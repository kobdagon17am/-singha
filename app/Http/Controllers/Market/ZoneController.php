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
use App\Model\MK_Zone;

class ZoneController extends Controller
{
    //
    public function zone($id) {
        $market = MK_MarketName::find($id);
        $floor = MK_Floor::where('marketname_id',$id)->get();
        return view('backend/market/zone',['market'=>$market,'floor'=>$floor]);
    }

    public function datatable() {

        $marketID = request('marketID');
        $market_zone = MK_Zone::where('marketname_id',$marketID)->get();
        $sQuery	 = Datatables::of($market_zone)

        // ชื่อ Floor
        // ->editColumn('colum_floor',function($data){
        //     return $data->floor->name;
        // })

        // ชื่อ Zone
        ->editColumn('colum_zone',function($data){
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
            return '<button type="button" class="btn-dark model-data" data-id='.$data->zone_id.' data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-edit"></i> แก้ไข</button>&nbsp;
                    <button type="button" class="btn-dark" onclick="status('.$data->zone_id. ',' ."'$data->name'".  ')"><i class="fa fa-wrench"></i> ใช้งาน/ยกเลิก</button>
                    <button type="button" class="btn-dark" onclick="destroy('.$data->zone_id. ',' ."'$data->name'".  ')"><i class="fa fa-trash"></i> ลบข้อมูลบูธ</button>';
        });


        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request) {

        $path = "storage/uploadfile/boothdetail/";
        if(!empty($request->file('zone_image'))){
            $image  = $request->file('zone_image');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $new_imgs = date('dmYHis').'img.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save($path.$new_imgs);

            $oldpic = 'storage/uploadfile/boothdetail/'.$request->fileold;
            if(is_file($oldpic)){
                unlink($oldpic);
            }
        }else{
            $new_imgs = $request->fileold;
        }
            $url_image = asset('storage/uploadfile/boothdetail/'.$new_imgs);

        $zone = new MK_Zone;
        $zone->marketname_id = $request->marketname_id;
        $zone->floor_id = $request->floor;
        $zone->name = $request->zone;
        $zone->zone_image = $url_image;
        $zone->status = 'Y';
        $zone->save();

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function edit(Request $request) {
        $zone = MK_Zone::find($request->id);
        return Response::json($zone);
    }

    public function update(Request $request) {

        // dd($request);
        $path = "storage/uploadfile/boothdetail/";
        if(!empty($request->file('zone_image_e'))){
            $image  = $request->file('zone_image_e');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $new_imgs = date('dmYHis').'img.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save($path.$new_imgs);

            $oldpic = 'storage/uploadfile/boothdetail/'.$request->fileold;
            if(is_file($oldpic)){
                unlink($oldpic);
            }
        }else{
            $new_imgs = $request->fileold;
        }
        // dd($new_imgs);
        $url_image = asset('storage/uploadfile/boothdetail/'.$new_imgs);

        $zone = MK_Zone::find($request->id);
        $zone->floor_id = $request->floor;
        $zone->name = $request->zone;
        $zone->zone_image = $url_image;
        $zone->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function status(Request $request) {
        $zone = MK_Zone::find($request->id);
        // dd($partners);
        if($zone->status == "Y"){
            $zone->status = "N";
            $zone->save();
            $data['response'] = true;
            $data['title'] = "ยกเลิกใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }else{
            $zone->status = "Y";
            $zone->save();
            $data['response'] = true;
            $data['title'] = "เปิดใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }
        return Response::json($data);
    }


    public function delete(Request $request) {
        $zone = MK_Zone::destroy($request->id);
        // dd($zone);

        // $zone->status = "Y";
        // $zone->save();
        $data['response'] = true;
        $data['title'] = "เปิดใช้งานสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';

        return Response::json($data);
    }

}
