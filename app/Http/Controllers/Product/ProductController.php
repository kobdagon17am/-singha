<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Default
use Response;
use Auth;
use Image;
use Yajra\Datatables\Datatables;

// Model
use App\Model\ProductType;
use App\Model\ProductCategory;
use App\Model\Product;

class ProductController extends Controller
{
    // สินค้า
    // ===================================================

    public function product(){
        $type = ProductType::where('status','Y')->get();
        $category = ProductCategory::where('status','Y')->get();
        return view('backend/product/product',['type'=>$type,'category'=>$category]);
    }

    public function datatable(){
        // Query Status
        $date_status = request('status_val');
        if($date_status == 'T'){
            $product = Product::orderBy('type_id', 'ASC')->orderBy('category_id', 'ASC')->get();
            // $product = Product::whereHas('type', function ($query){
            //     $query->orderBy('name', 'ASC');
            // })->
            // whereHas('category', function ($query) {
            //     $query->orderBy('name', 'ASC');
            // })
            // // join('product_type', 'product.type_id', '=', 'product_type.type_id')
            // // ->join('product_category', 'product.category_id', '=', 'product_category.category_id')
            // // ->orderBy('product_type.name', 'ASC')
            // // ->orderBy('product_category.name', 'ASC')
            // ->get();
            // dd($product);
        }elseif($date_status == 'Y'){
            $product = Product::where('status','Y')->get();
        }elseif($date_status == 'N'){
            $product = Product::where('status','N')->get();
        }else{
            $product = Product::all();
        }
        $sQuery	 = Datatables::of($product)
        // ===================================================

        // ประเภท
        ->editColumn('colum_type',function($data){
            return $data->type->name;
        })

        // ชื่อหมวดหมู่
        ->editColumn('colum_category',function($data){

        $string = $data->category->name;
        // if(strlen ($string) > 30){

        //     $string = substr($string,0,30) . "....";

        // }

            return $string;
        })

        // ชื่อสินค้า
        ->editColumn('colum_name',function($data){
            return $data->name;
        })

        // สถานะ
        ->editColumn('colum_status',function($data){
            if($data->status == "Y"){
                $status_t = '<font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>
                            <a href="#!" onclick="status('.$data->product_id. ',' ."'$data->name'".')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>';
            }else{
                $status_t = '<font color="red"><p title="ยกเลิก"><i class="fa fa-times-circle"></i> ยกเลิก</p></font>
                            <a href="#!" onclick="status('.$data->product_id. ',' ."'$data->name'".')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>';
            }
            return $status_t;
        })

        // จัดการ
        ->editColumn('colum_manage',function($data){
            return '<button type="button" class="btn-dark model-data" data-id='.$data->product_id.' data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-edit"></i> แก้ไข</button>';
        });

        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request){
        $product = new Product;
        $product->type_id = $request->type;
        $product->category_id = $request->category;
        $product->name = $request->name;
        $product->status = "Y";
        $product->save();

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);

    }

    public function edit(Request $request){
        $product = Product::find($request->id);
        return Response::json($product);
    }

    public function update(Request $request){
        $product = Product::find($request->id);
        $product->type_id = $request->type;
        $product->category_id = $request->category;
        $product->name = $request->name;
        $product->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function status(Request $request){
        $product = Product::find($request->id);
        if($product->status == "Y"){
            $product->status = "N";
            $product->save();
            $data['response'] = true;
            $data['title'] = "ยกเลิกใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }else{
            $product->status = "Y";
            $product->save();
            $data['response'] = true;
            $data['title'] = "เปิดใช้งานสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        }
        return Response::json($data);
    }

    public function query_category(Request $request){
        $category = ProductCategory::where('type_id',$request->id)->where('status','Y')->get();
        return Response::json($category);
    }




}
