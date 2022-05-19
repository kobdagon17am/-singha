<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


use Auth;
use Response;
use Yajra\Datatables\Datatables;
use App\Model\Admin;
use App\Model\AdminRule;
use App\Model\StatusMenu;
use App\Model\MK_MarketName;

class AdminController extends Controller
{
    // จัดการผู้ใช้งานเข้าระบบ
    // ===================================================

    public function admin(){
        $menu = StatusMenu::all();
        $adminrules = AdminRule::all();

        $data = array(
            'adminrules' => $adminrules,
            'menu' => $menu,
        );
        return view('backend/admin/admin',$data);
    }

    public function admin_create(){
        $menu = StatusMenu::all();
        $markets = MK_MarketName::all();
        $data = array(
            'menu' => $menu,
            'markets' => $markets,
        );
        return view('backend/admin/admin_create',$data);
    }

    public function datatable(Request $request){
        $admin    = Admin::all();

        $date_status = request('status_val');
        if($date_status == 'ADMIN'){
            $admin = Admin::where('role_mobile','ADMIN')->get();
        }elseif($date_status == 'AUDIT'){
            $admin = Admin::where('role_mobile','AUDIT')->get();
        }else{
            $admin = Admin::all();
        }

        $sQuery	 = Datatables::of($admin)

        ->editColumn('colum_username',function($data){
            return $data->username;
        })

        ->editColumn('colum_type',function($data){
            return $data->username;
        })

        // สถานะ
        ->editColumn('colum_status',function($data){
            if($data->status == "Y"){
                $status = '<font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>
                        <a href="#!" onclick="update_status('.$data->id. ',' ."'$data->name'".')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>';
            }else{
                $status = '<font color="red"><p title="ยกเลิก"><i class="fa fa-times-circle"></i> ยกเลิก</p></font>
                        <a href="#!" onclick="update_status('.$data->id. ',' ."'$data->name'".')"><font color="blue"><u>แก้ไขสถานะ</u></font></a>';
            }
            return $status;
        })

        // จัดการ
        ->editColumn('colum_manage',function($data){

            if($data->status == "Y"){
                $statusAD = '<a href="#!" class="dropdown-item waves-effect waves-light" onclick="update_status('.$data->id. ',' ."'$data->name'".')" ><i class="fa fa-times"></i>&nbsp;&nbsp;ยกเลิกใช้งาน</button></a>';
            }else{
                $statusAD = '<a href="#!" class="dropdown-item waves-effect waves-light" onclick="update_status('.$data->id. ',' ."'$data->name'".')" ><i class="fa fa-check"></i>&nbsp;&nbsp;เปิดใช้งาน</button></a>';
            }

            return  '<div class="btn-group dropdown-split-inverse">
                        <button type="button" class="btn btn-inverse" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">จัดการ <i class="ti-angle-down"></i></button>
                        <div class="dropdown-menu">
                            <a href="#!" class="dropdown-item waves-effect waves-light model-data" data-id="'.$data->id.'" data-toggle="modal" data-target="#modal_edit"><i class="fa fa-edit"></i> แก้ไข</a>
                            <a href="#!" class="dropdown-item waves-effect waves-light model-dataP" data-id="'.$data->id.'" data-toggle="modal" data-target="#modal_editP"><i class="fa fa-edit"></i> สิทธิ์การเข้าถึง</a>
                        </div>
                    </div>';
        });

        return $sQuery->escapeColumns([])->make(true);
    }

    public function store(Request $request){

		$dataaccess = $request->access;
		$access_encode = json_encode($dataaccess);

        $check = Admin::where('username',$request->username)->count();
        if($check == 0){
            $admin = new Admin;
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->tel = $request->tel;
            $admin->line = $request->line;
            $admin->username = $request->username;
            $admin->role_mobile = $request->role_mobile;
            $admin->password = Hash::make($request->password);
            $admin->status = "Y";
            $admin->status_admin = $access_encode;
            $admin->save();

            $adminrule = AdminRule::where('admin_id',$request->id_admin)->delete();
            if ($request->marketname != null) {
                foreach ($request->marketname as $key => $value) {
                    # code...
                    $newadminrule = new AdminRule;
                    $newadminrule->admin_id = $admin->id;
                    $newadminrule->marketname_id = $value;
                    $newadminrule->save();
                }
            }

            // dd($request->all());
            $data['response'] = true;
            $data['title'] = "เพิ่มสมาชิกใช้งานสำเร็จ";
            $data['text'] = "กลับไปดูหน้ารายการทั้งหมด";
            return Response::json($data);

        }else{

            $data['response'] = false;
            $data['title'] = "username นี้มีอยู่ในระบบแล้ว";
            $data['text'] = "กรุณาทำรายการใส่ username อื่น";
            return Response::json($data);
        }
    }

    public function edit(Request $request){
        $admin = Admin::find($request->id);
        $marketnames = MK_MarketName::all();
        $tbody_rule = '';

        foreach ($marketnames as $key => $marketname) {
            $conutmarket = AdminRule::where('marketname_id',$marketname->marketname_id)->where('admin_id',$request->id)->first();
            // dd($conutmarket);
            $check = '';
            if ($conutmarket != null) {
               $check = 'checked';
            }
            $tbody_rule .= '
            <tr class="text-center" >
            <td>'.$marketname->name_market.'</td>
            <td style="display: flex; justify-content: center;">
                <input type="checkbox" name="marketname[]" '.$check.' id="access{{$adminrule->market}}" class="form-control" value="'.$marketname->marketname_id.'" style="width: 25px; height: 25px; -moz-appearance: none;" >
            </td>
            </tr>
            ';
        }
        $data = array(
            'admin' => $admin,
            'tbody_rule' => $tbody_rule,

        );
        return $data;
    }

    public function update(Request $request){

        $admin = Admin::find($request->id);
        $admin->name = $request->name;
        $admin->tel = $request->tel;
        $admin->line = $request->line;
        $admin->email = $request->email;
        $admin->role_mobile = $request->role_mobile;
        // $admin->password = Hash::make($request->password);
        $admin->password = !empty($request->password) ? Hash::make($request->password) : $admin->password;
        $admin->save();

        $data['response'] = true;
        $data['title'] = "แก้ไขสมาชิกใช้งานสำเร็จ";
        $data['text'] = "กลับไปดูหน้ารายการทั้งหมด";
        return Response::json($data);
    }

    public function status(Request $request){
        $admin = Admin::find($request->id);
        if($admin->status == "Y"){
            $admin->status = "N";
            $admin->save();
            $data['response']=true;
            $data['title']="ระงับการใช้งานสำเร็จ";
            $data['text']='กลับไปดูหน้ารายการทั้งหมด';
        }else{
            $admin->status = "Y";
            $admin->save();
            $data['response']=true;
            $data['title']="เปิดใช้งานสำเร็จ";
            $data['text']='กลับไปดูหน้ารายการทั้งหมด';
        }

        return Response::json($data);
    }

    public function permission(Request $request){

        // premission > json
        // dd($request->All());
        $access = $request->access;
        $access_ec = json_encode($access);

        $admin = Admin::find($request->id_admin);
        $admin->status_admin = $access_ec;
        $admin->save();

        $adminrule = AdminRule::where('admin_id',$request->id_admin)->delete();

        foreach ($request->marketname as $key => $value) {
            # code...
            $newadminrule = new AdminRule;
            $newadminrule->admin_id = $request->id_admin;
            $newadminrule->marketname_id = $value;
            $newadminrule->save();
        }
        $data['response'] = true;
        $data['title'] = "แก้ไขสิทธิ์การเข้าถึงสำเร็จ";
        $data['text'] = "กลับไปดูหน้ารายการทั้งหมด";
        return Response::json($data);
    }


}
