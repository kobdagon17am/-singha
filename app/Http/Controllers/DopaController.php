<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Model\Subdistrict;
use App\Model\District;
use App\Model\Province;

class DopaController extends Controller
{
    // หน้าแดชบอร์ด
    // ===================================================

    public function province(){
        return view('backend/dopa/province');
    }
    public function dataprovince(Request $request)
    {

        // dd($request->all);
        $data = Province::all();
        // dd($data);

        return Datatables::of($data)->addIndexColumn()
        // ->addColumn('booking_id', function ($data) {
        //     $data = $data->booking_id;
        //     // dd($data);
        //      return $data;
        // })
        // ->addColumn('market', function ($data) {

        //     if ($data->market != null) {
        //         $data = $data->market->name_market;
        //     }else{
        //         $data ="ทดสอบ";
        //     }
        //      return $data;
        // })
        ->addColumn('manage', function ($data) {

            return '<a href="#" class="btn btn-inverse btn-round btn-sm " onclick="show('.$data->id.')" ><i class="fa fa-search"></i> แก้ไขข้อมูล </a>
            <a href="#" class="btn btn-inverse btn-round btn-sm " onclick="destroy('.$data->id.')"  ><i class="fa fa-search"></i> ลบข้อมูล </a>';
        })
        ->rawColumns(['manage','market','partners','booking_id','booking_status'])
        ->make(true);
    }
    public function addprovince(Request $request){
        // dd($request->all());

        $province = new Province ;
        $province->name_th = $request->name_th;
        $province->save();

        return $province;
    }
    public function showprovince(Request $request){
        // dd($request->all());
        $province = Province::find($request->keep);
        // $data = array(
        //     'province' => $province,
        //     'services' => $services,
        // );
        return $province;
    }
    public function editprovince(Request $request){
        // dd($request->all());
        $province = Province::find($request->id_province);
        $province->name_th = $request->name_th;
        $province->save();
        return $province;
    }
    public function deleteprovince(Request $request){
        // dd($request->all());
        $province = province::find($request->keep);
        $province->delete();
        return 'ss';
    }
    public function district(){
        $province = province::all();
        $data = array(
            'province' => $province
        );
        return view('backend/dopa/district', $data);
    }
    public function datadistrict(Request $request)
    {

        // dd($request->all);
        $data = District::all();
        // dd($data);

        return Datatables::of($data)->addIndexColumn()
        // ->addColumn('booking_id', function ($data) {
        //     $data = $data->booking_id;
        //     // dd($data);
        //      return $data;
        // })
        // ->addColumn('market', function ($data) {

        //     if ($data->market != null) {
        //         $data = $data->market->name_market;
        //     }else{
        //         $data ="ทดสอบ";
        //     }
        //      return $data;
        // })
        ->addColumn('manage', function ($data) {
            return '<a href="#" class="btn btn-inverse btn-round btn-sm " onclick="show('.$data->id.')"><i class="fa fa-search"></i> แก้ไขข้อมูล </a>
            <a href="#" class="btn btn-inverse btn-round btn-sm " onclick="destroy('.$data->id.')"><i class="fa fa-search"></i> ลบข้อมูล </a>';
        })
        ->rawColumns(['manage','market','partners','booking_id','booking_status'])
        ->make(true);
    }
    public function adddistrict(Request $request){
        // dd($request->all());

        $district = new District ;
        $district->province_id = $request->province;
        $district->name_th = $request->name_th;
        $district->save();

        return $district;
    }
    public function showdistrict(Request $request){
        // dd($request->all());
        $province = District::find($request->keep);
        // $data = array(
        //     'province' => $province,
        //     'services' => $services,
        // );
        return $province;
    }
    public function editdistrict(Request $request){
        // dd($request->all());
        $district = District::find($request->id_district);
        $district->name_th = $request->name_th;
        $district->province_id = $request->province;
        $district->save();
        return $district;
    }
    public function deletedistrict(Request $request){
        // dd($request->all());
        $district = District::find($request->keep);
        $district->delete();
        return 'ss';
    }
    public function subdistrict(){
        $Province = Province::all();
        $District = District::all();
        $data = array(
            'district' => $District,
            'province' => $Province
        );
        return view('backend/dopa/subdistrict', $data );
    }
    public function datasubdistrict(Request $request)
    {

        // dd($request->all);
        $data = Subdistrict::all();
        // dd($data);

        return Datatables::of($data)->addIndexColumn()
        // ->addColumn('booking_id', function ($data) {
        //     $data = $data->booking_id;
        //     // dd($data);
        //      return $data;
        // })
        // ->addColumn('market', function ($data) {

        //     if ($data->market != null) {
        //         $data = $data->market->name_market;
        //     }else{
        //         $data ="ทดสอบ";
        //     }
        //      return $data;
        // })
        ->addColumn('manage', function ($data) {
            return '<a href="#" class="btn btn-inverse btn-round btn-sm " onclick="show('.$data->id.')"><i class="fa fa-search"></i> แก้ไขข้อมูล </a>
            <a href="#" class="btn btn-inverse btn-round btn-sm "  onclick="destroy('.$data->id.')"><i class="fa fa-search"></i> ลบข้อมูล </a>';
        })
        ->rawColumns(['manage','market','partners','booking_id','booking_status'])
        ->make(true);
    }
    public function addsubdistrict(Request $request){
        // dd($request->all());

        $province = new Subdistrict ;
        $province->name_th = $request->name_th;
        $province->district_id = $request->district;
        $province->save();

        return $province;
    }
    public function showsubdistrict(Request $request){
        // dd($request->all());
        $province = Subdistrict::find($request->keep);
        $district = District::find($province->district_id);
        $province->province_id = $district->province_id;
        // $data = array(
        //     'province' => $province,
        //     'services' => $services,
        // );
        return $province;
    }
    public function editsubdistrict(Request $request){
        // dd($request->all());
        $province = Subdistrict::find($request->id_subdistrict);
        $province->name_th = $request->name_th;
        $province->save();
        return $province;
    }
    public function deletesubdistrict(Request $request){
        // dd($request->all());
        $province = Subdistrict::find($request->keep);
        $province->delete();
        return 'ss';
    }
}
