<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use PDF;
use Yajra\Datatables\Datatables;

class ChecklistController extends Controller
{
    // ตรวจสอบตลาด
    // ===================================================

    // ข้อมูลการตรวจสอบ
    public function checklist(){
        return view('backend/checklist/checklist');
    }

    public function checklist_datatable(){
        $date_start = request('date_start');
        $date_end = request('date_end');
        if(!empty($date_start && $date_end)){
            // Data Mockup
            $data = [
                [
                    "no"=>"1",
                    "number"=>"DFCds15/6/63/0001",
                    "market"=>"SINGHA COMPLEX",
                    "nameapp"=>"ADMIN JJ",
                    "status"=> "S",
                    "amoumt"=>"100",
                    "booth"=>"Booth1",
                    "product"=>"ไก่ทอด",
                    "date"=>"22/6/63",  
                ],[
                    "no"=>"2",
                    "number"=>"DFCds15/6/63/0002",
                    "market"=>"SINGHA COMPLEX",
                    "nameapp"=>"ADMIN JJ",
                    "status"=> "S",
                    "amoumt"=>"100",
                    "booth"=>"Booth2",
                    "product"=>"ไก่ทอด2",
                    "date"=>"22/6/63",  
                ],[
                    "no"=>"3",
                    "number"=>"DFCds15/6/63/0003",
                    "market"=>"SINGHA COMPLEX",
                    "nameapp"=>"ADMIN JJ",
                    "status"=> "S",
                    "amoumt"=>"100",
                    "booth"=>"Booth3",
                    "product"=>"ไก่ทอด3",
                    "date"=>"22/6/63",  
                ]
            ];
        }else{
            $data = [
                [
                    "no"=>"",
                    "number"=>"",
                    "market"=>"",
                    "nameapp"=>"",
                    "status"=> "",
                    "amoumt"=>"",
                    "booth"=>"",
                    "product"=>"",
                    "date"=>"",  
                ]
            ];
        }
        $sQuery	 = Datatables::of($data);
        return $sQuery->escapeColumns([])->make(true);
    }
    // ===================================================

    // รายชื่อผู้ค้างจ่ายค่าปรับ
    public function list_fine(){
        return view('backend/checklist/list_fine');
    }

    public function list_fine_datatable(){
        // Data Mockup
        $data = [
            [
                "no"=>"1",
                "number"=>"DFCds15/6/63/0001",
                "market"=>"SINGHA COMPLEX",
                "nameapp"=>"ADMIN JJ",
                "status"=> "S",
                "amoumt"=>"100",
                "booth"=>"Booth1",
                "product"=>"ขนมปัง , เค้ก ,เบเกอรี่",
            ], [
                "no"=>"2",
                "number"=>"DFCds15/6/63/0002",
                "market"=>"SINGHA COMPLEX",
                "nameapp"=>"ADMIN JJ",
                "status"=> "S",
                "amoumt"=>"100",
                "booth"=>"Booth2",
                "product"=>"บะหมี่ , ยากิโซบะ ,เกี้ยว",
            ], [
                "no"=>"3",
                "number"=>"DFCds15/6/63/0003",
                "market"=>"SINGHA COMPLEX",
                "nameapp"=>"ADMIN JJ",
                "status"=> "S",
                "amoumt"=>"100",
                "booth"=>"Booth3",
                "product"=>"ชุดเด็ก",
            ], [
                "no"=>"4",
                "number"=>"DFCds15/6/63/0004",
                "market"=>"SINGHA COMPLEX",
                "nameapp"=>"ADMIN JJ",
                "status"=> "S",
                "amoumt"=>"100",
                "booth"=>"Booth4",
                "product"=>"กุ่ยช่าย ขนมจีบ ฯลฯ",
            ]
        ];
        $sQuery	 = Datatables::of($data);
        return $sQuery->escapeColumns([])->make(true);
    }
    // ===================================================

    // รายชื่อผู้จ่ายค่าปรับแบบโอน
    public function list_transfer(){
        return view('backend/checklist/list_transfer');
    }

    public function list_transfer_datatable(){
        // Data Mockup
        $data = [
            [
                "no"=>"1",
                "number"=>"DFCds15/6/63/0001",
                "market"=>"SINGHA COMPLEX",
                "nameapp"=>"ADMIN JJ",
                "status"=> "S",
                "amoumt"=>"100",
                "booth"=>"Booth1",
                "product"=>"ขนมปัง , เค้ก ,เบเกอรี่",
            ], [
                "no"=>"2",
                "number"=>"DFCds15/6/63/0002",
                "market"=>"SINGHA COMPLEX",
                "nameapp"=>"ADMIN JJ",
                "status"=> "S",
                "amoumt"=>"100",
                "booth"=>"Booth1",
                "product"=>"บะหมี่ , ยากิโซบะ ,เกี้ยว",
            ], [
                "no"=>"3",
                "number"=>"DFCds15/6/63/0003",
                "market"=>"SINGHA COMPLEX",
                "nameapp"=>"ADMIN JJ",
                "status"=> "S",
                "amoumt"=>"100",
                "booth"=>"Booth1",
                "product"=>"ชุดเด็ก",
            ], [
                "no"=>"4",
                "number"=>"DFCds15/6/63/0004",
                "market"=>"SINGHA COMPLEX",
                "nameapp"=>"ADMIN JJ",
                "status"=> "S",
                "amoumt"=>"100",
                "booth"=>"Booth1",
                "product"=>"กุ่ยช่าย ขนมจีบ ฯลฯ",
            ]
        ];
        $sQuery	 = Datatables::of($data);
        return $sQuery->escapeColumns([])->make(true);
    }
    // ===================================================

    // รายการสินค้าชำรุด
    public function list_wornout(){
        return view('backend/checklist/list_wornout');
    }

    public function list_wornout_datatable(){
        $date_start = request('date_start');
        $date_end = request('date_end');
        if(!empty($date_start && $date_end)){
            // Data Mockup
            $data = [
                [
                    "no"=>"1",
                    "number"=>"DFCds15/6/63/0001",
                    "market"=>"SINGHA COMPLEX",
                    "nameapp"=>"ADMIN JJ",
                    "status"=> "S",
                    "amoumt"=>"100",
                    "image"=> "<img src='".asset('public/assets/backend/img/wait_img.png')."' style='height:150px; width:150px;'>",
                    "booth"=>"Booth1",
                    "product"=>"ไก่ทอด",
                    "date"=>"22/6/63",  
                ],[
                    "no"=>"2",
                    "number"=>"DFCds15/6/63/0002",
                    "market"=>"SINGHA COMPLEX",
                    "nameapp"=>"ADMIN JJ",
                    "status"=> "S",
                    "amoumt"=>"100",
                    "image"=> "<img src='".asset('public/assets/backend/img/wait_img.png')."' style='height:150px; width:150px;'>",
                    "booth"=>"Booth2",
                    "product"=>"ไก่ทอด2",
                    "date"=>"22/6/63",  
                ],[
                    "no"=>"3",
                    "number"=>"DFCds15/6/63/0003",
                    "market"=>"SINGHA COMPLEX",
                    "nameapp"=>"ADMIN JJ",
                    "status"=> "S",
                    "amoumt"=>"100",
                    "image"=> "<img src='".asset('public/assets/backend/img/wait_img.png')."' style='height:150px; width:150px;'>",
                    "booth"=>"Booth3",
                    "product"=>"ไก่ทอด3",
                    "date"=>"22/6/63",  
                ]
            ];
        }else{
            $data = [
                [
                    "no"=>"",
                    "number"=>"",
                    "market"=>"",
                    "nameapp"=>"",
                    "status"=> "",
                    "amoumt"=>"",
                    "image"=>"",
                    "booth"=>"",
                    "product"=>"",
                    "date"=>"",  
                ]
            ];
        }
        $sQuery	 = Datatables::of($data);
        return $sQuery->escapeColumns([])->make(true);
    }
    // ===================================================

}
