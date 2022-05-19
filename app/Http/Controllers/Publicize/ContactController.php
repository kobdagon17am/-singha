<?php

namespace App\Http\Controllers\Publicize;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Default
use Session;
use Response;
use Auth;
use Image;
use Yajra\Datatables\Datatables;

use App\Model\Contact;

class ContactController extends Controller
{
    // Contact
    // ===================================================
    
    public function contactus(){
        return view('backend/publicize/contactus');
    }

    public function datatable(){
        $contact = Contact::all();
        $sQuery	 = Datatables::of($contact)

        // หัวข้อ
        ->editColumn('colum_title',function($data){
            return $data->title;
        })
        // ชื่อผู้ติดต่อ
        ->editColumn('colum_name',function($data){
            return $data->name;
        })
        // เบอร์
        ->editColumn('colum_phone',function($data){
            return $data->phone;
        })
        // เมล
        ->editColumn('colum_email',function($data){
            return $data->email;
        })
        // ข้อความ
        ->editColumn('colum_message',function($data){
            return $data->message;
        })

        // จัดการ
        ->editColumn('colum_manage',function($data){
            return '<button type="button" class="btn-dark" onclick="datadelete('.$data->contact_id.')"><i class="fa fa-trash-o"></i> ลบ</button>';
        });

        return $sQuery->escapeColumns([])->make(true);
    }

    public function add(Request $request){
        $contact = new Contact;
        $contact->title = $request->title;
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->status = "Y";
        $contact->save();

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }


    public function delete(Request $request){
        $contact = Contact::find($request->id);
        $contact->delete();

        $data['response'] = true;
        $data['title'] = "ลบข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว'; 
        return Response::json($data);
    }
}
