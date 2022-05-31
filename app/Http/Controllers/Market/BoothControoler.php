<?php

namespace App\Http\Controllers\Market;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Default
use Response;
use Auth;
use Image;
use DateTime;
use Yajra\Datatables\Datatables;

// Model
use App\Model\MK_MarketName;
use App\Model\MK_Booth;
use App\Model\MK_BoothDetail;
use App\Model\MK_Floor;
use App\Model\MK_Zone;
use App\Model\MK_BoothType;


class BoothControoler extends Controller
{
    // แบบบูธ
    public function booth($id) {
        $market = MK_MarketName::find($id);
        $floor = MK_Floor::where('marketname_id',$id)->get();
        $zone = MK_Zone::where('marketname_id',$id)->get();
        $booth_type = MK_BoothType::all();
        $booth = MK_Booth::all();
        return view('backend/market/booth',
        [
            'market'=>$market,
            'floor'=>$floor,
            'zone'=>$zone,
            'booth_type'=>$booth_type,
            'booth'=>$booth
        ]);
    }

    public function datatable() {

        $marketID = request('marketID');
        $booth = MK_Booth::where('marketname_id',$marketID)->orderBy('date_start', 'DESC')->get();
        // dd($booth);
        $sQuery	 = Datatables::of($booth)


        // Floor
        // ->editColumn('colum_floor',function($data){
        //     return $data->floor->name;
        // })

        // Zone
        ->editColumn('colum_zone',function($data){
            return $data->zone->name;
        })

        // ชื่อแบบ Booth
        ->editColumn('colum_name',function($data){
            return $data->name;
        })

        // วันเริ่ม
        ->editColumn('colum_date_start',function($data){
            return DateThai($data->date_start);
        })

        // วันสิ้นสุด
        ->editColumn('colum_date_end',function($data){
            return DateThai($data->date_end);
        })

        // สถานะ
        ->editColumn('colum_status',function($data){
            if($data->status == "W"){
                $status_t = '<font color="blue"><p title="ใช้งาน"><i class="fa fa-clock-o"></i> รออนุมัติ</p></font>';
            }elseif($data->status == "Y") {
                $status_t = '<font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>';
            }elseif($data->status == "N") {
                $status_t = '<font color="red"><p title="ยกเลิก"><i class="fa fa-times-circle"></i> ยกเลิก</p></font>';
            }else{
                $status_t = '-';
            }
            return $status_t;
        })

        // จัดการ

        ->editColumn('colum_manage',function($data){
            $now = new DateTime();
            // dd($now);
            $disable = "" ;
            // $now = new DateTime($booth->date_start) &&  $now <= new DateTime($booth->date_end)
            if (  $now >= new DateTime($data->date_start) ) {
                $disable = "disabled" ;
            };

            $url = url('boothzone/'.$data->booth_id);
            return ' <a href="'.$url.'" class=" btn btn-inverse btn-sm '.$disable.'" ><i class="fa fa-search"></i> ดูข้อมูล Booth</a>
                    <button type="button" class="btn-inverse model-data btn-sm" data-id='.$data->booth_id.' data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-edit"></i> แก้ไขข้อมูล</button>';

        });
        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request) {
        $date_start = new DateTime($request->date_start);
        $date_end = new DateTime($request->date_end);
        $booth = MK_Booth::find($request->id);

        if($booth){
                   // dd( $date_start, $date_end ,$request->id);
        $checkbooth = MK_Booth::where('booth_id','!=',$request->id)->where('marketname_id',$booth->marketname_id)->get();
        // dd( $checkbooth);
        foreach ($checkbooth as $key => $value) {
            # code...
            $valuedatebook = (new DateTime($value->date_start));
            $valuedateend = (new DateTime($value->date_end));
            // dd($valuedatebook,$date_start,$valuedateend,$date_end);
            $check = ((( $date_start >= $valuedatebook ) && (  $date_start <= $valuedateend   )) || (( $date_end >= $valuedatebook ) && (  $date_end <= $valuedateend   ))); // เงื่อนไข เช็คคร่อม
            $check_id[] = $value->booth_id;
            if ($check) {
                $data['response'] = true;
                $data['title'] = "วันที่เกิดเลือกทับซ้อนกับ Model อื่น";
                $data['text'] = 'ระบบได้บันทึกข้อมูลไม่สำเร็จ';
                $data['icon'] = 'error';
                return response()->json( $data);
            }
            }
        }

        $booth = new MK_Booth;
        $booth->marketname_id = $request->market_id;
        // $booth->floor_id = $request->floor_booth;
        $booth->zone_id = $request->zone_booth;
        $booth->booth_type_id = $request->type_booth;
        $booth->name = $request->name_booth;
        $booth->amount = $request->amount_booth;
        $booth->price = $request->price_start;
        $booth->date_start = $request->date_start;
        $booth->date_end = $request->date_end;
        $booth->status = "W"; // รออนุมัติ
        $booth->save();

        if(!empty($request->amount_booth)) {
            for($i=1; $i <= $request->amount_booth; $i++) {
                $booth_detail = new MK_BoothDetail;
                $booth_detail->booth_id = $booth->booth_id;
                $booth_detail->price = $booth->price;
                $booth_detail->name = "Booth".$i;
                $booth_detail->product_type = 0;
                $booth_detail->product_category = 0;
                $booth_detail->status = "Y"; // ใช้งาน
                $booth_detail->save();
            }
        }

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function edit(Request $request) {
        $booth = MK_Booth::with('market')->find($request->id);
        $now = new DateTime();
        // dd($now);
        $booth->intime = "no" ;
        // $now = new DateTime($booth->date_start) &&  $now <= new DateTime($booth->date_end)
        if (  $now >= new DateTime($booth->date_start) ) {
            $booth->intime = "yes" ;
        };

        return Response::json($booth);
    }

    public function update(Request $request) {
        $date_start = new DateTime($request->date_start);
        $date_end = new DateTime($request->date_end);
        $booth = MK_Booth::find($request->id);
        // dd( $date_start, $date_end ,$request->id);
        $checkbooth = MK_Booth::where('booth_id','!=',$request->id)->where('marketname_id',$booth->marketname_id)->get();
        // dd( $checkbooth);
        foreach ($checkbooth as $key => $value) {
            # code...
            $valuedatebook = (new DateTime($value->date_start));
            $valuedateend = (new DateTime($value->date_end));
            // dd($valuedatebook,$date_start,$valuedateend,$date_end);
            $check = ((( $date_start >= $valuedatebook ) && (  $date_start <= $valuedateend   )) || (( $date_end >= $valuedatebook ) && (  $date_end <= $valuedateend   ))); // เงื่อนไข เช็คคร่อม
            $check_id[] = $value->booth_id;
            if ($check) {
                $data['response'] = true;
                $data['title'] = "วันที่เลือกทับซ้อนกับ Model อื่น";
                $data['text'] = 'ระบบได้บันทึกข้อมูลไม่สำเร็จ';
                $data['icon'] = 'error';
                return response()->json( $data);
            }
        }
        // dd($check_id);

        $booth->name = $request->name_booth;
        $booth->date_start = $request->date_start;
        $booth->date_end = $request->date_end;
        if ($request->status != null) {
            $booth->status = $request->status;
        }

        $booth->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        $data['icon'] = 'success';
        return Response::json($data);
    }

    public function copy(Request $request) {
        $date_start = new DateTime($request->date_start);
        $date_end = new DateTime($request->date_end);
        $model_booth = MK_Booth::find($request->booth_id); // Model Booth
        $model_booth_detail = MK_BoothDetail::where('booth_id',$model_booth->booth_id)->get(); // Model Booth Detail

        $checkbooth = MK_Booth::where('booth_id','!=',$model_booth->id)->where('marketname_id',$model_booth->marketname_id)->get();
        // dd( $checkbooth);
        foreach ($checkbooth as $key => $value) {
            # code...
            $valuedatebook = (new DateTime($value->date_start));
            $valuedateend = (new DateTime($value->date_end));
            // dd($valuedatebook,$date_start,$valuedateend,$date_end);
            $check = ((( $date_start >= $valuedatebook ) && (  $date_start <= $valuedateend   )) || (( $date_end >= $valuedatebook ) && (  $date_end <= $valuedateend   ))); // เงื่อนไข เช็คคร่อม
            $check_id[] = $value->booth_id;
            if ($check) {
                $data['response'] = true;
                $data['title'] = "วันที่เกิดเลือกทับซ้อนกับ Model อื่น";
                $data['text'] = 'ระบบได้บันทึกข้อมูลไม่สำเร็จ';
                $data['icon'] = 'error';
                return response()->json( $data);
            }
        }

        if(!empty($model_booth)) {

            $booth = new MK_Booth;
            $booth->marketname_id = $model_booth->marketname_id;
            $booth->floor_id = $model_booth->floor_id;
            $booth->zone_id = $model_booth->zone_id;
            $booth->booth_type_id = $model_booth->booth_type_id;
            $booth->name = $request->name;
            $booth->amount = $model_booth->amount;
            $booth->price = $model_booth->price;
            $booth->date_start = $request->date_start;
            $booth->date_end = $request->date_end;
            $booth->status = "W";
            $booth->save();
        }

        foreach($model_booth_detail as $booth_dt) {
            $booth_detail = new MK_BoothDetail;
            $booth_detail->booth_id = $booth->booth_id;
            $booth_detail->price = $booth_dt->price;
            $booth_detail->name = $booth_dt->name;
            $booth_detail->product_type = $booth_dt->product_type;
            $booth_detail->product_category = $booth_dt->product_category;
            $booth_detail->status = $booth_dt->status;
            $booth_detail->zone_id = $booth_dt->zone_id;
            $booth_detail->save();
        }



        $data['response'] = true;
        $data['title'] = "Copy Booth สำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }
}
