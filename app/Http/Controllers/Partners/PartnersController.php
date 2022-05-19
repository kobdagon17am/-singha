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

class PartnersController extends Controller
{
    // จัดการผู้เช่า
    // ===================================================

    public function partners_user(){

        // $partners = Partners::where('keys','!=',"")->get();
        // foreach ($partners as $keyout => $partner) {
        //     # code...


        //     // $product = Product::where('name', 'like', '%' . $partner->keys . '%')->count();
        //     // if ($product == 0) {
        //     //     # code...
        //     //     $keyall[] = $partner->keys;
        //     // }
        //     $product = Product::where('name', 'like', '%' . $partner->keys . '%')->first();
        //     $partnersp = PartnersProduct::find($partner->partners_id);
        //     $partnersp->product_id = $product->product_id;
        //     $partnersp->save();

        // }
        // dd($keyall);

        $producttypes = Producttype::all();
        $partnercategorys = ProductCategory::all();
        $products = Product::all();
        $partnerstype = PartnersType::all();
        $district = District::all();
        $province = Province::all();
        $subdistrict = Subdistrict::all();
        $data = array(
            'producttypes' => $producttypes,
            'partnercategorys' => $partnercategorys,
            'products' => $products,
            'partnerstype' => $partnerstype,
            'district' => $district,
            'province' => $province,
            'subdistrict' => $subdistrict,
        );

        return view('backend/partners/partners_user',$data);
    }

    public function datatable(){
        // Query Status
        $date_status = request('status_val');
        if($date_status == 'T'){
            $partners = Partners::where('status','!=','W')->get();
        }elseif($date_status == 'Y'){
            $partners = Partners::where('status','Y')->get();
        }elseif($date_status == 'N'){
            $partners = Partners::where('status','N')->get();
        }else{
            $partners = Partners::where('status','!=','W')->get();
        }
        // dd($partners);
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
        // เบอร์โทร
        ->editColumn('partners_type',function($data){
            $data = $data->partnertype->name;
            return $data;
        })
        // สถานะ
        ->editColumn('colum_status',function($data){
            if($data->status == "Y"){
                $status_t = '<font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>
                <a href="#!" onclick="status('.$data->partners_id.','."'$data->name'".')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>
                ';
            }else if($data->status == "N"){
                $status_t = '<font color="red"><p title="ระงับใช้งาน"><i class="fa fa-check-circle"></i> ระงับใช้งาน</p></font>
                <a href="#!" onclick="status('.$data->partners_id.','."'$data->name'".')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>
                ';
            }else{
                $status_t = '<font color="black"><p title="ข้อมูลไม่สมบูรณ์"><i class="fa fa-times-circle"></i> ข้อมูลไม่สมบูรณ์</p></font>';
            }
            return $status_t;
        })

        // จัดการ
        ->editColumn('colum_manage',function($data){
            return '<button type="button" class="btn-dark model-data" data-id='.$data->partners_id.' data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-edit"></i> แก้ไข</button>';
        });

        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request){

        // citizen
        $pathCZ = "storage/uploadfile/partners/";
        if(!empty($request->file('imge_citizen'))){
            $image  = $request->file('imge_citizen');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $imge_citizen = date('dmYHis').'CZ.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save($pathCZ.$imge_citizen);
        }else{
            $imge_citizen = null;
        }

        // kp20
        $pathKP = "storage/uploadfile/partners/";
        if(!empty($request->file('imge_KP'))){
            $image  = $request->file('imge_KP');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $imge_KP = date('dmYHis').'KP.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save($pathKP.$imge_KP);
        }else{
            $imge_KP = null;
        }

        $partners = new Partners;
        $partners->username = $request->username;
        $partners->password = md5($request->password);
        $partners->space_customer_id = $request->space_customer_id;
        $partners->name_customer = $request->name_customer;
        $partners->numbertax = $request->numbertax;
        $partners->name = $request->name;
        $partners->lastname = $request->lastname;
        $partners->citizenid = $request->citizenid;
        $partners->partners_type = $request->partners_type;
        $partners->address = $request->address;
        $partners->soi = $request->soi;
        $partners->road = $request->road;
        $partners->district = $request->district;
        $partners->ampure = $request->ampure;
        $partners->province = $request->province;
        $partners->zipcode = $request->zipcode;
        $partners->email = $request->email;
        $partners->phone = $request->phone;
        $partners->lineid = $request->lineid;
        $partners->status_partners = $request->status_partners;
        $partners->image_citizen = $imge_citizen; // รูปบัตรประชาชน
        $partners->image_kp20 = $imge_KP; // รูป ก.พ 20
        $partners->accountname = $request->accountname;
        $partners->accountphone = $request->accountphone;
        $partners->status = "W";
        $partners->save();

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return response()->json($data);
    }

    public function edit(Request $request){
        $partners = Partners::find($request->id);
        $partnersproduct = PartnersProduct::where('partners_id',$partners->partners_id)->get();
        $countpartnersproduct = PartnersProduct::where('partners_id',$partners->partners_id)->count();

        $districts = District::all();
        $htmld = '<option value="">กรุณาเลือกอำเภอ</option>';
        foreach ($districts as $key => $district) {
            $htmld .= '<option value="'.$district->id.'">'.$district->name_th.'</option>';
        }
        $sdistricts = Subdistrict::all();
        $htmls = '<option value="">กรุณาเลือกตำบล</option>';
        foreach ($sdistricts as $key => $sdistrict) {
            $htmls .= '<option value="'.$sdistrict->id.'">'.$sdistrict->name_th.'</option>';
        }

        $htmlproduct_type = $this->htmlproduct_type($partners->partners_id);

        $data = array(
            'htmld' => $htmld,
            'htmls' => $htmls,
            'partners' => $partners,
            'countpartnersproduct' => $countpartnersproduct,
            // 'product' => $product,
            'htmlproduct_type' => $htmlproduct_type,

        );
        return Response::json($data);
    }

    public function update(Request $request){
        // dd($request->all());
        // citizen
        $pathCZ = "storage/uploadfile/partners/";
        if(!empty($request->file('imge_citizen'))){
            $image  = $request->file('imge_citizen');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $imge_citizen = date('dmYHis').'CZ.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save($pathCZ.$imge_citizen);

            $oldpic = 'storage/uploadfile/partners/'.$request->image_CZ;
            if(is_file($oldpic)){
                unlink($oldpic);
            }

        }else{
            $imge_citizen = $request->image_CZ;
        }
        // =====================================

        // kp20
        $pathKP = "storage/uploadfile/partners/";
        if(!empty($request->file('imge_KP'))){
            $image  = $request->file('imge_KP');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $imge_KP = date('dmYHis').'KP.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save($pathKP.$imge_KP);

            $oldpic = 'storage/uploadfile/partners/'.$request->image_KP;
            if(is_file($oldpic)){
                unlink($oldpic);
            }

        }else{
            $imge_KP = $request->image_KP;
        }
        // =====================================



        $partners = Partners::find($request->partners_id);
        // $partners->username = $request->username;
        // $partners->password = $request->password;
        // $partners->password = md5($request->password);
        $partners->space_customer_id = $request->space_customer_id;
        $partners->name_customer = $request->name_customer;
        $partners->numbertax = $request->numbertax;
        $partners->name = $request->name;
        $partners->lastname = $request->lastname;
        $partners->citizenid = $request->citizenid;
        $partners->partners_type = $request->partners_type;
        $partners->address = $request->address;
        $partners->soi = $request->soi;
        $partners->road = $request->road;
        $partners->district = $request->district;
        $partners->ampure = $request->ampure;
        $partners->province = $request->province;
        $partners->zipcode = $request->zipcode;
        $partners->email = $request->email;
        $partners->phone = $request->phone;
        $partners->lineid = $request->lineid;
        $partners->status_partners = $request->status_partners;
        $partners->image_citizen = $imge_citizen; // รูปภาพบัตรประชาชน
        $partners->image_kp20 = $imge_KP; // รูปภาพ ก พ 20
        // $partners->status = ;
        $partners->accountname = $request->accountname;
        $partners->accountphone = $request->accountphone;
        $partners->save();
        // $partnersproduct = PartnersProduct::find($request->id);
        // $partnersproduct->product_id =  $request->product_edit;
        // $partnersproduct->save();
        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return response()->json($data);
    }

    public function searchcategory(Request $request){
        // dd($request->all());

        $partnercategorys = ProductCategory::where('type_id',$request->producttype)->where('status','Y')->get();
        $html_partnercategorys = '<option value="">เลือกหมวดหมู่</option> ';
        foreach ($partnercategorys as $key => $partnercategory) {
            $html_partnercategorys .= '<option value="'.$partnercategory->category_id.'">'.$partnercategory->name.'</option>';

        }



        $data = array(

            'html_partnercategorys' => $html_partnercategorys,
            // 'html_product' => $html_product,
        );

        return $data;
    }
    public function searchproduct(Request $request){
        // dd($request->all());
        $type_id = $request->producttype;
        $category = $request->productcategory;
        // dd($type_id,$category);
        $products = Product::where('type_id',$type_id)->where('category_id',$category)->get();
        // dd($products,$request->all());
        $html_product = '';
        foreach ($products as $key => $product) {
            $html_product .= '<option value="'.$product->product_id.'">'.$product->name.'</option>';

        }



        $data = array(

            'html_product' => $html_product,
            // 'html_product' => $html_product,
        );

        return $data;
    }
    public function updateproducttype(Request $request){
        // dd($request->all());
        $product_search = $request->product_search;
        $product_id_old = $request->product_id_old;
        $partners_id = $request->partners_id;
        // dd($type_id,$category);
        $partnersproduct = PartnersProduct::where('partners_id',$partners_id)->where('product_id',$product_id_old)->first();
        // dd($partnersproducts);
        $partnersproduct->product_id = $product_search;
        $partnersproduct->save();
        // dd($products,$request->all());

        // $partnersproducts = PartnersProduct::where('partners_id',$partners_id)->get();

        // $htmlproduct_type = '';
        // foreach ($partnersproducts as $key => $value) {
        //     # code...

        // $htmlproduct_type .= '
        // <div class="form-group row" >
        // <label class="col-sm-4 col-form-label text-right">ประเภทสินค้า:</label>
        // <div class="col-sm-2">
        //     <input type="text" class="form-control" name="" id="" placeholder="'.$value->product->type->name.'"  autocomplete="off" readonly>

        // </div>
        // <label class="col-form-label">หมวดหมู่สินค้า:</label>
        // <div class="col-sm-2">
        //     <input type="text" class="form-control" name="" id="" placeholder="'.$value->product->category->name.'"  autocomplete="off" readonly>
        // </div>

        // </div>
        // <div class="form-group row">
        //     <label class="col-sm-4 col-form-label text-right">สินค้าที่เลือก:</label>
        // <div class="col-sm-2">
        //     <input type="text" class="form-control" name="lineid" id="lineid_e" placeholder="'.$value->product->name.'"  autocomplete="off" required>
        // </div>
        // <div class="col-sm-2">
        //     <button type="button" class="btn btn-danger" onclick="changeproducttype('.$value->partners_id.','.$value->product_id.')" ><i class="fa fa-edit"></i>แก้ไข</button>
        // </div>
        // </div>
        // ';
        // }
        $htmlproduct_type = $this->htmlproduct_type($partners_id);
        $data = array(
            'htmlproduct_type' => $htmlproduct_type,
            // 'partnersproducts' => $partnersproducts,
            // 'html_product' => $html_product,
        );

        return $data;
    }
    public function addproducttype(Request $request){
        // dd($request->all());
        $partners_id = $request->partners_id;
        $product_search = $request->product_search;
        // dd($type_id,$category);
        $partnersproduct = new PartnersProduct;
        $partnersproduct->partners_id = $partners_id;
        $partnersproduct->product_id = $product_search;
        $partnersproduct->save();


        $htmlproduct_type = $this->htmlproduct_type($partners_id);
        $data = array(

            'htmlproduct_type' => $htmlproduct_type,
            // 'html_product' => $html_product,
        );

        return $data;
    }
    public function deleteproducttype(Request $request){
        // dd($request->all());
        $partners_id = $request->partners_id;
        $product_id = $request->product_id;
        // dd($type_id,$category);
        $partnersproduct = PartnersProduct::where('partners_id',$partners_id)->where('product_id',$product_id)->delete();
        // dd($partnersproduct);
        $htmlproduct_type = $this->htmlproduct_type($partners_id);
        $data = array(

            'htmlproduct_type' => $htmlproduct_type,
            // 'html_product' => $html_product,
        );

        return $data;
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
            <input type="text" class="form-control" name="" id="" placeholder="'.@$value->product->type->name.'"  autocomplete="off" readonly>

        </div>
        <label class="col-form-label">หมวดหมู่สินค้า:</label>
        <div class="col-sm-2">
            <input type="text" class="form-control" name="" id="" placeholder="'.@$value->product->category->name.'"  autocomplete="off" readonly>
        </div>

        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label text-right">สินค้าที่เลือก:</label>
        <div class="col-sm-2">
            <input type="text" class="form-control" name="lineid" id="lineid_e" placeholder="'.@$value->product->name.'"  autocomplete="off" readonly>
        </div>
        <div class="col-sm-4">
            <button type="button" class="btn btn-warning btn-sm" onclick="changeproducttype('.$value->partners_id.','.$value->product_id.')" ><i class="fa fa-edit"></i>แก้ไข</button>
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteproducttype('.$value->partners_id.','.$value->product_id.')" ><i class="fa fa-trash"></i>ลบ</button>

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
    public function status(Request $request){
        $partners = Partners::find($request->id);
        // dd($partners);
        if($partners->status == "Y"){
            $partners->status = "N";
            $partners->save();
            $data['response'] = true;
            $data['title'] = "ยกเลิกใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }else{
            $partners->status = "Y";
            $partners->save();
            $data['response'] = true;
            $data['title'] = "เปิดใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }
        return Response::json($data);
    }
    public function changepassword(Request $request){
        // dd($request->all());
        $new_password = $request->new_password;
        $partners_id = $request->partners_id;
        // dd($type_id,$category);
        $partners = Partners::find($partners_id);
        $partners->password = md5($new_password);
        $partners->save();

        $partners->save();
            $data['response'] = true;
            $data['title'] = "เปิดใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';

            return Response::json($data);
    }
    public function selectdistrict(Request $request){
        // dd($request->all());
        $value = $request->value;
        $districts = District::where('province_id',$value)->get();
        $html = '<option value="">กรุณาเลือกอำเภอ</option>';
        foreach ($districts as $key => $district) {
            $html .= '<option value="'.$district->id.'">'.$district->name_th.'</option>';
        }
        $data = array(

            'html' => $html,
            // 'html_product' => $html_product,
        );

        return $data;
    }
    public function selectsubdistrict(Request $request){
        // dd($request->all());
        $value = $request->value;
        $sdistricts = Subdistrict::where('district_id',$value)->get();
        $html = '<option value="">กรุณาเลือกตำบล</option>';
        foreach ($sdistricts as $key => $sdistrict) {
            $html .= '<option value="'.$sdistrict->id.'">'.$sdistrict->name_th.'</option>';
        }
        $data = array(

            'html' => $html,
            // 'html_product' => $html_product,
        );

        return $data;
    }
}
