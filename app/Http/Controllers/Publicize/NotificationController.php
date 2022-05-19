<?php

namespace App\Http\Controllers\Publicize;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Default
use Response;
use Auth;
use Yajra\Datatables\Datatables;

// Model
use App\Model\Notification;
use App\Model\Partners;

class NotificationController extends Controller
{
    // notification
    // ===================================================

    public function notification(){
        return view('backend/publicize/notification');
    }

    public function datatable(){
        // Query Status
        $date_status = request('status_val');
        if($date_status == 'T'){
            $noti = Notification::all();
        }elseif($date_status == 'Y'){
            $noti = Notification::where('status','Y')->get();
        }elseif($date_status == 'N'){
            $noti = Notification::where('status','N')->get();
        }else{
            $noti = Notification::all();
        }
        $sQuery	 = Datatables::of($noti)
        // ===================================================


        // หัวข้อ
        ->editColumn('colum_title',function($data){
            return $data->title;
        })

        // ข้อความ
        ->editColumn('colum_message',function($data){
            return $data->message;
        })

        // ผู้ทำราย
        ->editColumn('colum_user_id',function($data){
            return $data->user->name;
        })

        // วัน/เวลา
        ->editColumn('colum_created_at',function($data){
            return $data->created_at;
        })

        // สถานะ
        ->editColumn('colum_status',function($data){
            if($data->status == "Y"){
                $status_t = '<font color="red"><p title="ยังไม่ส่งข้อความ"><i class="fa fa-times-circle"></i> ยังไม่ส่งข้อความ</p></font>';
            }else{
                $status_t = '<font color="green"><p title="ส่งข้อความแล้ว"><i class="fa fa-check-circle"></i> ส่งข้อความแล้ว</p></font>';
            }

            return $status_t;
        })

        // จัดการ
        ->editColumn('colum_manage',function($data){
            if($data->status == "Y"){
                $status = '<button type="button" class="btn-dark" onclick="status('.$data->notification_id. ',' ."'$data->title'".')"><i class="fa fa-send"></i> ส่งข้อความ</button>';
            }else{
                $status = '<button type="button" style="background-color: #848181;" class="btn-dark" disabled><i class="fa fa-send"></i> ส่งข้อความ</button>';
            }

            return '<button type="button" class="btn-dark model-data" data-id='.$data->notification_id.' data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-edit"></i> แก้ไข</button>&nbsp;
                    '.$status.'';
        });

        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request){
        $noti = new Notification;
        $noti->title = $request->title;
        $noti->message = $request->message;
        $noti->status = "Y";
        $noti->user_id = $request->userid;
        $noti->save();

        $data['response'] = true;
        $data['title'] = "เพิ่มไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function edit(Request $request){
        $noti = Notification::find($request->id);
        return Response::json($noti);
    }

    public function update(Request $request){
        $noti = Notification::find($request->id);
        $noti->title = $request->title;
        $noti->message = $request->message;
        $noti->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }

    public function status(Request $request){
        $partners = Partners::all();
        $noti = Notification::find($request->id);
        foreach ($partners as $key => $partner) {
            # code...
            $this->send_notification( $partner->token,$noti);
        }

        $noti->status = "N";
        $noti->save();
        $data['response'] = true;
        $data['title'] = "ส่งข้อความสำเร็จ";
        $data['text'] = 'ระบบได้สงข้อความเรียบร้อยแล้ว';

        return Response::json($data);
    }
    function send_notification($userToken,$data)
    {
     $SERVER_KEY ='AAAAyN9c4TM:APA91bH-_z4nIZjk-sAdM2tGPv44DHYPx5qM8qRs2BaEbPGCPexBNB2wVQo1h77uabyNshG2-E1OfU28sSGPQgx9GVeq5kdbpgrcku8MUFrJ1te4HliYh-Lp5Q4k785LqSgYkrYrw5CM';
     $SEND_URL = 'https://fcm.googleapis.com/fcm/send';
     $token = array($userToken);
     $fields = array(
      'registration_ids' => $token,
      'priority' => 'high',
               'notification' => array(
                   'title' => $data->title,
                   'body' => $data->message,
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
     print_r($result);
    }

}
