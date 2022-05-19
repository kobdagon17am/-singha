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
use App\Model\Partners;
use App\Model\PartnersType;
use App\Model\PartnersProduct;
use App\Model\ProductType;
use App\Model\ProductCategory;
use App\Model\Product;
use App\Model\District;
use App\Model\Province;
use App\Model\Subdistrict;

class PartnersApproveController extends Controller
{
    // จัดการผู้เช่า รออนุมัติ
    // ===================================================

    public function partners_approve(){

        $partnerstype = PartnersType::all();
        $district = District::all();
        $province = Province::all();
        $subdistrict = Subdistrict::all();

        $data = array(
            'partnerstype' => $partnerstype,
            'district' => $district,
            'province' => $province,
            'subdistrict' => $subdistrict,
        );


        return view('backend/partners/partners_approve',$data);
    }

    public function datatable(){
        // Query Status
        $partners = Partners::where('status','W')->get();
        $sQuery	 = Datatables::of($partners)
        // ===================================================

        // ชื่อลูกค้า
        ->editColumn('colum_name_customer',function($data){
            return $data->name_customer;
        })
        // ชื่อจริง
        ->editColumn('colum_name',function($data){
            return $data->name;
        })
        // นามสกุล
        ->editColumn('colum_lastname',function($data){
            return $data->lastname;
        })
        // เบอร์โทร
        ->editColumn('colum_phone',function($data){
            return $data->phone;
        })

        // สถานะ
        ->editColumn('colum_status',function($data){
            if($data->status == "W"){
                $status_t = '<font color="blue"><p title="รออนุมัติ"><i class="fa fa-exclamation-circle"></i> รออนุมัติ</p></font>';
            }
            return $status_t;
        })

        // จัดการ
        ->editColumn('colum_manage',function($data){
            return '<button type="button" class="btn-dark model-data" data-id='.$data->partners_id.' data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-search"></i> ดูข้อมูล</button>&nbsp;
                    <button type="button" class="btn-dark" onclick="approve('.$data->partners_id. ',' ."'$data->name_customer'".  ')"><i class="fa fa-check-square"></i> อนุมัติใช้งาน</button>
                    <button type="button" class="btn-dark" onclick="datadelete('.$data->partners_id.')"><i class="fa fa-trash-o"></i> ลบ</button>';
        });

        return $sQuery->escapeColumns([])->make(true);
    }

    public function view(Request $request){
        $partners = Partners::find($request->id);
        $countpartnersproduct = PartnersProduct::where('partners_id',$partners->partners_id)->count();
        $htmlproduct_type = $this->htmlproduct_type($partners->partners_id);
        $data = array(
            'partners' => $partners,
            'countpartnersproduct' => $countpartnersproduct,
            // 'product' => $product,
            'htmlproduct_type' => $htmlproduct_type,

        );

        return Response::json($data);
    }

    public function status(Request $request){
        $partners = Partners::find($request->id);
        $partners->status = "Y";
        $partners->save();

        $data['response'] = true;
        $data['title'] = "อนุมัติผู้เช่าใช้งานเสร็จ";
        $data['text'] = 'ระบบได้อนุมัติผู้เช่าเรียบร้อยแล้ว';
        return response()->json($data);
    }

    public function delete(Request $request){
        $partners = Partners::find($request->id);
        $img_cz = 'storage/uploadfile/partners/'.$partners->image_citizen;
        $img_kp = 'storage/uploadfile/partners/'.$partners->image_kp20;
        if(is_file($img_cz)){
            unlink($img_cz);
        }
        if(is_file($img_kp)){
            unlink($img_kp);
        }
        $partners->delete();

        $data['response'] = true;
        $data['title'] = "ลบข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้ลบข้อมูลเรียบร้อยแล้ว';
        return response()->json($data);
    }
    public function htmlproduct_type($partners_id){
        // dd($request->all());
        $partnersproducts = PartnersProduct::where('partners_id',$partners_id)->get();

        $htmlproduct_type = '';
        foreach ($partnersproducts as $key => $value) {
            # code...

        $htmlproduct_type .= '
        <div class="form-group row" >
        <label class="col-sm-4 col-form-label text-right">ประเภทสินค้า:</label>
        <div class="col-sm-2">
            <input type="text" class="form-control" name="" id="" placeholder="'.$value->product->type->name.'"  autocomplete="off" readonly>

        </div>
        <label class="col-form-label">หมวดหมู่สินค้า:</label>
        <div class="col-sm-2">
            <input type="text" class="form-control" name="" id="" placeholder="'.$value->product->category->name.'"  autocomplete="off" readonly>
        </div>

        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label text-right">สินค้าที่เลือก:</label>
        <div class="col-sm-2">
            <input type="text" class="form-control" name="lineid" id="lineid_e" placeholder="'.$value->product->name.'"  autocomplete="off" readonly>
        </div>


        </div>
        ';
        }
        $data = array(
            'htmlproduct_type' => $htmlproduct_type,
            // 'partnersproducts' => $partnersproducts,
            // 'html_product' => $html_product,
        );

        return $htmlproduct_type;
    }
}
