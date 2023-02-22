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



class MarketNameController extends Controller
{
    // รายชื่อตลาด
    // ===================================================
    public function markat_name(){
        return view('backend/market/markat');
    }

    public function market_create(){
        return view('backend/market/markat_create');
    }

    public function market_edit($id){
        $market = MK_MarketName::find($id);
        return view('backend/market/markat_edit',['market'=>$market]);
    }

    public function datatable(){
        $adminrule = Auth::user()->adminrule;
        foreach ($adminrule as $key => $value) {
           $arr[] = $value->marketname_id;
        }
        // dd($arr);


        $marketname =   MK_MarketName::whereIn('marketname_id',$arr)->orderBy('name_market', 'ASC')->get();

        $sQuery	 = Datatables::of($marketname)

        // ชื่อตลาด
        ->editColumn('colum_name',function($data){
            return $data->name_market;
        })

        // เวลา
        ->editColumn('colum_time',function($data){
            return $data->time;
        })

        // สถานะ
        ->editColumn('colum_status',function($data){
            if($data->status == "Y"){
                $status_t = '<font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>
                             <a href="#!" onclick="status('.$data->marketname_id. ',' ."'$data->name_market'".')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>';
            }else{
                $status_t = '<font color="red"><p title="ยกเลิก"><i class="fa fa-times-circle"></i> ยกเลิก</p></font>
                <a href="#!" onclick="status('.$data->marketname_id. ',' ."'$data->name_market'".')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>';
            }
            return $status_t;
        })

        // จัดการ
        // <a href="'.route("backend.market.floor" , array("id"=>$data->marketname_id)).'" class="dropdown-item waves-effect waves-light model-data"><i class="fa fa-sitemap"></i> Floor</a>
        ->editColumn('colum_manage',function($data){
            return  '<div class="btn-group dropdown-split-inverse">
                        <button type="button" class="btn btn-inverse" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">จัดการ <i class="ti-angle-down"></i></button>
                        <div class="dropdown-menu">
                            <a href="'.route("backend.market.name.edit" , array("id"=>$data->marketname_id)).'" class="dropdown-item waves-effect waves-light model-data"><i class="fa fa-edit"></i> แก้ไขโปรไฟล์</a>

                            <a href="'.route("backend.market.zone" , array("id"=>$data->marketname_id)).'" class="dropdown-item waves-effect waves-light model-data"><i class="fa fa-buysellads"></i> Zone</a>
                            <a href="'.route("backend.market.booth" , array("id"=>$data->marketname_id)).'" class="dropdown-item waves-effect waves-light model-data"><i class="fa fa-cube"></i> Booth</a>
                            <a href="'.route("backend.market.calendar.manage" , array("id"=>$data->marketname_id)).'" class="dropdown-item waves-effect waves-light model-data"><i class="fa fa-calendar-minus-o"></i> วันหยุด</a>
                            <a href="'.route("backend.market.calendar.holiday" , array("id"=>$data->marketname_id)).'" class="dropdown-item waves-effect waves-light model-data"><i class="fa fa-calendar"></i> ปฏิทินวันหยุด</a>
                        </div>
                    </div>';
        });

        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request){
        // รูปภาพโปรไฟล์ตลาด
        $path = "storage/uploadfile/market/";
        if(!empty($request->file('fileimg_pro'))){
            $image  = $request->file('fileimg_pro');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $img_profile = date('dmYHis').'profile.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save($path.$img_profile);
        }else{
            $img_profile = null;
        }

        // รูปภาพแผนผัง
        $path = "storage/uploadfile/market/";
        if(!empty($request->file('fileimg_dia'))){
            $image  = $request->file('fileimg_dia');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $ima_dia = date('dmYHis').'diagram.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save($path.$ima_dia);
        }else{
            $ima_dia = null;
        }

        $market = new MK_MarketName;
        $market->company_name = $request->company_name;
        $market->image_profile = $img_profile;
        $market->image_diagram = $ima_dia;
        $market->name_market = $request->name_market;
        $market->address_marker = $request->address_marker;
        $market->time = $request->time;
        $market->phone = $request->phone;
        $market->line = $request->line;
        $market->email = $request->email;
        $market->agreement = $request->detail_editer;
        $market->status = "Y";
        $market->prefix_code = "PZE";
        $market->privacy_url = "https://www.singhaestate.co.th/th/ประกาศความเป็นส่วนตัว";
        $market->save();
        // dd($market);

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function edit(Request $request){
        $marketname = MK_MarketName::find($request->id);
        return Response::json($marketname);
    }

    public function update(Request $request){
        // รูปภาพโปรไฟล์ตลาด
        $path = "storage/uploadfile/market/";
        if(!empty($request->file('fileimg_pro'))){
            $image  = $request->file('fileimg_pro');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $img_profile = date('dmYHis').'img.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save($path.$img_profile);

            $oldpic = 'storage/uploadfile/market/'.$request->image_profile;
            if(is_file($oldpic)){
                unlink($oldpic);
            }
        }else{
            $img_profile = $request->image_profile;
        }

        // รูปภาพแผนผัง
        $path = "storage/uploadfile/market/";
        if(!empty($request->file('fileimg_dia'))){
            $image  = $request->file('fileimg_dia');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $ima_dia = date('dmYHis').'img.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save($path.$ima_dia);

            $oldpic = 'storage/uploadfile/market/'.$request->image_dia;
            if(is_file($oldpic)){
                unlink($oldpic);
            }
        }else{
            $ima_dia = $request->image_dia;
        }

        $market = MK_MarketName::find($request->id);
        $market->company_name = $request->company_name;
        $market->image_profile = $img_profile;
        $market->image_diagram = $ima_dia;
        $market->name_market = $request->name_market;
        $market->address_marker = $request->address_marker;
        $market->time = $request->time;
        $market->phone = $request->phone;
        $market->line = $request->line;
        $market->email = $request->email;
        $market->agreement = $request->detail_editer;
        $market->save();


        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function status(Request $request){
        $marketname = MK_MarketName::find($request->id);
        if($marketname->status == "Y"){
            $marketname->status = "N";
            $marketname->save();
            $data['response'] = true;
            $data['title'] = "ยกเลิกใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }else{
            $marketname->status = "Y";
            $marketname->save();
            $data['response'] = true;
            $data['title'] = "เปิดใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }
        return Response::json($data);
    }

    public function editer(Request $request){
        $path = "storage/uploadfile/market_editer/";
        $newname = '';
        if($_FILES['image']['name'] != ''){
            $newname = '';
            $cuttype = explode('.',$_FILES['image']['name']);
            $siezetype = sizeof($cuttype);
            $namenew = date('dmYHis').'edt.'.$cuttype[$siezetype-1];
            copy($_FILES['image']['tmp_name'],$path.$namenew);
        }
        $img = asset('storage/uploadfile/market_editer/'.$namenew);
        return response()->json($img);
    }
}
