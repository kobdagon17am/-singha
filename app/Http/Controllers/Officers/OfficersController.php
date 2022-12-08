<?php

namespace App\Http\Controllers\Officers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Default
use Response;
use Auth;
use Image;
use Yajra\Datatables\Datatables;

// Model
use App\Model\Officers;
use App\Model\OfficersMarket;
class OfficersController extends Controller
{
    // จัดการผู้เช่า
    // ===================================================

    public function index(){
        $officer = Officers::all();



        $data = array(
            'officer' => $officer,
        );

        return view('backend/officers/officers',$data);
    }

    public function datatable(){
        // Query Status
        $date_status = request('status_val');
        // if($date_status == 'T'){
        //     $partners = Partners::where('status','!=','W')->get();
        // }elseif($date_status == 'Y'){
        //     $partners = Partners::where('status','Y')->get();
        // }elseif($date_status == 'N'){
        //     $partners = Partners::where('status','N')->get();
        // }else{
        //     $partners = Partners::where('status','!=','W')->get();
        // }
        $data = Officers::all();
        // dd($data);

        return Datatables::of($data)->addIndexColumn()
        // ->addColumn('booking_id', function ($data) {
        //     $data = $data->booking_id;
        //     // dd($data);
        //      return $data;
        // })
        // ->addColumn('market', function ($data) {
        //     $data = $data->market->name_market;
        //      return $data;
        // })
         // สถานะ
         ->editColumn('colum_status',function($data){
            if($data->status == "Y"){
                $status_t = '<font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>
                <a href="#!" onclick="status('.$data->userid.','."'$data->name'".')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>
                ';
            }else if($data->status == "N"){
                $status_t = '<font color="red"><p title="ระงับใช้งาน"><i class="fa fa-check-circle"></i> ระงับใช้งาน</p></font>
                <a href="#!" onclick="status('.$data->userid.','."'$data->name'".')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>
                ';
            }else{
                $status_t = '<font color="black"><p title="ข้อมูลไม่สมบูรณ์"><i class="fa fa-times-circle"></i> ข้อมูลไม่สมบูรณ์</p></font>';
            }
            return $status_t;
        })
        //     // $data = "2";


        //      return $value;
        // })
        // ->addColumn('partners', function ($data) {
        //     $data = $data->partners->name_customer;
        //      return $data;
        // })
        ->addColumn('manage', function ($data) {


            return '<button type="button" class="btn-dark model-data" data-id='.$data->userid.' data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-edit"></i> แก้ไข</button>';
        })
        ->rawColumns(['manage','market','partners','booking_id','colum_status'])
        ->make(true);
    }

    public function store(Request $request){
        // dd($request);
        // citizen
        // $pathCZ = "storage/uploadfile/partners/";
        // if(!empty($request->file('imge_citizen'))){
        //     $image  = $request->file('imge_citizen');
        //     $type = explode('.',$image->getClientOriginalName());
        //     $size = sizeof($type);
        //     $new_img = $image->getClientOriginalName();
        //     $imge_citizen = date('dmYHis').'CZ.'.$type[$size-1];
        //     $image_resize = Image::make($image->getRealPath());
        //     $image_resize->save($pathCZ.$imge_citizen);
        // }else{
        //     $imge_citizen = null;
        // }

        // // kp20
        // $pathKP = "storage/uploadfile/partners/";
        // if(!empty($request->file('imge_KP'))){
        //     $image  = $request->file('imge_KP');
        //     $type = explode('.',$image->getClientOriginalName());
        //     $size = sizeof($type);
        //     $new_img = $image->getClientOriginalName();
        //     $imge_KP = date('dmYHis').'KP.'.$type[$size-1];
        //     $image_resize = Image::make($image->getRealPath());
        //     $image_resize->save($pathKP.$imge_KP);
        // }else{
        //     $imge_KP = null;
        // }

        $partners = new Officers;
        $partners->username = $request->username;
        $partners->password = md5($request->password);
        // $partners->space_customer_id = $request->space_customer_id;
        // $partners->name_customer = $request->name_customer;
        // $partners->numbertax = $request->numbertax;
        $partners->firstname = $request->name;
        $partners->lastname = $request->lastname;
        // $partners->citizenid = $request->citizenid;
        // $partners->partners_type = $request->partners_type;
        // $partners->address = $request->address;
        // $partners->soi = $request->soi;
        // $partners->road = $request->road;
        // $partners->district = $request->district;
        // $partners->ampure = $request->ampure;
        // $partners->province = $request->province;
        // $partners->zipcode = $request->zipcode;
        // $partners->email = $request->email;
        // $partners->phone = $request->phone;
        // $partners->lineid = $request->lineid;
        // $partners->status_partners = $request->status_partners;
        // $partners->image_citizen = $imge_citizen; // รูปบัตรประชาชน
        // $partners->image_kp20 = $imge_KP; // รูป ก.พ 20
        $partners->status = "Y";
        $partners->role = $request->officers_type;
        // $partners->status = "Y";
        $partners->save();

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return response()->json($data);
    }

    public function edit(Request $request){
        // dd( $request->all());
        $officers = Officers::find($request->id);
        // $partnersproduct = PartnersProduct::where('partners_id',$partners->partners_id)->get();
        // $countpartnersproduct = PartnersProduct::where('partners_id',$partners->partners_id)->count();
        // if ($partnersproduct == null) {
        //     # code...
        //     $partners = Partners::latest()->first();
        //     $partnersproduct = PartnersProduct::where('partners_id',$partners->partners_id)->first();

        // }
        // dd($partnersproduct);
        // $htmlofficermarket = $this->htmlofficermarket($officers->officer_id);
        // $htmlproduct_type = '';
        // foreach ($partnersproduct as $key => $value) {
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
        // $product = Product::where('product_id',$partnersproduct->product_id)->first();
        // onclick="changeproducttype('.$value->partners_id.')"
        $data = array(
            'officers' => $officers,
            // 'countpartnersproduct' => $countpartnersproduct,
            // 'product' => $product,
            // 'htmlofficermarket' => $htmlofficermarket,

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
        $partners->image_citizen = $imge_citizen; // รูปภาพบัตรประชาชน
        $partners->image_kp20 = $imge_KP; // รูปภาพ ก พ 20
        // $partners->status = ;
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

        $partnercategorys = ProductCategory::where('type_id',$request->producttype)->get();
        $html_partnercategorys = '';
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
        $htmlofficermarkets = $this->htmlofficermarkets($partners_id);
        $data = array(
            'htmlofficermarkets' => $htmlofficermarkets,
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
    public function htmlofficermarket($officer_id){
        // dd($request->all());
        $officermarkets = OfficersMarket::where('officer_id',$officer_id)->get();

        $htmlofficermarkets = '';
        foreach ($officermarkets as $key => $value) {
            # code...

        $htmlofficermarkets .= '

        ';
        }
        $data = array(
            'htmlofficermarkets' => $htmlofficermarkets,
            // 'partnersproducts' => $partnersproducts,
            // 'html_product' => $html_product,
        );

        return $htmlofficermarkets;
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
}
