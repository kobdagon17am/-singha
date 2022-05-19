<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Default
use Session;
use Response;
use Auth;
use Image;
use Yajra\Datatables\Datatables;

// Model
use App\Model\ProductType;
use App\Model\ProductCategory;
use App\Model\PartnersType;

class ProductCategoryController extends Controller
{
    // หมวดหมู่สินค้า
    // ===================================================

    public function product_category(){
        $partnerstype = PartnersType::all();
        $type = ProductType::where('status','Y')->get();

        return view('backend/product/product_category',['type'=>$type,'partnerstype'=>$partnerstype]);
    }

    public function datatable(){

        // Query Status
        $date_status = request('status_val');
        if($date_status == 'T'){
            // $dataQuery = ProductCategory::join('product_type', 'product_category.type_id', '=', 'product_type.type_id')
            // ->orderBy('product_type.name', 'ASC')
            // ->get();
            $dataQuery = ProductCategory::
            orderBy('type_id', 'ASC')
            ->get();
        }elseif($date_status == 'Y'){
            $dataQuery = ProductCategory::where('status','Y')->get();
        }elseif($date_status == 'N'){
            $dataQuery = ProductCategory::where('status','N')->get();
        }else{
            $dataQuery = ProductCategory::join('partners_type', 'product_category.type_id', '=', 'partners_type.partners_type_id')
            ->orderBy('partners_type.name', 'DESC')
            ->get();
        }
        $sQuery	 = Datatables::of($dataQuery)
        // ===================================================

        // ประเภท
        ->editColumn('colum_type',function($data){
            return $data->type->name;
        })

        // ชื่อหมวดหมู่
        ->editColumn('colum_name',function($data){
            return $data->name;
        })

        // รูปภาพ
        ->editColumn('colum_image',function($data){
            if($data->image != null ){

                $path_image = asset('storage/uploadfile/productcategory/'.$data->image);
                $data_image = "<img src='".$path_image."' style='height:75px; width:75px;'>";
            }else{
                $path_image = asset('public/assets/backend/img/wait_img.png');
                $data_image = "<img src='".$path_image."' style='height:75px; width:75px;'>";
            }
            return $data_image;
        })

        // สถานะ
        ->editColumn('colum_status',function($data){
            if($data->status == "Y"){
                $status_t = '<font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>
                            <a href="#!" onclick="status('.$data->category_id. ',' ."'$data->name'".')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>';
            }else{
                $status_t = '<font color="red"><p title="ยกเลิก"><i class="fa fa-times-circle"></i> ยกเลิก</p></font>
                            <a href="#!" onclick="status('.$data->category_id. ',' ."'$data->name'".')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>';
            }
            return $status_t;
        })

        // จัดการ
        ->editColumn('colum_manage',function($data){
            return '<button type="button" class="btn-dark model-data" data-id='.$data->category_id.' data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-edit"></i> แก้ไข</button>';
        });

        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request){
        $path = "storage/uploadfile/productcategory/";
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

        $dataQuery = new ProductCategory;
        $dataQuery->type_id = $request->type;
        $dataQuery->name = $request->name;
        $dataQuery->image = $new_imgs;
        $dataQuery->partners_type = $request->partners_type;
        $dataQuery->status = "Y";
        $dataQuery->save();

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return response()->json($data);
    }

    public function edit(Request $request){
        $dataQuery = ProductCategory::find($request->id);
        return response()->json($dataQuery);
    }

    public function update(Request $request){
        $path = "storage/uploadfile/productcategory/";
        if(!empty($request->file('image_file'))){
            $image  = $request->file('image_file');
            $type = explode('.',$image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $new_imgs = date('dmYHis').'img.'.$type[$size-1];
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save($path.$new_imgs);

            $oldpic = 'storage/uploadfile/productcategory/'.$request->fileold;
            if(is_file($oldpic)){
                unlink($oldpic);
            }
        }else{
            $new_imgs = $request->fileold;
        }

        $dataQuery = ProductCategory::find($request->id);
        $dataQuery->type_id = $request->type;
        $dataQuery->name = $request->name;
        $dataQuery->image = $new_imgs;
        // $dataQuery->partners_type = $request->partners_type;
        $dataQuery->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return response()->json($data);

    }

    public function status(Request $request){
        $dataQuery = ProductCategory::find($request->id);
        if($dataQuery->status == "Y"){
            $dataQuery->status = "N";
            $dataQuery->save();
            $data['response'] = true;
            $data['title'] = "ยกเลิกใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }else{
            $dataQuery->status = "Y";
            $dataQuery->save();
            $data['response'] = true;
            $data['title'] = "เปิดใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }
        return response()->json($data);
    }
}
