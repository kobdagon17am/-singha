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
use App\Model\MK_Booth;
use App\Model\MK_BoothDetail;
use App\Model\MK_BoothType;
use App\Model\MK_Zone;
use App\Model\ProductType;
use App\Model\ProductCategory;

use DB;

class BoothDetailControoler extends Controller
{
    // รายละเอียดบูธ
    public function boot_detail($id,$idz) {
        // dd($id,$idz);
        $market_zone = MK_Zone::find($id);
        $booth = MK_Booth::with('market')->where('booth_id',$id)->first();
        $booth_detail = DB::table('mk_booth_detail')->where('booth_id',$id)->where('zone_id',$idz)->orderBy('booth_detail_id','asc')->get();
        // dd($booth);
        $booth_id = MK_BoothDetail::where('booth_id',$id)->orderBy('booth_detail_id','asc')->first();
        $product_type = ProductType::all();
        $product_category = ProductCategory::all();
        return view('backend/market/booth_detail',
        [
            'id_booth'=>$id,
            'id_zone'=>$idz,
            'booth_id'=>$booth_id,
            'booth'=>$booth,
            'booth_detail'=>$booth_detail,
            'product_type'=>$product_type,
            'product_category'=>$product_category
        ]);
    }
    public function datatable(Request $request)
    {

        // dd($request->id_zone);
        $id_booth = $request->id_booth;
        $id_zone = $request->id_zone;
        $data =   MK_BoothDetail::where('booth_id',$id_booth)->where('zone_id',$id_zone)->get();
        // dd($data);

        return Datatables::of($data)->addIndexColumn()
        ->addColumn('status', function ($data) {


            $html = '';
            if ($data->status == "Y") {
                # code...
                $html =  '<font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>';
            }
            if ($data->status == "W") {
                # code...
                $html = '<font color="blue"><p title="ใช้งาน"><i class="fa fa-clock-o"></i> รออนุมัติ</p></font>';
            }
            if ($data->status == "N") {
                # code...
                $html = '<font color="red"><p title="ยกเลิก"><i class="fa fa-times-circle"></i> ยกเลิก</p></font>';
            }
             return $html;
        })
        // <button class="btn-dark" onclick="destroy('.$data->booking_id.')">ลบ</button>
        ->addColumn('manage', function ($data) {
            $data = '
            <button class="btn-dark model-data" data-id="'.$data->booth_detail_id.'" data-toggle="modal" data-target="#model_booth"><i class="fa fa-edit"> แก้ไขข้อมูล Booth</i></button>

            ';
             return $data;
        })
        ->rawColumns(['manage','status'])
        ->make(true);
    }
    public function add(Request $request) {
        // dd($request->all());
        $path = "storage/uploadfile/boothdetail/";
        if(!empty($request->file('booth_detail_image'))){
            $image  = $request->file('booth_detail_image');
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

        // if(!empty($request->amount_booth)) {
        //     for($i=1; $i <= $request->amount_booth; $i++) {
                $booth_detail = new MK_BoothDetail;
                $booth_detail->booth_id = $request->booth_id;
                $booth_detail->zone_id = $request->zone_id;
                $booth_detail->price = $request->price;
                $booth_detail->name =  $request->name;
                $booth_detail->product_type =  $request->product_type;
                $booth_detail->product_category = $request->product_categorys;
                $booth_detail->booth_detail_image_w = $new_imgs;
                $booth_detail->booth_detail_image = $url_image;
                $booth_detail->status = "Y";
                $booth_detail->save();
            // }
        // }

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);

    }

    public function edit(Request $request) {
        $booth_detail = MK_BoothDetail::find($request->id);
        return Response::json($booth_detail);
    }

    public function update(Request $request) {
        // dd($request);

        $path = "storage/uploadfile/boothdetail/";
        if(!empty($request->file('booth_detail_image'))){
            $image  = $request->file('booth_detail_image');
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
        // dd($url_image);
        $booth_detail = MK_BoothDetail::find($request->booth_detail_id);
        $booth_detail->name = $request->name;
        $booth_detail->price = $request->price;
        $booth_detail->product_type = $request->product_type;
        $booth_detail->product_category = $request->product_categorys;
        $booth_detail->status = $request->status;
        $booth_detail->booth_detail_image_w = $new_imgs;
        $booth_detail->booth_detail_image = $url_image;
        $booth_detail->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }
}
