<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Default
use Response;
use Auth;
use Image;
use Yajra\Datatables\Datatables;

// Model
use App\Model\Admin;
use App\Model\Coupon;
use App\Model\CouponSend;
use App\Model\Partners;
use App\Model\PartnersType;
use App\Model\MK_MarketName;
use App\Model\Coupon_Personal;
use App\Model\Coupon_Market;
use App\Model\NotificationpPartners;

class CouponController extends Controller
{
    // จัดการโค้ดส่วนลด
    // ===================================================
    public function coupon(){
        $markets = MK_MarketName::all();
        $partnerstype = PartnersType::all();
        $data = array(
            'markets'=>$markets,
            'partnerstype'=>$partnerstype,
        );
        return view('backend/coupon/coupon', $data);
    }

    public function datatable(){
        // Query Status
        $date_status = request('status_val');
        if($date_status == 'T'){
            $coupon = Coupon::all();
        }elseif($date_status == 'Y'){
            $coupon = Coupon::where('status','Y')->get();
        }elseif($date_status == 'N'){
            $coupon = Coupon::where('status','N')->get();
        }elseif($date_status == 'W'){
            $coupon = Coupon::where('status','W')->get();
        }else{
            $coupon = Coupon::all();
        }
        $sQuery	 = Datatables::of($coupon)
        // ===================================================

        // รหัสโค้ด
        ->editColumn('colum_code',function($data){
            return $data->code;
        })
        // ชื่อโค้ด
        ->editColumn('colum_name',function($data){
            return $data->name;
        })
        // ราคาลด
        ->editColumn('colum_price',function($data){
            if($data->type_con == "1"){
                $type = "บาท";
            }else{
                $type = "%";
            }

            return $data->price." ".$type;
        })
        // วันที่เริ่ม
        ->editColumn('colum_date_start',function($data){
            return $data->date_start;
        })
        // วันที่สิ้นสุด
        ->editColumn('colum_date_end',function($data){
            return $data->date_end;
        })
        // จำนวน
        ->editColumn('colum_amount',function($data){
            return $data->amount;
        })
        // ใช้แล้ว
        ->editColumn('colum_amount_use',function($data){
            if($data->amount_use == NULL){
                $use = 0;
            }else{
                $use = $data->amount_use;
            }
            return $use;
        })
        // คงเหลือ
        ->editColumn('colum_balance',function($data){
            $resultf = $data->amount - $data->amount_use;
            return $resultf;
        })
        // สถานะ
        ->editColumn('colum_status',function($data){
            if($data->status == "W"){
                $status = '<font color="blue"><p title="ใช้งาน"><i class="fa fa-check-square-o"></i> รออนุมัติ</p></font>';
            }elseif($data->status == "Y"){
                $status = '<font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>';
            }elseif($data->status == "N"){
                $status = '<font color="red"><p title="ยกเลิก"><i class="fa fa-times-circle"></i> ยกเลิก</p></font>';
            }else{
                $status = "-";
            }
            return $status;
        })

        ->editColumn('colum_typecoupon',function($data){
            if($data->type_coupon == "Everyone"){
                $tpye_t = '<button class="btn-danger" >ทุกคน</button>';
            }elseif($data->type_coupon == "Personal"){
                $tpye_t = '<button class="btn-primary" >บุคคล</button>';

            }
            return $tpye_t;
        })

        // จัดการ
        ->editColumn('colum_manage',function($data){

            // IF Check Status And Type Coupon
            if($data->status == "Y" && $data->type_coupon == "Personal"){
                $send_code =  ' <a href="#!" class="dropdown-item waves-effect waves-light model-person" data-id="'.$data->coupon_id.'" data-toggle="modal" data-target="#modal_send"><i class="fa fa-send"></i> ส่งโค้ด > รายบุคคล</a>';
            }elseif($data->status == "Y" && $data->type_coupon == "Everyone"){
                $send_code =  ' <a href="#!" class="dropdown-item waves-effect waves-light model-public" onclick="selectcode('.$data->coupon_id.')" data-id="'.$data->coupon_id.'" data-toggle="modal" data-target="#modal_public"><i class="fa fa-send"></i> ส่งโค้ด > ทุกคน</a>';
            }else{
                $send_code = '';
            }

            if($data->status == "Y"){
                $event = ' <a href="#!" class="dropdown-item waves-effect waves-light" onclick="data_cancel('.$data->coupon_id. ',' ."'$data->code'".')" ><i class="fa fa-times"></i>&nbsp; ยกเลิกใช้งาน</button></a>';
            }else{
                $event = '<a href="#!" class="dropdown-item waves-effect waves-light" onclick="data_confirm('.$data->coupon_id. ',' ."'$data->code'".')" ><i class="fa fa-check"></i>&nbsp;อนุมัติใช้งาน</button></a>';
            }


            return  '<div class="btn-group dropdown-split-inverse">
                        <button type="button" class="btn btn-inverse" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">จัดการ <i class="ti-angle-down"></i></button>
                        <div class="dropdown-menu">
                            '.$send_code.'
                            <a href="#!" class="dropdown-item waves-effect waves-light model-data" data-id="'.$data->coupon_id.'" data-toggle="modal" data-target="#modal_edit"><i class="fa fa-edit"></i> แก้ไข</a>
                            '.$event.'
                        </div>
                    </div>';
        });
        // ===================================================

        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request){
        // dd($request->all());
        $random = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        $randoms = substr(str_shuffle($random), 0, 3);
        $code_randoms = $randoms;

        $markets = MK_MarketName::all();
        $coupon = new Coupon;
        $coupon->type_coupon = $request->type_coupon;
        $coupon->code = 'CODE'.date('myd').$code_randoms; // รหัสคูปอง // code
        $coupon->name = $request->name;
        $coupon->date_start = $request->date_start;
        $coupon->date_end = $request->date_end;
        $coupon->date_booking_start = $request->date_booking_start;
        $coupon->date_booking_end = $request->date_booking_end;
        $coupon->price = $request->price;
        $coupon->type_con = $request->type_con;
        $coupon->amount = $request->amount;
        $coupon->status = "W";
        $coupon->save();
        $marketname = $request->marketname;
        if ( $marketname != null) {
            foreach ($marketname as $key => $value) {
                $coupon_m = new Coupon_Market;
                $coupon_m->marketname_id = $value;
                $coupon_m->coupon_id = $coupon->coupon_id;
                $coupon_m->save();
            }
        }
        $disbut = '';
        if ($coupon->type_coupon == 'Personal') {
            $countc = Coupon_Personal::where('coupon_id',$request->id)->count();
            if ($coupon->amount <= $countc) {
                $disbut = 'disable';
            }
        }
        $coupon->disbut = $disbut;
        $data['disbut'] = $disbut;
        $data['markets'] = $markets;
        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function edit(Request $request){
        $coupon = Coupon::find($request->id);

        $marketnames = MK_MarketName::all();
        $disbut = '';
        if ($coupon->type_coupon == 'Personal') {
            $countc = Coupon_Personal::where('coupon_id',$request->id)->count();
            if ($coupon->amount <= $countc) {
                $disbut = 'disable';
            }
        }
        $coupon->disbut = $disbut;
        // dd( $countc);
        $tbody_rule = '';
        foreach ($marketnames as $key => $marketname) {
            $conutmarket = Coupon_Market::where('coupon_id',$coupon->coupon_id)->where('marketname_id',$marketname->marketname_id)->first();
            // dd($conutmarket);
            $check = '';
            if ($conutmarket != null) {
               $check = 'checked';
            }
            $tbody_rule .= '
            <tr >
            <td>'.$marketname->name_market.'</td>
            <td style="display: flex; justify-content: center;">
                <input type="checkbox" name="marketname[]" '.$check.' id="access{{$adminrule->market}}" class="form-control" value="'.$marketname->marketname_id.'" style="width: 25px; height: 25px; -moz-appearance: none;" >
            </td>
            </tr>
            ';
        }
        $coupon->cmtable = $tbody_rule;
        return Response::json($coupon);
    }

    public function update(Request $request){
        // dd($request->all());
        $coupon = Coupon::find($request->id);
        $coupon->name = $request->name;
        $coupon->date_start = $request->date_start;
        $coupon->date_end = $request->date_end;
        $coupon->date_booking_start = $request->date_booking_start;
        $coupon->date_booking_end = $request->date_booking_end;
        $coupon->amount = $request->amount;
        $coupon->save();

        $adminrule = Coupon_Market::where('coupon_id',$coupon->coupon_id)->delete();
        $marketname = $request->marketname;
        if ( $marketname != null) {
            foreach ($marketname as $key => $value) {
                $coupon_m = new Coupon_Market;
                $coupon_m->marketname_id = $value;
                $coupon_m->coupon_id = $coupon->coupon_id;
                $coupon_m->save();
            }
        }


        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function cancel(Request $request){
        $coupon = Coupon::find($request->id);
        $coupon->status = "N";
        $coupon->save();
        $data['response'] = true;
        $data['title'] = "ยกเลิกใช้งานโค้ดส่วนลดสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function confirm(Request $request){
        $coupon = Coupon::find($request->id);
        $coupon->status = "Y";
        $coupon->save();

        $data['response'] = true;
        $data['title'] = "อนุมัติใช้งานสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function datatable_person(){
        $idcoupon = request('id_coupon');
        $couponsend = Coupon_Personal::where('coupon_id',$idcoupon)->get();
        $sQuery	 = Datatables::of($couponsend)

        // รายชื่อ
        ->editColumn('colum_name',function($data){
            return $data->partners->name_customer;
        })

        // // วันที่
        // ->editColumn('colum_date',function($data){
        //     return $data->date;
        // })

        // // ผู้ทำรายการ
        // ->editColumn('colum_user',function($data){
        //     return $data->user_id;
        // })

        // // สถานะส่ง
        // ->editColumn('colum_status_send',function($data){
        //     if($data->status_send == "W"){
        //         $status = '<font color="red"><p title="ยังไม่ส่งโค้ด"><i class="fa fa-times-circle"></i> ยังไม่ส่งโค้ด</p></font>';
        //     }else{
        //         $status = '<font color="green"><p title="ส่งโค้ดแล้ว"><i class="fa fa-check-circle"></i> ส่งโค้ดแล้ว</p></font>';
        //     }
        //     return $status;
        // })

        // // สถานะใช้งาน
        // ->editColumn('colum_status_use',function($data){
        //     if($data->status_use == "W"){
        //         $status = '<font color="red"><p title="ยังไม่ถูกใช้งาน"><i class="fa fa-times-circle"></i> ยังไม่ถูกใช้งาน</p></font>';
        //     }else{
        //         $status = '<font color="green"><p title="ถูกใช้งานแล้ว"><i class="fa fa-check-circle"></i> ถูกใช้งานแล้ว</p></font>';
        //     }
        //     return $status;
        // })

        // จัดการ
        ->editColumn('colum_manage',function($data){
            // $name = $data->partners->name_customer;
            return '<button type="button" class="btn-primary" onclick="sendcode_person('.$data->coupon_id.','.$data->partners_id.')"><i class="fa fa-send"></i> ส่งโค้ด</button>
                    <button type="button" class="btn-dark" onclick="delete_sendconde('.$data->coupon_id.','.$data->partners_id.')"><i class="fa fa-trash-o"></i> ลบ</button>';
        });

        return $sQuery->escapeColumns([])->make(true);
    }

    public function datatable_public(){
        $partners = Partners::where('status','Y')->get();
        $sQuery	 = Datatables::of($partners);
        return $sQuery->escapeColumns([])->make(true);
    }

    public function delete_sendcode(Request $request){

        $coupon_send = Coupon_Personal::where('coupon_id',$request->id)->where('partners_id',$request->per)->delete();
        // $coupon_send->delete($coupon_send->coupon_id);
        // Coupon_Personal::destroy($coupon_send->coupon_id);
        $coupon = Coupon::find($request->id);
        $disbut = '';
            if ($coupon->type_coupon == 'Personal') {
                $countc = Coupon_Personal::where('coupon_id',$request->id)->count();
                if ($coupon->amount <= $countc) {
                    $disbut = 'disable';
                }
            }
            $coupon->disbut = $disbut;
            // dd($countc,$disbut);
        $data['disbut'] = $disbut;
        $data['response'] = true;
        $data['title'] = "ลบรายชื่อส่งโค้ดสำเร็จ";
        $data['text'] = 'ระบบได้ลบข้อมูลรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function search_partners(Request $request){
        $partners = Partners::where('name_customer','like', '%'.$request->keysearch.'%')->where('status','Y')->limit(2)->get();
        if(!empty($partners)){
            foreach($partners as $value){
                $json[] = array(
                    "id" 	=> $value->partners_id,
                    "label" => $value->name_customer,
                    "value" => $value->name_customer, # value input

                    //
                    "name_customer" => $value->name_customer,
                    "numbertax" => $value->numbertax,
                    "name" => $value->name,
                    "lastname" => $value->lastname,
                    "citizenid" => $value->citizenid,
                    "partners_type" => $value->partners_type,
                    "status_partners" => $value->status_partners,
                    "address" => $value->address,
                    "soi" => $value->soi,
                    "road" => $value->road,
                    "road" => $value->road,
                    "district" => $value->district,
                    "ampure" => $value->ampure,
                    "province" => $value->province,
                    "zipcode" => $value->zipcode,
                    "email" => $value->email,
                    "phone" => $value->phone,
                    "lineid" => $value->lineid,
                    "status_partners" => $value->status_partners,
                    "image_citizen" => $value->image_citizen,
                    "image_kp20" => $value->image_kp20,
                );
            }
            echo json_encode($json);
        }
    }

    public function add_person(Request $request){

        $check = Coupon_Personal::where('coupon_id',$request->couponID)->where('partners_id',$request->partnersID)->count();
        $coupon = Coupon::find($request->couponID);
        if($check == 0){
            $couponsend = new Coupon_Personal;
            $couponsend->coupon_id = $request->couponID;
            $couponsend->partners_id = $request->partnersID;
            // $couponsend->date = date('Y-m-d');
            // $couponsend->user_id = NULL; // Auth ID
            // $couponsend->status_send = "W";
            // $couponsend->status_use = "W";
            $couponsend->save();
            $disbut = '';
            if ($coupon->type_coupon == 'Personal') {
                $countc = Coupon_Personal::where('coupon_id',$request->couponID)->count();
                if ($coupon->amount <= $countc) {
                    $disbut = 'disable';
                }
            }
            $coupon->disbut = $disbut;
            $data['disbut'] = $disbut;
            $data['response'] = true;
            $data['title'] = "เพิ่มรายชื่อส่งโค้ดสำเร็จ";
            $data['text'] = 'ระบบได้บันทึกรียบร้อยแล้ว';
        }else{
            $data['response'] = false;
            $data['title'] = "รายชื่อนี้มีอยู่ในระบบแล้ว";
            $data['text'] = 'กรุณาตรวจสอบและทำรายการใหม่';
        }

        return Response::json($data);
    }
    public function sendcode_person(Request $request){
        $id_code = $request->id_code;
        $id_user = $request->id_user;
        $coupon = Coupon::find($id_code);
        $partners = Partners::find($id_user);
        // dd($coupon);
        $this->sendcode($coupon->code,$partners->token);
        // $couponsend = CouponSend::where('coupon_id',$id_code)->where('partners_id',$id_user)->first();
        // $couponsend->date = date('Y-m-d');
        // $couponsend->status_send = "Y";
        // $couponsend->status_use = "W";
        // $couponsend->save();
        $noti = new NotificationpPartners;
        $noti->title = 'ท่านได้รับส่วนลด';
        $noti->body = 'รหัสส่วนลดของท่าน '.$coupon->code. ' กรุณาใช้ก่อนวันที่' .$coupon->date_end ;
        $noti->key_name = 'CP';
        $noti->partners_id = $id_user;
        $noti->isRead = 'N';
        $noti->create_at = NOW();
        // $noti->updated_at = NOW();
        $noti->save();
        $data['response'] = true;
        $data['title'] = "ส่งโค้ดสำเร็จ";
        $data['text'] = 'ระบบได้ลบข้อมูลรียบร้อยแล้ว';
        return Response::json($data);

    }
    public function sendcode_all(Request $request){
        $id_code = $request->id_code;
        // $id_user = $request->id_user;
        $coupon = Coupon::find($id_code);
        // dd($coupon);
        $partners = Partners::all();
        foreach ($partners as $key => $partner) {
            $token = 'cHn-TFJcTkQYlSyd67onw4:APA91bG7STXU1XT0AzjRcS4iBHb1WpCuF27cI01MvzcnkQCcIUykXu0wPfn0UB1RtV7UNAY73oRFFZHyR-fWsCkguWupLpLPk5h56_4pyxa9CEG7MMLyN-aI5tPbVM1STn11YOw_LhqD';
            $this->sendcode($coupon->code, $token);
        }

        // $couponsend = CouponSend::where('coupon_id',$id_code)->where('partners_id',$id_user)->first();
        // $couponsend->date = date('Y-m-d');
        // $couponsend->status_send = "Y";
        // // $couponsend->status_use = "W";
        // $couponsend->save();

        $data['response'] = true;
        $data['title'] = "ส่งโค้ดสำเร็จ";
        $data['text'] = 'ระบบได้ลบข้อมูลรียบร้อยแล้ว';
        return Response::json($data);

    }
    public function sendcode($idcoupon,$iduser){


        $SERVER_KEY ='AAAAyN9c4TM:APA91bH-_z4nIZjk-sAdM2tGPv44DHYPx5qM8qRs2BaEbPGCPexBNB2wVQo1h77uabyNshG2-E1OfU28sSGPQgx9GVeq5kdbpgrcku8MUFrJ1te4HliYh-Lp5Q4k785LqSgYkrYrw5CM';
        $SEND_URL = 'https://fcm.googleapis.com/fcm/send';
        $token = array($iduser);
        $fields = array(
         'registration_ids' => $token,
         'priority' => 'high',
                  'notification' => array(
                      'title' => 'ส่ง code ส่วนลด',
                      'body' => 'code ส่วนลด'.$idcoupon,
                      'sound'=>'default',
                      'image' => "https://via.placeholder.com/150x250",
                      'click_action' => '',
                  ),
              );

        $headers = array(
         'Authorization: Bearer '.$SERVER_KEY,
         'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $SEND_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);

        if($result === FALSE)
        {
         die('Curl failed:'.curl_error($ch));
        }
        curl_close($ch);
        // print_r($result);

        return Response::json($result);
    }

}
