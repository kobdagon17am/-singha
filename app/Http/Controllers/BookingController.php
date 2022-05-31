<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Default
use Response;
use Auth;
use Image;
use Yajra\Datatables\Datatables;
use Session;
use DB;
use DateTime;
use File;
// Model
use App\Model\Booking;
use App\Model\Booking_Detail;
use App\Model\Booking_Accessories;
use App\Model\MK_Floor;
use App\Model\MK_Zone;
use App\Model\MK_Booth;
use App\Model\MK_BoothDetail;
use App\Model\MK_MarketName;
use App\Model\MK_Service;
use App\Model\Partners;
use App\Model\PartnersProduct;
use App\Model\Transaction;
use App\Model\Transaction_Detail;
use App\Model\PartnersCharge;

use Maatwebsite\Excel\Facades\Excel;
use App\Bookimport;

class BookingController extends Controller
{
    // จัดการการจอง
    // ===================================================
    // public function index(){
    //     // $boothdetail = MK_BoothDetail::where('booth_id',2)->get();
    //     // foreach ($boothdetail as $key => $value) {
    //     //     $value->price = (($value->price)+200);
    //     //     $value->save();
    //     // }
    //     dd("booking");
    //     $marketnames = MK_MarketName::all();
    //     $booth = MK_Booth::all();
    //     $services = MK_Service::all();
    //     $data = array(
    //         'marketnames' => $marketnames,
    //         'services' => $services,
    //         'booth' => $booth,
    //     );
    //     return view('backend/booking',$data);
    // }
    public function booking_regular()
    {
        // $boothdetail = MK_BoothDetail::where('booth_id',2)->get();
        // foreach ($boothdetail as $key => $value) {
        //     $value->price = (($value->price)+200);
        //     $value->save();
        // }
        // dd($boothdetail);
        $marketnames = MK_MarketName::all();
        $booth = MK_Booth::all();
        $services = MK_Service::all();
        $data = array(
            'marketnames' => $marketnames,
            'services' => $services,
            'booth' => $booth,
        );
        return view('backend/booking/booking_regular', $data);
    }

    public function booking_event()
    {
        $marketnames = MK_MarketName::all();
        $services = MK_Service::all();
        $data = array(
            'marketnames' => $marketnames,
            'services' => $services,
        );
        return view('backend/booking/booking_event', $data);
    }

    public function booking_oraganize()
    {
        $marketnames = MK_MarketName::all();
        $services = MK_Service::all();
        $data = array(
            'marketnames' => $marketnames,
            'services' => $services,
        );
        return view('backend/booking/booking_oraganize', $data);
    }
    public function index()
    {
        // dd("index");
        // $status_admin = Auth::user()->status_admin;
        $status_admin = Auth::user()->status_admin;
        $marketnames = MK_MarketName::all();
        $booth = MK_Booth::all();

        $data = array(
            'marketnames' => $marketnames,
            'booth' => $booth,

            'status_admin' => json_decode($status_admin),
        );
        // dd( $data);
        return view('backend/booking/selectmarket', $data);
    }
    public function show($id)
    {
        //
        // dd($id);
        $marketnames = MK_MarketName::all();
        $booth = MK_Booth::all();
        $services = MK_Service::where('status', 'Y')->get();
        $boothstandby = MK_Booth::wherein('status', ['W'])->get();
        $data = array(
            'marketnames' => $marketnames,
            'services' => $services,
            'booth' => $booth,
            'boothstandby' => $boothstandby,
            'id' => $id,
        );
        // dd($data);
        return view('backend/booking/booking', $data);

        // return $foodtype;
    }
    public function datatable_market(Request $request)
    {

        // dd($request->all);
        $adminrule = Auth::user()->adminrule;
        foreach ($adminrule as $key => $value) {
            $arr[] = $value->marketname_id;
        }

        $data = MK_MarketName::whereIn('marketname_id', $arr)->orderBy('name_market', 'ASC')->get();
        // dd($data);

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('booking_id', function ($data) {
                $data = $data->booking_id;
                // dd($data);
                return $data;
            })
            ->addColumn('market', function ($data) {

                if ($data->market != null) {
                    $data = $data->market->name_market;
                } else {
                    $data = "ทดสอบ";
                }
                return $data;
            })
            ->addColumn('manage', function ($data) {
                $url = url('/backoffice/booking/' . $data->marketname_id);
                return '<a href="' . $url . '" class="btn btn-inverse btn-round btn-sm "><i class="fa fa-search"></i> ดูข้อมูลการจอง </a>
            ';
            })
            ->rawColumns(['manage', 'market', 'partners', 'booking_id', 'booking_status'])
            ->make(true);
    }
    public function datatable_regular(Request $request)
    {

        // dd($request->marketname_id);
        $marketname_id = $request->marketname_id;
        // $key = "SN01-202008-00001";
        // $data = Booking::find($key);
        $data = Booking::orderBy('updated_at', 'ASC')->where('marketname_id', $marketname_id)->get();
        // dd($data);

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('booking_id', function ($data) {
                $data = $data->booking_id;
                // dd($data);
                return $data;
            })
            ->addColumn('market', function ($data) {

                if ($data->market != null) {
                    $data = $data->market->name_market;
                } else {
                    $data = "ทดสอบ";
                }
                return $data;
            })
            ->addColumn('booking_status', function ($data) {
                // $data = $data->status->booking_status_name;
                $status = $data->booking_status_id;
                $value = $data->status->booking_status_name;
                if ($status == 2) {
                    # code...
                    $value = ' รอชำระเงิน <br> <br>
                 <button type="button" class="btn btn-inverse btn-round btn-sm " onclick="confirmbook(\'' . $data->booking_id . '\')"  ><i class="fa fa-check-circle"></i> ยืนยันการจอง</button>

                 ';
                }
                // $data = "2";


                return $value;
            })
            ->addColumn('partners', function ($data) {
                if ($data->partners == null) {

                    $data = "ชื่อทดสอบ";
                } else {
                    if ($data->partners->name_customer == "1001") {
                        $data =  Partners::first();
                    }
                    $data = $data->partners->name_customer;
                }


                return $data;
            })
            ->addColumn('type_customer', function ($data) {

                $type_customer = "ลูกค้าทั่วไป";
                if ($data->booking_type == "Regular") {
                    $type_customer = "ลูกค้าประจำ";
                }


                return $type_customer;
            })
            ->addColumn('created_at', function ($data) {

                // if($data->partners->name_customer == "1001"){
                //     $data =  Partners::first();
                // }
                $data = date('d-m-Y', strtotime($data->created_at));
                return $data;
            })
            ->addColumn('manage', function ($data) {
                $status = $data->booking_status_id;
                $valuenoti = '';
                if ($status == 2) {
                    # code...
                    $valuenoti = ' <br> <br> <button type="button" class="btn btn-inverse btn-round btn-sm" onclick="sentnotification(\'' . $data->partners_id . '\')"  ><i class="fa fa-bell"></i> ส่ง notification เรียกเก็บ</button>

                 ';
                }
                $valuecacel = '<button type="button" class="btn btn-inverse btn-round btn-sm" onclick="cancle(\'' . $data->booking_id . '\')"  ><i class="fa fa-times-circle"></i> ยกเลิกการจอง</button>';
                if ($status == 2 || $status == 3) {
                    # code...
                    $valuecacel = '';
                }
                $data = '
            ' . $status . '
            <button type="button" class="btn btn-inverse btn-round btn-sm" onclick="show(\'' . $data->booking_id . '\')"  ><i class="fa fa-edit"></i> ข้อมูลการจอง</button>
            ' . $valuecacel . '
            ' . $valuenoti . '

            ';
                return $data;
            })
            ->rawColumns(['manage', 'market', 'partners', 'booking_id', 'booking_status'])
            ->make(true);
    }
    public function datatable_booking(Request $request)
    {

        // dd($request->all());
        // $key = "SN01-202008-00001";
        // $data = Booking::find($key);
        // $date_start = new DateTime($request->datesearch_start);
        // $date_end = new DateTime($request->datesearch_end);
        $marketname_id = $request->marketname_id;
        $status = $request->status_booking;
        $date_start = $request->datesearch_start;
        // dd(date("Y", strtotime($date_start)));
        $data = Booking::where('marketname_id', $marketname_id)->where('booking_status_id', $status)
            ->whereHas('bookdetail', function ($query)  use ($date_start) {
                $query->whereYear('booking_detail_date', date("Y", strtotime($date_start)))->whereMonth('booking_detail_date', date("n", strtotime($date_start)));
                // ->whereDate('booking_detail_date', '<=', $date_end);
            })->orderBy('updated_at', 'ASC')
            // ->limit(10)->get();
            ->get();
        // dd($data);

        // foreach ($data as $keyout => $booking) {
        //     $bookdetail = $booking->bookdetail;
        //     $htmlname = '';
        //     $htmldate = '';
        //     if ($bookdetail != null) {
        //         foreach ($bookdetail as $key => $value) {
        //             if ($value->booth_detail_id != 0) {
        //                 $boothdetail = $value->boothdetail;
        //                 $htmlname .= $boothdetail->name.'<br>';
        //                 $htmldate .= date('d-m-Y',strtotime($value->booking_detail_date)).'<br>';
        //             }else {
        //                 $htmlname .= 'ทดสอบบูธเรียกเก็บ';
        //                 $htmldate .= 'ทดสอบบูธเรียกเก็บ';
        //             }
        //         }
        //     }
        //     $booking->htmlname = $htmlname;
        //     $booking->htmldate = $htmldate;
        // }
        // dd( $data[0]);
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('booking_id', function ($data) {
                $data = $data->booking_id;
                // dd($data);
                return $data;
            })
            // ->addColumn('market', function ($data) {

            //     if ($data->market != null) {
            //         $data = $data->market->name_market;
            //     }else{
            //         $data ="ทดสอบ";
            //     }
            //      return $data;
            // })
            ->addColumn('boothdetail', function ($data) {
                // $html = $data->htmlname;
                $html = '';
                $bookdetail = $data->bookdetail;
                if ($bookdetail != null) {
                    // $html .= $data->bookdetail;
                    foreach ($bookdetail as $key => $value) {
                        if ($value->booth_detail_id != 0) {
                            $html .= $value->boothdetail->name . '<br>';
                        } else {
                            $html .= 'บูธเรียกเก็บพิเศษ';
                        }
                    }
                }

                return $html;
            })
            ->addColumn('datebooking', function ($data) {
                // $html = $data->htmldate;
                $html = '';
                $bookdetail = $data->bookdetail;
                if ($bookdetail  != null) {
                    foreach ($bookdetail  as $key => $value) {
                        $html .= date('d-m-Y', strtotime($value->booking_detail_date)) . '<br>';
                    }
                }
                return $html;
            })

            ->addColumn('booking_status', function ($data) {
                // $data = $data->status->booking_status_name;
                $status = $data->booking_status_id;
                $value = $data->status->booking_status_name;
                if ($status == 2) {
                    # code...
                    $value = ' รอชำระเงิน <br> <br>
                 <button type="button" class="btn btn-inverse btn-round btn-sm " onclick="confirmbook(\'' . $data->booking_id . '\')"  ><i class="fa fa-check-circle"></i> ยืนยันการจอง</button>

                 ';
                }
                // $data = "2";


                return $value;
            })
            ->addColumn('partners', function ($data) {
                if ($data->partners == null) {

                    $data = "ชื่อทดสอบ";
                } else {
                    if ($data->partners->name_customer == "1001") {
                        $data =  Partners::first();
                    }
                    $data = $data->partners->name_customer;
                }


                return $data;
            })
            ->addColumn('type_customer', function ($data) {

                $type_customer = "ลูกค้าทั่วไป";
                if ($data->booking_type == "Regular") {
                    $type_customer = "ลูกค้าประจำ";
                }


                return $type_customer;
            })
            ->addColumn('discount_all', function ($data) {

                $discount_all = 0;
                if ($data->booking_coupon != null) {
                    $discount_all = $data->booking_coupon;
                }


                return $discount_all;
            })
            ->addColumn('created_at', function ($data) {

                // if($data->partners->name_customer == "1001"){
                //     $data =  Partners::first();
                // }
                $data = date('d-m-Y', strtotime($data->created_at));
                return $data;
            })
            ->addColumn('manage', function ($data) {
                $status = $data->booking_status_id;
                $valuenoti = '';
                if ($status == 2) {
                    # code...
                    $valuenoti = ' <br> <br> <button type="button" class="btn btn-inverse btn-round btn-sm" onclick="sentnotification(\'' . $data->partners_id . '\')"  ><i class="fa fa-bell"></i> ส่ง notification เรียกเก็บ</button>

                 ';
                }
                $valuecacel = '';
                if ($status == 2 || $status == 3) {
                    # code...
                    $valuecacel = '<button type="button" class="btn btn-inverse btn-round btn-sm" onclick="cancle(\'' . $data->booking_id . '\')"  ><i class="fa fa-times-circle"></i> ยกเลิกการจอง</button>';
                }
                $data = '
            <button type="button" class="btn btn-inverse btn-round btn-sm" onclick="show(\'' . $data->booking_id . '\')"  ><i class="fa fa-edit"></i> ข้อมูลการจอง</button>
            ' . $valuecacel . '
            ' . $valuenoti . '

            ';
                return $data;
            })
            ->rawColumns(['manage', 'market', 'partners', 'booking_id', 'booking_status', 'boothdetail', 'datebooking'])
            // dd($data);
            ->make(true);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // $at_id = $request->at_id;

        // dd( $arr);
        $boothdetail = MK_BoothDetail::find($request->booth_detail_id);
        $marketname = MK_MarketName::find($request->marketname_id);
        // dd($boothdetail);
        // $lastbooking = Booking::whereHas('market', function ($query)  use ($marketname) {
        //     $query->Where('prefix_code',$marketname->prefix_code);
        //     // ->where('',1);
        // })->get()->last();
        // $lastrunnumberbooking = 0;
        // if ($lastbooking != null) {
        //     $lastrunnumberbooking = substr($lastbooking->booking_id, 12, 5);
        // }

        // $date = date('Y').date('m');
        // // dd($lastrunnumberbooking,$marketname->prefix_code);
        // $newrunnumberbooking = sprintf("%05d", $lastrunnumberbooking+1);
        // $newbooking_ido = $marketname->prefix_code.'-'.$date.'-'.$newrunnumberbooking;


        $newbooking_id = $this->GenerateBookingID($request->marketname_id);

        // dd($newbooking_id);

        // $partner = Partners::where('name',$request->partners_name)->first();
        $partner = Partners::find($request->partners_id);

        $booking_detail = new Booking_Detail;
        $booking_detail->booking_id = $newbooking_id;
        $booking_detail->booth_detail_id = $request->booth_detail_id;
        $booking_detail->booking_detail_date = $request->bd_booking_date;
        $booking_detail->partners_id = $partner->partners_id;
        $booking_detail->price = $boothdetail->price;
        $booking_detail->save();

        $arrat = array_filter($request->qty, 'strlen');
        $totalsumpriceacc = 0;
        foreach ($arrat as $key => $value) {
            $service = MK_Service::find($key);
            $price = 0;
            $price = $service->price;
            $sumpriceacc = $price * $value;
            $bookingaccessories = new Booking_Accessories;
            $bookingaccessories->booking_detail_id = $booking_detail->booking_detail_id;
            $bookingaccessories->service_id = $service->service_id;
            $bookingaccessories->unit_price = $sumpriceacc;
            $bookingaccessories->booking_accessory_qty = $value;
            $bookingaccessories->updated_at = now();
            $bookingaccessories->save();
            $totalsumpriceacc += $sumpriceacc;
        }
        $booking_grand_total =  $boothdetail->price + $totalsumpriceacc;
        $booking = new Booking;
        $booking->booking_id = $newbooking_id;
        $booking->marketname_id =  $request->marketname_id;
        $booking->partners_id = $partner->partners_id;
        $booking->booking_status_id = 2;
        $booking->booking_total = $boothdetail->price;
        $booking->booking_service_total = $totalsumpriceacc;
        $booking->booking_grand_total = $booking_grand_total;
        $booking->timeout_date = $request->date_timeout;
        $booking->booking_type = "ADMIN";
        $booking->notification_date = $request->date_noti;
        $booking->save();

        $data['booking'] = $booking;
        $data['booking_detail'] = $booking_detail;
        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
        // return response()->json([
        //     'status' => "pass",
        //     'data' => $booking,
        // ]);

    }
    function GenerateBookingID($marketname_id, $run = 0)
    {
        $BookingID = "";
        $Status = false;
        // $sqlCheck = "select * from booking where marketname_id = ?";
        // $stmtCheck = $this->db->query($sqlCheck,array($marketname_id));
        // $Check = $stmtCheck->num_rows();
        $Check = Booking::where('marketname_id', $marketname_id)->first();

        $sql = "";
        if ($Check == null) {
            $stmt = "SELECT CONCAT(prefix_code,'-',SUBSTRING(year(NOW()),1,4) ,LPAD(month(NOW()),2,'0'),'-','00001') as Running FROM mk_marketname where marketname_id = $marketname_id";
        } else {
            $stmt = DB::select(DB::raw("SELECT
        CASE
            WHEN SUBSTRING(max(b.booking_id), 6, 6) = CONCAT(SUBSTRING(year(NOW()),1,4),LPAD(month(NOW()),2,'0'))
            THEN CONCAT(k.prefix_code,'-',SUBSTRING(year(NOW()),1,4) ,LPAD(month(NOW()),2,'0'),'-',LPAD(CONVERT(SUBSTRING(max(b.booking_id) , 13, 5),UNSIGNED INTEGER) + 1 + $run,5,'0'))
            ELSE CONCAT(k.prefix_code,'-',SUBSTRING(year(NOW()),1,4) ,LPAD(month(NOW()),2,'0'),'-','00001')
        END as Running
        FROM booking b
        LEFT JOIN mk_marketname k on b.marketname_id = k.marketname_id
        where b.marketname_id = '$marketname_id' and CONVERT(k.prefix_code,CHAR) = CONVERT(SUBSTRING(b.booking_id,1,4),CHAR)"));
        }
        // dd($stmt[0]->Running);
        if ($stmt != "") {
            $BookingID = $stmt[0]->Running;
            $Status = true;
        }
        return $BookingID;
        // return (object) [
        //     "BookingID" => $BookingID,
        //     "Status"    => $Status
        // ];
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function databooking(Request $request)
    {
        //
        // dd($request->all());
        $booking_id = $request->keepId;
        $booking = Booking::find($booking_id);
        $bookdetail = $booking->bookdetail;
        // dd($bookdetail);
        if ($bookdetail[0]->booth_detail_id == 0) {
            $trdetail =  '';
            foreach ($bookdetail as $key => $value) {
                $trdetail .=  '<tr>
                    <td>' . $value->bookingaccessories[0]->service->name . '</td>
                    <td>' . $value->bookingaccessories[0]->unit_price . '</td>


                </tr>';

                $htmltable = ' <table id="datatables" class="table  table-bordered" width="100%">
                <thead>
                    <tr>

                        <th class="text-center">บริการ</th>
                        <th class="text-center">ราคา</th>

                    </tr>
                </thead>

                <tbody id="trdetail" align="center">

                    ' . $trdetail . '

                </tbody>
            </table>';
            }
        } else {
            $trdetail =  '';
            foreach ($bookdetail as $key => $value) {
                $trdetail .=  '<tr>
                    <td>' . $value->boothdetail->booth->market->name_market . '</td>
                    <td>' . $value->boothdetail->name . '</td>
                    <td>' . $value->booking_detail_date . '</td>
                    <td>' . $value->boothdetail->price . '</td>
                </tr>';

                $htmltable = ' <table id="datatables" class="table  table-bordered" width="100%">
                <thead>
                    <tr>

                        <th class="text-center">ตลาด</th>
                        <th class="text-center">ชื่อบูธ</th>
                        <th class="text-center">วันที่จอง</th>
                        <th class="text-center">ราคา</th>
                    </tr>
                </thead>

                <tbody id="trdetail" align="center">

                    ' . $trdetail . '

                </tbody>
            </table>';
            }
        }

        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        $data['booking'] = $booking;
        $data['htmltable'] = $htmltable;
        return Response::json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        dd($id);
        return view('backend/booking/booking_edit');
        // return $event;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // dd($request->all());
        $event = Event::find($id);

        $event->title_event = $request->title_event;
        $event->id_event_category_f = $request->id_event_category;
        $event->date_start = formatsdate($request->date_start);
        $event->time_start = $request->time_start;
        $event->date_end = formatsdate($request->date_end);
        $event->time_end = $request->time_end;
        $event->location = $request->location;

        $event->save();
        dd($event, $id);
        return response()->json([
            'status' => "pass",
            'data' => $event,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        // dd($id);
        // dd($request);
        $booking = Booking::find($id);
        $booking->booking_status_id = "5";
        $booking->cancel_detail = $request->why;
        $booking->save();
        $data['response'] = true;
        $data['title'] = "ยกเลิกใช้งานสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        return Response::json($data);
    }
    public function checkbooking($booth, $date, $status)
    {
        // dd($booth,$date,$status);

        $findbook =  Booking_Detail::where('booking_detail_date', $date)
            ->where('booth_detail_id', $booth)
            ->whereHas('booking', function ($query)  use ($booth, $status) {
                // $query->orWhere('booking_status_id',2)->orWhere('booking_status_id',3);

                if ($status == "all") {
                    $query->orWhere('booking_status_id', 2)->orWhere('booking_status_id', 3);
                } else if ($status == "2") {
                    $query->Where('booking_status_id', 2);
                } else {
                    // dd($status);
                    $query->Where('booking_status_id', 3);
                }

                // ->where('',1);
            })
            ->first();
        // dd($findbook);
        return $findbook;
    }
    public function selectmarket(Request $request)
    {

        // dd($request->all());
        $marketname_id = $request->select_market;

        $floors =  MK_Floor::where('marketname_id', $marketname_id)->get();
        $zones =  MK_Zone::where('marketname_id', $marketname_id)->get();
        $booths =  MK_Booth::where('marketname_id', $marketname_id)->get();

        $booth_id = $request->select_booth;
        // $floor_id = $request->select_floor;
        $zone_id = $request->select_zone;
        $date_booking = $request->date_booking;
        $date_search = new DateTime($date_booking);
        // dd($date_search);
        if ($booth_id != "") {
            $htmlbooth = '';
        } else {
            $htmlbooth = '<option value="">กรุณาเลือกโมเดล</option>';
        }
        foreach ($booths as $key => $booth) {
            $select = '';
            if ($booth_id == $booth->booth_id) {
                $select = 'selected="selected"';
            }
            $htmlbooth .= '<option value="' . $booth->booth_id . '" ' . $select . '>' . $booth->name . '</option>';
        }

        // if ( $zone_id != "" ) {
        //     $htmlzone = '';
        // }else{
        //     $htmlzone = '<option value="">กรุณาเลือกโซน</option>';
        // }
        $htmlzone = '<option value="">กรุณาเลือกโซน</option>';
        foreach ($zones as $key => $zone) {
            $htmlzone .= '<option value="' . $zone->zone_id . '">' . $zone->name . '</option>';
        }

        $htmlbooth_detail = '';

        if ($booth_id != ""  && $zone_id != "" && $date_booking != null) {
            # code...
            $booth_details =  MK_BoothDetail::where('booth_id', $booth_id)->where('zone_id', $zone_id)->get();
            // dd($booth_details);
            foreach ($booth_details as $key => $booth_detail) {
                // dd( $date_search,$booth_detail->booth_detail_id );

                $findbook =  Booking_Detail::where('booking_detail_date', $date_search)
                    ->where('booth_detail_id', $booth_detail->booth_detail_id)
                    ->whereHas('booking', function ($query)  use ($booth_detail) {
                        $query->Where('booking_status_id', 2)->orWhere('booking_status_id', 3);
                    })
                    ->first();
                // dd( $findbook);
                $keepidall[$key] = $booth_detail->booth_detail_id;
                $colorb = "btn-primary";
                $disabled = '';
                if ($findbook != null) {
                    # code...
                    $keepid[$key] = $findbook->booking->booking_status_id;
                    if ($findbook->booking->booking_status_id == "3") {
                        $colorb = "btn-danger";
                        $disabled = 'disableda';
                    } else if ($findbook->booking->booking_status_id == "2") {
                        $colorb = "btn-warning";
                        $disabled = 'disableda';
                    }
                }


                $htmlbooth_detail .= ' <a href="#" onclick="selectbooth(' . $booth_detail->booth_detail_id . ')" id="bt_' . $booth_detail->booth_detail_id . '"  style="margin-bottom:15px;margin-right:5px" class="' . $disabled . ' btnbook ' . $colorb . '  btnlock btn btn-out-dashed  btn-square waves-effect md-trigger booth-data"   >' . $booth_detail->name . '</a>';
            }
        }
        // dd($keepidall);
        $data = array(
            'marketname_id' => $marketname_id,
            'htmlzone' => $htmlzone,
            'htmlbooth' => $htmlbooth,
            'htmlbooth_detail' => $htmlbooth_detail,
            'booth_id' => $booth_id,
            'zone_id' => $zone_id,
        );

        // dd($data);
        return $data;
    }
    public function searchuser(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = Partners::where('name_customer', 'LIKE', "%{$query}%")
                // ->where('name_customer', 'LIKE', "%{$query}%")
                ->get();
            //   $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            //   foreach($data as $row)
            //   {
            //    $output .= '
            //    <li><a href="#">'.$row->name_customer.'</a></li>
            //    ';
            //   }
            //   $output .= '</ul>';
            //   echo $output;
            return response()->json($data);
        }
    }
    function notification(Request $request)
    {
        $keepid = $request->keepId;
        // dd( $keepid);
        $partner = Partners::find($keepid);
        $this->send_notification($partner->token);
    }
    function notification_overdue()
    {

        // $bookings = Booking::where('booking_status_id',2)->where('booking_type',"Regular")->with('partners')->get()->groupBy('partners_id');

        $partners = Partners::join('booking', 'partners.partners_id', '=', 'booking.partners_id')
            ->where('booking.booking_status_id', 2)
            ->where('booking.booking_type', "Regular")
            ->where('partners.token', '!=', "")
            ->select('partners.token')
            ->groupBy('partners.token')
            ->get();
        // dd($partners);

        // $partners = $bookings->partners()->groupBy('partners_id')->get();
        // dd($partners);
        foreach ($partners as $key => $partner) {
            # code...
            // dd($booking[0]);
            // $token[] = $partner['token'];
            $this->send_notification($partner->token);
        }
        // $result = array_filter($token);
        // dd($result);

        // $this->send_notification($token);



    }
    public function sentfines()
    {
        $userToken = 'cuhEMYqWSkeQ0w4WJEx4Ge:APA91bGihNa3KoE6uTEl3RCKEGJO-P91wvLQeao-5zBLKTPNtAxgmlPZ3oBYsrACh4L6CKFe-PXUE70_h2PlWzfcLIs8QOPexdSBIt1P9kbFjFoFSkE3W-z-RR6tCZUCCJx8z85yPA8X';
        $this->send_notification_sentfines($userToken);
        dd("ss");
    }
    function send_notification_sentfines($userToken)
    {
        $SERVER_KEY = 'AAAAyN9c4TM:APA91bH-_z4nIZjk-sAdM2tGPv44DHYPx5qM8qRs2BaEbPGCPexBNB2wVQo1h77uabyNshG2-E1OfU28sSGPQgx9GVeq5kdbpgrcku8MUFrJ1te4HliYh-Lp5Q4k785LqSgYkrYrw5CM';
        $SEND_URL = 'https://fcm.googleapis.com/fcm/send';
        $token = array($userToken);
        $fields = array(
            'registration_ids' => $token,
            'priority' => 'high',
            'notification' => array(
                'title' => 'เรียกเก็บค่าบูธเพิ่มเติม',
                'body' => 'เรียกเก็บค่าบูธเพิ่มเติม 400 บาท  จากบูธ C7 กรุณาเช็คที่ตะกร้าสินค้าบนแอพของท่าน ',
                'sound' => 'default',
                'image' => "https://via.placeholder.com/150x250",
                'click_action' => '',
            ),
        );

        $headers = array(
            'Authorization: Bearer ' . $SERVER_KEY,
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

        if ($result === FALSE) {
            die('Curl failed:' . curl_error($ch));
        }
        curl_close($ch);
        print_r($result);
    }
    function send_notification($userToken)
    {
        $SERVER_KEY = 'AAAAyN9c4TM:APA91bH-_z4nIZjk-sAdM2tGPv44DHYPx5qM8qRs2BaEbPGCPexBNB2wVQo1h77uabyNshG2-E1OfU28sSGPQgx9GVeq5kdbpgrcku8MUFrJ1te4HliYh-Lp5Q4k785LqSgYkrYrw5CM';
        $SEND_URL = 'https://fcm.googleapis.com/fcm/send';
        $token = array($userToken);
        $fields = array(
            'registration_ids' => $token,
            'priority' => 'high',
            'notification' => array(
                'title' => 'เรียกเก็บค่าบูธประจำ',
                'body' => 'เรียกเก็บค่าบูธประจำ กรุณาเช็คที่ตะกร้าสินค้าบนแอพของท่าน ',
                'sound' => 'default',
                'image' => "https://via.placeholder.com/150x250",
                'click_action' => '',
            ),
        );

        $headers = array(
            'Authorization: Bearer ' . $SERVER_KEY,
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

        if ($result === FALSE) {
            die('Curl failed:' . curl_error($ch));
        }
        curl_close($ch);
        print_r($result);
    }
    public function fileImportExport()
    {
        return view('booking.booking_event');
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function fileImport(Request $request)
    {
        // dd($request->all());
        $status = $request->status;
        $path = $request->file('confirmbook')->getRealPath();
        // // $data = Excel::load($path, function ($reader) {})->get();
        // // dd($path);
        $arrayLine = (new Bookimport)->toArray($request->file('confirmbook'));
        // dd($arrayLine[0]);
        $databookings_arr = array_slice(array_slice($arrayLine[0], 1), 0);
        // array_slice($databookings, 1);
        // // dd($databookings);
        // unset($databookings[0]);
        // dd($databookings);
        // unset($databookings[0]);
        // $x = "B19";
        // $y = "Sun Plaza 2";
        // $bootderail = MK_BoothDetail::all();
        // foreach ($bootderail as $key => $value) {
        //     $out = array_filter($arrayLine[0], function($arr) use($x,$y) {
        //         if (in_array($x, $arr) && in_array($y, $arr)) {
        //            return in_array($x, $arr);
        //         }
        //     });
        // }
        // dd($out);
        // array_slice($databookings, 2 ,1);
        // array_filter($databookings);
        // array_diff($databookings, array(NULL));
        $databookings = array_filter($databookings_arr,  function ($databooking) {
            // dd($s);
            foreach ($databooking as $key => $booking) {
                # code...
                return ($booking !== null && $booking !== false && $booking !== '');
            }
        });
        // dd($array);
        // dd($databookings);
        $booking_arr = [];
        $booking_detail_arr = [];
        $runnumber = 0;
        foreach ($databookings as $keyall => $databooking) {


            $marketname_arr = $databooking[0];
            $boothname_arr = $databooking[1];

            $marketname = MK_MarketName::find($request->market_id);

            $boothname = MK_BoothDetail::where('name', $boothname_arr)->where('booth_id', $request->booth_id)
                ->whereHas('booth', function ($query)  use ($marketname) {
                    $query->where('marketname_id', $marketname->marketname_id);
                })->first();


            // unset($databooking[0]);
            // unset($databooking[1]);
            // ตัด array ไป array ที่เริ่มและตัด array ไป array ที่สิ้นสุด
            $bookingbooth_arr = array_slice($databooking, 2, 32);
            $bookingbooth = array_filter($bookingbooth_arr,  function ($booking) {
                # code...
                return ($booking !== null && $booking !== false && $booking !== '');
            });
            // dd($bookingbooth);
            $check = [];

            foreach ($bookingbooth as $keyin => $value) {

                $day = $keyin + 1;
                $datapartner = Partners::where('username', $value)->first();
                $partners_id = "10001";

                if ($datapartner != null) {
                    $partners_id = $datapartner->partners_id;
                }
                //     $databookinglog[] = array(

                //       'datapartner' =>  $datapartner ,
                //       'day' =>  $day ,
                //       );
                // dd($marketname,$boothname,$boothname_arr);
                if ($value != null) {

                    // $lastbooking = DB::table('booking')->get()->last();
                    // $lastrunnumberbooking = 0;
                    // if ($lastbooking != null) {
                    //     $lastrunnumberbooking = substr($lastbooking->booking_id, 12, 5);
                    // }

                    // $date = date('Y').date('m');
                    // // dd($date);
                    // $newrunnumberbooking = sprintf("%05d", $lastrunnumberbooking+1);
                    // $newbooking_id = $mktype.'-'.$date.'-'.$newrunnumberbooking;

                    $boothname_price = 0;

                    if ($boothname != null) {
                        # code...
                        $boothname_price = $boothname->price;
                    }
                    if ($status == "insert") {
                        # code...

                        $newbooking_id = $this->GenerateBookingID($marketname->marketname_id, $runnumber);
                        $runnumber++;
                        // dd($newbooking_id);
                        $booking_arr[] = [

                            'booking_id' => $newbooking_id,
                            'marketname_id' => $marketname->marketname_id,
                            'partners_id' =>  $partners_id,
                            'booking_status_id' => 2,
                            'booking_total' => $boothname->price,
                            'booking_service_total' => 0,
                            'booking_type' => 'Regular',
                            'booking_grand_total' => $boothname->price,
                            'timeout_date' => $request->date_timeout,
                            'created_at' => NOW(),
                            'updated_at' => NOW(),

                        ];
                        // $lastestbooking = DB::table('booking')->get()->last();
                        // dd($request->month_import);
                        $datebooth_arr = date("Y-m", strtotime($request->month_import)) . "-" . $day;
                        // dd($datebooth_arr);
                        $datebooth = date("Y-m-d", strtotime($datebooth_arr));
                        $booking_detail_arr[] =
                            [
                                'booking_id' => $newbooking_id,
                                'booth_detail_id' => $boothname->booth_detail_id,
                                'partners_id' => $partners_id,
                                'booking_detail_date' =>  $datebooth,
                                'created_at' => NOW(),
                                'updated_at' => NOW(),
                            ];
                    }
                    // $booking = new Booking;
                    // $booking->booking_id = $newbooking_id;
                    // $booking->marketname_id = $marketname->marketname_id; //ไอดีตลาด
                    // $booking->partners_id = $partners_id;
                    // $booking->booking_status_id = 2;
                    // $booking->booking_total = $boothname_price;
                    // $booking->booking_service_total = 0;
                    // $booking->booking_grand_total = $boothname_price;
                    // $booking->booking_type = "Regular";
                    // $booking->timeout_date = date("Y-m-d",strtotime('2021-01-31'));
                    // $booking->save();
                    // $bookingdetail = new Booking_Detail;
                    // $bookingdetail->booking_id = $booking->booking_id;
                    // $bookingdetail->booth_detail_id = $boothname->booth_detail_id;
                    // $bookingdetail->partners_id = $partners_id;
                    // $bookingdetail->booking_detail_date = $datebooth;
                    // $bookingdetail->save();
                    $check[$day] =  $datapartner;
                }
            }
            // dd($databookinglog);
            $databookingall[$boothname->name] = $check;
        }
        // dd($booking_arr);
        if ($status == "insert") {
            # code...
            DB::table('booking')->insert($booking_arr);
            DB::table('booking_detail')->insert($booking_detail_arr);
            $result = "success";

            return back();
        }
        // dd($runnumber,$booking_arr,$booking_detail_arr);
        // dd($databookingall['A1']);
        $html = '';
        if ($status == "checkexcel") {
            # code...

            $htmlbody = '';
            foreach ($databookingall as $key => $value) {

                $thday = array("อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์");
                // dd($value);
                if (!$value) {
                    $partner = "ไม่มีคนจอง ";
                    $type = "ไม่มีคนจอง ";
                    $cat = "ไม่มีคนจอง ";
                    $product = "ไม่มีคนจอง ";
                    $dayofweek = "ไม่มีคนจอง ";
                    $dayfull = "ไม่มีคนจอง ";
                    $style = '';
                } else {
                    $bookparner = '';
                    $typeparner = '';
                    $catparner = '';
                    $productparner = '';
                    $dayofweekbook = '';
                    $daybooking = '';
                    foreach ($value as $keybook => $item) {
                        $style = 'style="color:red;  font-weight: bold;"';
                        $nameparner = 'ไม่พบ Username ';
                        $productbook = PartnersProduct::where('partners_id', $item['partners_id'])->first();

                        $productparner_w = 'ไม่พบ Username ';
                        $catparner_w = 'ไม่พบ Username ';
                        $typeparner_w = 'ไม่พบ Username ';
                        if ($item != null) {
                            $nameparner = $item['name_customer'];
                            $style = '';
                        }
                        if ($productbook != null) {
                            $productparner_w =  $productbook->product->name;
                            $catparner_w =  $productbook->product->category->name;
                            $typeparner_w =  $productbook->product->type->name;
                        }

                        $productparner .=  '<p ' . $style . ' class="import-td">' . $productparner_w . '</p>';
                        $catparner .=  '<p ' . $style . ' class="import-td">' . $catparner_w . '</p>';
                        $typeparner .=  '<p ' . $style . ' class="import-td">' . $typeparner_w . '</p>';



                        $bookparner .= '<p ' . $style . ' class="import-td">' . $nameparner . '</p>';


                        // $day = '';
                        $day = ($keybook . "-" . date("m-Y", strtotime($request->month_import)));
                        $daybooking .= $day . '<br>';


                        $dayfw = date("w", strtotime($day));
                        $dayofweekbook .= $thday[$dayfw] . '<br>';
                    }

                    $dayofweek = $dayofweekbook;
                    $dayfull = $daybooking;
                    $partner = $bookparner;
                    $type = $typeparner;
                    $cat = $catparner;
                    $product = $productparner;
                }
                $htmlbody .= '
            <tr>
                <td >' . $key . '</td>
                <td>' . $dayofweek . '</td>
                <td >' . $dayfull . '</td>
                <td >' . $partner . '</td>
                <td >' . $type . '</td>
                <td >' . $cat . '</td>
                <td >' . $product . '</td>
            </tr>
            ';
            }


            $html = '
            <table id="datatables" class="table  table-bordered" width="100%" >
            <thead>
                <tr>
                    <th class="text-center">ชื่อบูธ</th>
                    <th class="text-center">วันในสัปดาห์</th>
                    <th class="text-center">วันที่จอง</th>
                    <th class="text-center">ชื่อผู้จอง</th>
                    <th class="text-center">ประเภท</th>
                    <th class="text-center">หมวดหมู่สินค้า</th>
                    <th class="text-center">ชื่อสินค้า</th>
                </tr>
            </thead>
            <tbody align="left">
                ' . $htmlbody . '
            <tbody>
        </table>
            ';
            $result = "check";
        }
        $data = array(
            'databookingall' => $databookingall,
            'booking_arr' => $booking_arr,
            'booking_detail_arr' => $booking_detail_arr,
            'html' => $html,
            'result' => $result,
        );
        return $data;
    }
    public function fileImportmore(Request $request)
    {
        // dd($request->all());
        $arrayLine = (new Bookimport)->toArray($request->file('confirmbook'));
        $databookings_arr = array_slice(array_slice($arrayLine[0], 1), 0);
        // dd($databookings);
        $databookings = array_filter($databookings_arr,  function ($booking) {
            # code...

            return ($booking[0] !== null || $booking[1] !== null || $booking[2] !== null);
        });
        // dd($databookings);
        $status = $request->status;
        $marketname_id = $request->market_id;


        foreach ($databookings as $key => $value) {
            $partners_username = $value[0];
            $service_id = $value[1];
            $qty =  $value[2];
            $pricemore =  $value[3];
            $partners = Partners::where('username', $partners_username)->first();
            $partners_id = '22000';
            if ($partners != null) {
                $partners_id = $partners->partners_id;
            }
            $service = null;
            if ($service_id != 0) {
                $service = MK_Service::find($service_id);
            }

            $priceacc = 0;
            $vat = 'N';
            $spaceid = '-';
            if ($service != null) {
                $priceacc =  $service->price;
                $vat = $service->vat;
                $spaceid = $service->service_space_id;
            }
            $sumpriceacc = ($priceacc * $qty);
            $sumprice = ($sumpriceacc + $pricemore);
            $value_arr = 1;
            $databookingall[] = [$partners, $service, $sumprice, $priceacc, $vat, $spaceid, $qty, $pricemore];
            // $service = MK_Service::find($value_arr);
            $newbooking_id = $this->GenerateBookingID($marketname_id);
            if ($status == "insert") {
                # code...
                $timeout_date = (new DateTime(date('Y/m/d', strtotime("+30 days"))));
                $booking = new Booking;
                $booking->booking_id = $newbooking_id;
                $booking->marketname_id = $marketname_id; //ไอดีตลาด
                $booking->partners_id = $partners_id;
                $booking->booking_status_id = 2;
                $booking->booking_total = $pricemore;
                $booking->booking_service_total = $sumpriceacc;
                $booking->booking_grand_total =  $sumprice;
                $booking->booking_type = "Regular";
                $booking->timeout_date = $timeout_date;
                $booking->save();

                $bookingdetail = new Booking_Detail;
                $bookingdetail->booking_id = $booking->booking_id;
                $bookingdetail->booth_detail_id = 0;
                $bookingdetail->partners_id = $partners_id;
                $bookingdetail->booking_detail_date = now();
                $bookingdetail->save();

                // dd($bookingdetail);
                if ($service_id != 0) {

                    $bookingaccessories = new Booking_Accessories;
                    $bookingaccessories->booking_detail_id = $bookingdetail->booking_detail_id;
                    $bookingaccessories->service_id = $service->service_id;
                    $bookingaccessories->unit_price = $sumpriceacc;
                    $bookingaccessories->booking_accessory_qty = $qty;
                    $bookingaccessories->updated_at = now();
                    $bookingaccessories->save();
                }
            }
        }
        if ($status == "insert") {
            return back();
        }
        // dd( $databookingall);
        $htmlbody = '';
        $html = '';
        if ($status == "checkexcelmore") {
            # code...

            foreach ($databookingall as $key => $value) {
                # code...
                $namepartner = 'ไม่พบ Username';
                $style = 'style="color:red;  font-weight: bold;"';
                if ($value[0] != null) {
                    $namepartner = $value[0]->name_customer;
                    $style = '';
                }
                $nameser = 'ไม่พบข้อมูล';
                if ($value[1] != null) {
                    $nameser = $value[1]->name;
                }
                if ($value[3] == 'Y') {
                    $vavat = 'มี vat';
                } else {
                    $vavat = 'ไม่มี vat';
                }
                $htmlbody .= '
            <tr>
                <td ' . $style . '> ' . $namepartner . '</td>
                <td> ' . $nameser . '</td>
                <td align="right"> ' . $value[7] . '</td>
                <td align="right"> ' . $value[3] . '</td>
                <td align="right"> ' . $value[6] . '</td>
                <td align="right"> ' . $value[2] . '</td>

                <td>' . $vavat . '</td>

                <td>' . $value[5] . '</td>

            </tr>
            ';
            }

            $html = '
            <table class="table  table-bordered" width="100%" >
            <thead>
                <tr>
                    <th class="text-center">ชื่อลูกค้า</th>
                    <th class="text-center">บริการ</th>
                    <th class="text-center">ราคาเรียกเก็บพิเศษ</th>
                    <th class="text-center">ราคาบริการเสริม</th>
                    <th class="text-center">จำนวน</th>
                    <th class="text-center">ราคารวม</th>
                    <th class="text-center">ภาษี</th>
                    <th class="text-center">รหัส SPACE</th>
                </tr>
            </thead>
            ' . $htmlbody . '
            </table>
        ';

            $result = "check";
        }
        //   dd($html);
        $data = array(
            'databookingall' => $databookingall,
            'html' => $html,
            'result' => $result,
        );
        return $data;
        // dd($databookings);
    }
    public function fileImportDiscount(Request $request)
    {
        $arrayLine = (new Bookimport)->toArray($request->file('confirmbook'));
        $databookings_arr = array_slice(array_slice($arrayLine[0], 1), 0);

        $databookings = array_filter($databookings_arr,  function ($booking) {
            # code...

            return ($booking[0] !== null || $booking[1] !== null || $booking[2] !== null);
        });
        $status = $request->status;
        $marketname_id = $request->market_id;
        $arrDate = explode('-', $request->date);
        $year = $arrDate[0];
        $month = $arrDate[1];
        $htmlbody = '';
        $html = '';
        foreach ($databookings as $key => $value) {
            $partners_username = $value[0];
            $discountall = $value[1];

            $partners = Partners::where('username', $partners_username)->first();

            $partners_id = '22000';
            if ($partners != null) {
                $partners_id = $partners->partners_id;
            }
            $bookingAll = Booking_Detail::join('booking', 'booking_detail.booking_id', 'booking.booking_id')
                ->select('booking_detail.partners_id', 'booking_detail.booking_detail_date', 'booking_detail.booth_detail_id', 'booking.booking_type', 'booking.booking_status_id', 'booking.booking_id')
                ->where('booking_status_id', '=', '2')
                ->where('booking_type', '=', 'Regular')
                ->where('booking_detail.partners_id', $partners_id)
                ->where('booking_detail.booth_detail_id', '!=', 0)
                ->whereYear('booking_detail_date', '=', $year)
                ->whereMonth('booking_detail_date', '=', $month)
                ->orderBy('booking_detail_date', 'asc')
                ->get();
            // dd($bookingAll);

            if ($status == "insert") {
                if (count($bookingAll) != 0) {
                    $arrBookingId = [];
                    foreach ($bookingAll as $vInBookingDetail) {
                        if (!in_array($vInBookingDetail->booking_id, $arrBookingId)) {
                            array_push($arrBookingId, $vInBookingDetail->booking_id);
                        }
                    }

                    $countBooking = count($arrBookingId);
                    if ($countBooking != 0) {
                        $discount = number_format($discountall / $countBooking, 2);
                        $diff = $discountall - (floatval($discount) * $countBooking);
                        foreach ($arrBookingId as $keyInsertDiscount => $booking_id) {
                            if ($keyInsertDiscount + 1 == $countBooking) {
                                $booking = Booking::find($booking_id);
                                $booking->booking_coupon = floatval($discount) + $diff;
                                $booking->save();
                            } else {
                                $booking = Booking::find($booking_id);
                                $booking->booking_coupon = $discount;
                                $booking->save();
                            }
                        }
                    }
                }
            }
            if ($status == "checkexcel") {
                $namepartner = 'ไม่พบ Username';
                $style = 'style="color:red;  font-weight: bold;"';
                if ($partners != null) {
                    $namepartner = $partners->name_customer;
                    $style = '';
                }

                $date_booking = 'ไม่พบข้อมูลการจอง';

                if (count($bookingAll) != 0) {
                    $discountUser = number_format($discountall / count($bookingAll), 2);
                    $diff = $discountall - (floatval($discountUser) * count($bookingAll));
                    foreach ($bookingAll as $kBooking => $vBoooking) {
                        $date_booking = $vBoooking->booking_detail_date;
                        if ($kBooking == 0) {
                            $htmlbody .= '
                                    <tr>
                                        <td ' . $style . '> ' . $namepartner . '</td>
                                        <td> ' . $date_booking . '</td>
                                        <td class="text-center" style="vertical-align: middle;"
                                        rowspan="' . count($bookingAll) . '"> '
                                . ((floatval($discountUser) * count($bookingAll)) + $diff)
                                . '</td>
                                    </tr>
                                    ';
                        } else {
                            $htmlbody .= '
                                    <tr>
                                        <td ' . $style . '> ' . $namepartner . '</td>
                                        <td> ' . $date_booking . '</td>
                                    </tr>
                                    ';
                        }
                    }
                } else {
                    $htmlbody .= '
                                <tr>
                                    <td ' . $style . '> ' . $namepartner . '</td>
                                    <td> ' . $date_booking . '</td>
                                    <td> ' . $discountall . '</td>
                                </tr>';
                }
            }
        }
        if ($status == "insert") {
            return back();
        }

        if ($status == "checkexcel") {
            $html = '
                        <table class="table  table-bordered" width="100%" >
                        <thead>
                            <tr>
                                <th class="text-center">ชื่อลูกค้า</th>
                                <th class="text-center">วันที่จอง</th>
                                <th class="text-center">ส่วนลด</th>
                            </tr>
                        </thead>
                        ' . $htmlbody . '
                        </table>
                    ';
            $result = "check";
        }
        // dd( $databookingall);
        // dd($html);
        $data = array(
            //   'databookingall' => $databookingall,
            'html' => $html,
            'result' => $result,
        );
        return $data;
        // dd($databookings);
    }

    public function submitconfirmbook(Request $request)
    {
        // kp20
        $pathKP = "storage/uploadfile/confirmbook/";
        if (!empty($request->file('confirmbook'))) {
            $image  = $request->file('confirmbook');
            $type = explode('.', $image->getClientOriginalName());
            $size = sizeof($type);
            $new_img = $image->getClientOriginalName();
            $imge_KP = date('dmYHis') . 'KP.' . $type[$size - 1];
            $image_resize = Image::make($image->getRealPath());
            $image_resize->save($pathKP . $imge_KP);

            $oldpic = 'storage/uploadfile/confirmbook/' . $request->image_KP;
            if (is_file($oldpic)) {
                unlink($oldpic);
            }
        } else {
            $imge_KP = $request->image_KP;
        }
        $url_image = asset('storage/uploadfile/confirmbook/' . $imge_KP);

        $lastbooking = DB::table('transaction_master')->get()->last();
        $lastrunnumberbooking = 0;
        if ($lastbooking != null) {
            $lastrunnumberbooking = substr($lastbooking->trans_id, 5, 9);
        }
        // dd($lastrunnumberbooking);
        $date = date('y') . date('m');

        $newrunnumberbooking = sprintf("%09d", $lastrunnumberbooking + 1);
        $newbooking_id = 'T' . $date . $newrunnumberbooking;
        // dd($newbooking_id);
        $booking = Booking::find($request->booking_id);
        $booking->booking_status_id = "3";
        $booking->save();

        //  dd($booking);
        $findtd = Transaction_Detail::where('booking_id', $booking->booking_id)->count();
        // dd($findtd);
        // if ($findtd == 0) {
        # code...

        $transaction = new Transaction;
        $transaction->trans_id = $newbooking_id;
        $transaction->channel = "Admin";
        $transaction->card_name = "card_name";
        $transaction->card_number = "card_number";
        $transaction->card_month = "11";
        $transaction->card_year = "11";
        $transaction->card_cvc = "111";
        $transaction->amount = $booking->booking_grand_total;
        $transaction->date_create = now();
        $transaction->date_modify = now();
        $transaction->partners_id = $booking->partners_id;
        $transaction->status = "Y";
        $transaction->slip_url = $url_image;
        $transaction->save();

        $transactiondetail = new Transaction_Detail;
        $transactiondetail->CartType = "Admin";
        $transactiondetail->trans_id = $newbooking_id;
        $transactiondetail->booking_id = $booking->booking_id;
        $transactiondetail->date_create = now();
        $transactiondetail->date_modify = now();
        $transactiondetail->partners_id = $booking->partners_id;
        $transactiondetail->save();

        // }
        // =====================================


        $data['response'] = true;
        $data['title'] = "เพิ่มข้อมูลสำเร็จ";
        $data['text'] = 'ระบบได้บันทึกข้อมูลเรียบร้อยแล้ว';
        $data['booking'] = $booking;
        // $data['trdetail'] = $trdetail;
        return Response::json($data);
        //    return view('booking.booking_event');
    }
    public function exporttext()
    {

        //dd( asset('public/upload/'));
        // app()->call('App\Http\Controllers\BookingController@exporttext');
        // dd("55");
        // $bookings = Booking::limit(1)->get();
        // $bookings = Booking::all();
        $today = (new DateTime(date('Y/m/d') . '20:00:30'));
        $yesterday = (new DateTime(date('Y/m/d', strtotime("-1 days")) . '20:00:30'));
        $date_set = date('d/m/Y');
        // $today = (new DateTime(date('Y/m/d', strtotime("-1 days")) . '20:00:30'));
        // $yesterday = (new DateTime(date('Y/m/d',strtotime("-2 days")).'20:00:30'));
        //dd($yesterday,$today);


        $bookingsre = Booking::where('booking_status_id', 3)
            ->where('booking_type', 'Regular')
            ->whereHas('bookdetail', function ($query) use ($today, $yesterday) {
                // $query->whereDate('booking_payment_date',date("Y/m/d"));
                $query->where('booking_payment_date', '>=', $yesterday)->where('booking_payment_date', '<=', $today);
                // $query->whereDate('booking_payment_date',date("Y-m-d", strtotime('2021-06-7')));
                // ->whereDate('booking_detail_date', '<=', $date_end);
            })->whereHas('market', function ($query) {

                // $query->whereDate('booking_payment_date',date("Y/m/d"))->where('booth_detail_id', '!=',0);
                $query->where('prefix_code', '!=', 'PZE1')->where('prefix_code', '!=', 'PZE2');
                // ->whereDate('booking_detail_date', '<=', $date_end);
            })->get();
        // ->limit('15')

        $bookingsuser = Booking::where('booking_status_id', 3)
            ->where("booking_type", "!=", "Regular")
            ->whereHas('bookdetail', function ($query) use ($today, $yesterday) {
                // $query->whereDate('booking_payment_date',date("Y/m/d"));
                // $query->whereDate('booking_payment_date',date("Y/m/d"))->where('booth_detail_id', '!=',0);
                $query->where('booking_payment_date', '>=', $yesterday)->where('booking_payment_date', '<=', $today)->where('booth_detail_id', '!=', 0);
                // $query->whereDate('booking_payment_date',date("Y-m-d", strtotime('2021-06-7')))->where('booth_detail_id', '!=',0);
                // ->whereDate('booking_detail_date', '<=', $date_end);
            })->whereHas('market', function ($query) {

                // $query->whereDate('booking_payment_date',date("Y/m/d"))->where('booth_detail_id', '!=',0);
                $query->where('prefix_code', '!=', 'PZE1')->where('prefix_code', '!=', 'PZE2');
                // ->whereDate('booking_detail_date', '<=', $date_end);
            })->get();

        $bookingEvents = Booking::where('booking_status_id', 3)
            ->where("booking_type", "!=", "Regular")
            ->whereHas('bookdetail', function ($query) use ($today, $yesterday) {
                // $query->whereDate('booking_payment_date',date("Y/m/d"));
                // $query->whereDate('booking_payment_date',date("Y/m/d"))->where('booth_detail_id', '!=',0);
                $query->where('booking_payment_date', '>=', $yesterday)->where('booking_payment_date', '<=', $today)->where('booth_detail_id', '!=', 0);
                // $query->whereDate('booking_payment_date',date("Y-m-d", strtotime('2021-06-7')))->where('booth_detail_id', '!=',0);
                // ->whereDate('booking_detail_date', '<=', $date_end);
            })->whereHas('market', function ($query) {

                // $query->whereDate('booking_payment_date',date("Y/m/d"))->where('booth_detail_id', '!=',0);
                $query->where('prefix_code', '=', 'PZE1')->orWhere('prefix_code', '=', 'PZE2');
                // ->whereDate('booking_detail_date', '<=', $date_end);
            })->get();
        // ->whereHas('market', function ($query){

        //     // $query->whereDate('booking_payment_date',date("Y/m/d"))->where('booth_detail_id', '!=',0);
        //     $query->where('prefix_code','!=','PZE1')->where('prefix_code','!=','PZE2');
        //     // ->whereDate('booking_detail_date', '<=', $date_end);
        // })
        //   ->limit('10')

        // dd($bookingEvents);
        ///////////////////////////////////////////////// /////////////////////////////////////////////////
        $hudata1 = '';
        $totalbeforevatd1 = 0;
        $totalvatd1 = 0;
        $totalamountd1 = 0;
        $dudata1 = '';
        $transidu1 = "T2" . date("y") . date("m") . sprintf("%09d", mt_rand(1, 999999));

        $hudata2 = '';
        $totalbeforevatd2 = 0;
        $totalvatd2 = 0;
        $totalamountd2 = 0;
        $dudata2 = '';
        $transidu2 = "T1" . date("y") . date("m") . sprintf("%09d", mt_rand(1, 999999));


        // dd($transidu);

        foreach ($bookingsuser as $key => $bookingu) {

            $space_customer_id = 'A0000699';

            $transaction = Transaction::where('status', "Y")
                ->join('transaction_details', 'transaction_master.trans_id', '=', 'transaction_details.trans_id')
                // ->join('transaction', 'transaction_details.trans_id', '=', 'transaction.trans_id')
                ->where('transaction_details.booking_id', $bookingu->booking_id)
                ->first();

            $trans_id = 'T011111111';
            if ($transaction != null) {
                $trans_id = $transaction->trans_id;
            }
            $store_code = '6601';
            $cost_center_code = '66PZ1';
            $sep_code = 'SEP1';
            if ($bookingu->marketname_id == 2) {
                $store_code = '6602';
                $cost_center_code = '66PZ2';
                $sep_code = 'SEP2';
            }

            $bookdetailuss = $bookingu->bookdetail;
            $discountd = 0;
            if ($bookingu->booking_coupon != null) {
                $discountd = $bookingu->booking_coupon;
            }

            foreach ($bookdetailuss as $key => $bookdetailus) {
                $countbookinu = Booking_Detail::where('booking_id', $bookingu->booking_id)->count();
                $namebooth = '';
                $price = 0;
                if ($bookdetailus->boothdetail != null) {
                    $namebooth = $bookdetailus->boothdetail->name;
                    $price =  $bookdetailus->boothdetail->price;
                    if ($bookdetailus->booth_detail_id == 0) {
                        $price =  $bookingu->booking_grand_total;
                    }
                }
                if ($countbookinu > 1) {
                    $amount_area =  round($transaction->amount_area, 2);
                    if ($transaction->amount_area == 0) {
                        $amount_area = 1;
                    }

                    $amountd = $price +  round($transaction->amount_accessoire / $amount_area, 2);
                    $service_charge = ($transaction->service_charge) / ($amount_area);
                } else {
                    $amountd =  $price +  round($bookingu->booking_service_total, 2);
                    $service_charge = ($transaction->service_charge);
                }


                $discount_in = 0;
                if ($discountd != 0) {
                    if ($discountd >= $amountd) {
                        $discount_in = $amountd - 1;
                        $discountd -= $discount_in;
                    } else {
                        $discount_in = $discountd;
                        $discountd = 0;
                    }
                }
                $amountd -= $discount_in;
                // $beforevatd = (($amountd - $discount_in) * (100) / 107);
                $beforevatd =  round((($amountd * 100) / 107), 2);
                $vatd =  round($amountd - $beforevatd, 2);

                if ($bookingu->marketname_id == 1) {
                    # code...

                    $dudata1  .=  'D|' . $transidu1 . '|1|' . $sep_code . '|Plaza space service ' . $namebooth . ' ' . date('d/m/Y', strtotime($bookdetailus->booking_detail_date)) . ' |1|' . round($beforevatd, 2) . '|' . $beforevatd . '|' . $vatd . '|' . round($amountd, 2) . '|7|DS|' . $cost_center_code . PHP_EOL;

                    $totalbeforevatd1 += round($beforevatd, 2);
                    $totalvatd1 += round($vatd, 2);
                    $totalamountd1 += round($amountd, 2);
                } else if ($bookingu->marketname_id == 2) {

                    $dudata2  .=  'D|' . $transidu2 . '|1|' . $sep_code . '|Plaza space service ' . $namebooth . ' ' . date('d/m/Y', strtotime($bookdetailus->booking_detail_date)) . ' |1|' . round($beforevatd, 2) . '|' . $beforevatd . '|' . $vatd . '|' . round($amountd, 2) . '|7|DS|' . $cost_center_code . PHP_EOL;

                    $totalbeforevatd2 += round($beforevatd, 2);
                    $totalvatd2 += round($vatd, 2);
                    $totalamountd2 += round($amountd, 2);
                }
            }
        }

        // $hudata .= 'H|6600|'.$store_code.'|'.$space_customer_id.'|'.$transidu.'|'. date('d/m/Y',strtotime($transaction->payment_success_date)).'|'. date('d/m/Y',strtotime($transaction->payment_success_date)).'|'. date('d/m/Y',strtotime($transaction->payment_success_date)).'|C000|'.number_format($totalbeforevatd,2).'|'.number_format($totalvatd,2).'|'.number_format($totalamountd,2).'|'.$bookingu->booking_id.PHP_EOL
        // .$dudata;
        if ($dudata1 != null || $dudata1 != '') {
            $hudata1 .= 'H|6600|6601|' . $space_customer_id . '|' . $transidu1 . '|' .  $date_set . '|' .   $date_set . '|' .   $date_set . '|C000|' . round($totalbeforevatd1, 2) . '|' . round($totalvatd1, 2) . '|' . round($totalamountd1, 2) . '|' . $transidu1 . PHP_EOL
                . $dudata1;
        }

        if ($dudata2 != null || $dudata2 != '') {
            $hudata2 .= 'H|6600|6602|' . $space_customer_id . '|' . $transidu2 . '|' .  $date_set . '|' .   $date_set . '|' .   $date_set . '|C000|' . round($totalbeforevatd2, 2) . '|' . round($totalvatd2, 2) . '|' . round($totalamountd2, 2) . '|' . $transidu2 . PHP_EOL
                . $dudata2;
        }

        // dd($hudata1, $hudata2);

        ///////////////////////////////////////////////// /////////////////////////////////////////////////
        $hdata = '';
        $hdata = [];

        $ddaraarr = [];
        $sumbeforevatdre = 0;

        foreach ($bookingsre as $keyout => $booking) {

            $transaction = Transaction::where('status', "Y")
                ->join('transaction_details', 'transaction_master.trans_id', '=', 'transaction_details.trans_id')
                // ->join('transaction', 'transaction_details.trans_id', '=', 'transaction.trans_id')
                ->where('transaction_details.booking_id', $booking->booking_id)
                ->first();

            $ddata = '';

            $space_customer_id = 'A0000699';
            if ($booking->partners->space_customer_id != null) {
                $space_customer_id = $booking->partners->space_customer_id;
            } else if ($booking->partners->space_customer_id == null) {
                if ($booking->marketname_id == 1) {
                    $space_customer_id = 'PZ100699';
                } else if ($booking->marketname_id == 2) {
                    $space_customer_id = 'PZ200699';
                } else if ($booking->marketname_id == 6) {
                    $space_customer_id = 'PZ100699';
                } else if ($booking->marketname_id == 7) {
                    $space_customer_id = 'PZ200699';
                }
            }
            $trans_id = 'T011111111';
            if ($transaction != null) {
                $trans_id = $transaction->trans_id;
            }
            $store_code = '6601';
            $cost_center_code = '66PZ1';
            $sep_code = 'SEP1';
            $strPSS = 'Plaza space service';
            if ($booking->marketname_id == 2) {
                $store_code = '6602';
                $cost_center_code = '66PZ2';
                $sep_code = 'SEP2';
            } else if ($booking->marketname_id == 6) {
                $store_code = '6601';
                $cost_center_code = '66PZ1';
                $sep_code = 'SEEV';
                $strPSS = 'Event space service';
            } else if ($booking->marketname_id == 7) {
                $store_code = '6602';
                $cost_center_code = '66PZ2';
                $sep_code = 'SEEV';
                $strPSS = 'Event space service';
            }

            $bookdetails = $booking->bookdetail;

            $countbookin = Booking_Detail::where('booking_id', $booking->booking_id)->count();


            foreach ($bookdetails as $keyin => $bookdetail) {
                $price = 0;
                $namebooth = '';
                $datebookdetail = '';
                if ($bookdetail->boothdetail != null) {
                    $namebooth = $bookdetail->boothdetail->name;
                    $price =  $bookdetail->boothdetail->price;
                    $datebookdetail =  date('d/m/Y', strtotime($bookdetail->booking_detail_date));
                } else {
                    if ($bookdetail->booth_detail_id == 0) {
                        // $price =  $booking->booking_grand_total;
                        $namebooth = 'charge and service';
                        $datebookdetail = '';
                    }
                }
                if ($countbookin > 1) {
                    $amount_area = $transaction->amount_area;
                    if ($transaction->amount_area == 0) {
                        $amount_area = 1;
                    }
                    $amountdre = $price + (($transaction->amount_accessoire) / ($amount_area));
                    $service_charge = ($transaction->service_charge) / ($amount_area);
                } else {

                    $amountdre = ($price + $booking->booking_service_total);

                    if ($bookdetail->booth_detail_id == 0) {
                        // $price =  $booking->booking_grand_total;
                        $amountdre = ($booking->booking_grand_total);
                    }
                    $service_charge = ($transaction->service_charge);
                }

                $amountd = round($price, 2);
                $discounRel = 0;
                if ($bookdetail->booking->booking_coupon != null) {
                    $discounRel = $bookdetail->booking->booking_coupon;
                }

                $amountdre -= $discounRel;
                $beforevatdre = round((($amountdre * 100) / 107), 2);
                $vatdre = round(($amountdre - $beforevatdre), 2);

                $ddata .=  'D|T321' . $space_customer_id . '|1|' . $sep_code . '|' . $strPSS . ' ' . $namebooth . ' ' . $datebookdetail . ' |1|' . $beforevatdre . '|' . $beforevatdre . '|' . $vatdre . '|' . round($amountdre, 2) . '|7|DS|' . $cost_center_code . PHP_EOL;
            }
            // $sumamountdre =  Booking::whereHas('partners', function ($query) use($space_customer_id){
            //     $query->where('space_customer_id',$space_customer_id);
            // }) ->whereHas('bookdetail', function ($query){
            //     // $query->whereDate('booking_payment_date',date("Y/m/d"));
            //     // $query->whereDate('booking_payment_date',date("Y-m-d", strtotime('2021-02-22')));
            //     // ->whereDate('booking_detail_date', '<=', $date_end);
            // })->sum('booking_grand_total');
            // dd($sum);
            // $sumbeforevatdre = (($sumamountdre*100)/107);
            // $sumtotalvatdre = $sumamountdre-$sumbeforevatdre;

            // $amounth = $booking->booking_grand_total;
            // $beforevath = (($amounth*100)/107);
            // $vath = $amounth-$beforevatd;

            $beforevatdre_arr[$space_customer_id][] = $beforevatdre;
            $vatdre_arr[$space_customer_id][] = $vatdre;
            $amountdre_arr[$space_customer_id][] = $amountdre;

            $hdatasrt = 'H|6600|' . $store_code . '|' . $space_customer_id . '|T321' . $space_customer_id . '|' .  $date_set . '|' .  $date_set . '|' .  $date_set . '|C000|' . array_sum($beforevatdre_arr[$space_customer_id]) . '|' . array_sum($vatdre_arr[$space_customer_id]) . '|' . round(array_sum($amountdre_arr[$space_customer_id]), 2) . '|' . $space_customer_id . PHP_EOL;
            if ($booking->partners->space_customer_id == null) {
                if ($booking->marketname_id == 1) {
                    $hdatasrt = 'H|6600|' . $store_code . '|A0000699|T321' . $space_customer_id . '|' . $date_set . '|' .  $date_set . '|' .  $date_set . '|C000|' . array_sum($beforevatdre_arr[$space_customer_id]) . '|' . array_sum($vatdre_arr[$space_customer_id]) . '|' . round(array_sum($amountdre_arr[$space_customer_id]), 2) . '|' . $space_customer_id . PHP_EOL;
                } else if ($booking->marketname_id == 2) {
                    $hdatasrt = 'H|6600|' . $store_code . '|A0000699|T321' . $space_customer_id . '|' . $date_set . '|' .  $date_set . '|' .  $date_set . '|C000|' . array_sum($beforevatdre_arr[$space_customer_id]) . '|' . array_sum($vatdre_arr[$space_customer_id]) . '|' . round(array_sum($amountdre_arr[$space_customer_id]), 2) . '|' . $space_customer_id . PHP_EOL;
                } else if ($booking->marketname_id == 6) {
                    $hdatasrt = 'H|6600|' . $store_code . '|A0000699|T321' . $space_customer_id . '|' . $date_set . '|' .  $date_set . '|' .  $date_set . '|C000|' . array_sum($beforevatdre_arr[$space_customer_id]) . '|' . array_sum($vatdre_arr[$space_customer_id]) . '|' . round(array_sum($amountdre_arr[$space_customer_id]), 2) . '|' . $space_customer_id . PHP_EOL;
                } else if ($booking->marketname_id == 7) {
                    $hdatasrt = 'H|6600|' . $store_code . '|A0000699|T321' . $space_customer_id . '|' . $date_set . '|' .  $date_set . '|' .  $date_set . '|C000|' . array_sum($beforevatdre_arr[$space_customer_id]) . '|' . array_sum($vatdre_arr[$space_customer_id]) . '|' . round(array_sum($amountdre_arr[$space_customer_id]), 2) . '|' . $space_customer_id . PHP_EOL;
                }
            }
                // .$ddata.
            ;
            $ddaraarr[$space_customer_id][] = $ddata;

            $hdataarr[0] = $hdatasrt;
            $hdata[$space_customer_id] = [$hdataarr, $ddaraarr[$space_customer_id], array_sum($beforevatdre_arr[$space_customer_id]), array_sum($vatdre_arr[$space_customer_id]), array_sum($amountdre_arr[$space_customer_id])];
        }
        ///////////////////////////////////////////////// /////////////////////////////////////////////////
        $hEventdata = '';
        $hEventdata = [];

        $dEventarr = [];
        $sumbeforevatdre = 0;
        foreach ($bookingEvents as $keyout => $bookingE) {
            $transaction = Transaction::where('status', "Y")
                ->join('transaction_details', 'transaction_master.trans_id', '=', 'transaction_details.trans_id')
                // ->join('transaction', 'transaction_details.trans_id', '=', 'transaction.trans_id')
                ->where('transaction_details.booking_id', $bookingE->booking_id)
                ->first();

            $Edata = '';

            $space_customer_id = 'A0000699';
            if ($bookingE->partners->space_customer_id != null) {
                $space_customer_id = $bookingE->partners->space_customer_id;
            } else if ($bookingE->partners->space_customer_id == null) {
                if ($bookingE->marketname_id == 6) {
                    $space_customer_id = 'PZ100699';
                } else if ($bookingE->marketname_id == 7) {
                    $space_customer_id = 'PZ200699';
                }
            }
            $trans_id = 'T011111111';
            if ($transaction != null) {
                $trans_id = $transaction->trans_id;
            }
            $store_code = '6601';
            $cost_center_code = '66PZ1';
            $sep_code = 'SEEV';
            $strPSS = 'Event space service';
            if ($bookingE->marketname_id == 7) {
                $store_code = '6602';
                $cost_center_code = '66PZ2';
                $sep_code = 'SEEV';
                $strPSS = 'Event space service';
            }

            $bookEdetails = $bookingE->bookdetail;

            $countbookin = Booking_Detail::where('booking_id', $bookingE->booking_id)->count();


            foreach ($bookEdetails as $keyin => $bookEdetail) {
                $price = 0;
                $namebooth = '';
                $datebookdetail = '';
                if ($bookEdetail->boothdetail != null) {
                    $namebooth = $bookEdetail->boothdetail->name;
                    $price =  $bookEdetail->boothdetail->price;
                    $datebookdetail =  date('d/m/Y', strtotime($bookEdetail->booking_detail_date));
                } else {
                    if ($bookEdetail->booth_detail_id == 0) {
                        // $price =  $booking->booking_grand_total;
                        $namebooth = 'charge and service';
                        $datebookdetail = '';
                    }
                }
                if ($countbookin > 1) {
                    $amount_area = $transaction->amount_area;
                    if ($transaction->amount_area == 0) {
                        $amount_area = 1;
                    }
                    $amountdre = $price + (($transaction->amount_accessoire) / ($amount_area));
                    $service_charge = ($transaction->service_charge) / ($amount_area);
                } else {

                    $amountdre = ($price + $bookingE->booking_service_total);
                    if ($bookEdetail->booth_detail_id == 0) {
                        // $price =  $booking->booking_grand_total;
                        $amountdre = ($bookingE->booking_grand_total);
                    }
                    $service_charge = ($transaction->service_charge);
                }

                $amountd = round($price, 2);
                $discounRel = 0;
                if ($bookEdetail->booking->booking_coupon != null) {
                    $discounRel = $bookEdetail->booking->booking_coupon;
                }

                $amountdre -= $discounRel;
                $beforevatdre = round((($amountdre * 100) / 107), 2);
                $vatdre = round(($amountdre - $beforevatdre), 2);

                $Edata .=  'D|T321' . $space_customer_id . '|1|' . $sep_code . '|' . $strPSS . ' ' . $namebooth . ' ' . $datebookdetail . ' |1|' . $beforevatdre . '|' . $beforevatdre . '|' . $vatdre . '|' . round($amountdre, 2) . '|7|DS|' . $cost_center_code . PHP_EOL;
            }
            // $sumamountdre =  Booking::whereHas('partners', function ($query) use($space_customer_id){
            //     $query->where('space_customer_id',$space_customer_id);
            // }) ->whereHas('bookdetail', function ($query){
            //     // $query->whereDate('booking_payment_date',date("Y/m/d"));
            //     // $query->whereDate('booking_payment_date',date("Y-m-d", strtotime('2021-02-22')));
            //     // ->whereDate('booking_detail_date', '<=', $date_end);
            // })->sum('booking_grand_total');
            // dd($sum);
            // $sumbeforevatdre = (($sumamountdre*100)/107);
            // $sumtotalvatdre = $sumamountdre-$sumbeforevatdre;

            // $amounth = $booking->booking_grand_total;
            // $beforevath = (($amounth*100)/107);
            // $vath = $amounth-$beforevatd;

            $Ebeforevatdre_arr[$space_customer_id][] = $beforevatdre;
            $Evatdre_arr[$space_customer_id][] = $vatdre;
            $Eamountdre_arr[$space_customer_id][] = $amountdre;

            $hEdatasrt = 'H|6600|' . $store_code . '|' . $space_customer_id . '|T321' . $space_customer_id . '|' . $date_set . '|' . $date_set . '|' . $date_set . '|C000|' . array_sum($Ebeforevatdre_arr[$space_customer_id]) . '|' . array_sum($Evatdre_arr[$space_customer_id]) . '|' . round(array_sum($Eamountdre_arr[$space_customer_id]), 2) . '|' . $space_customer_id . PHP_EOL;
            if ($bookingE->partners->space_customer_id == null) {
                if ($bookingE->marketname_id == 6) {
                    $hEdatasrt = 'H|6600|' . $store_code . '|A0000699|T321' . $space_customer_id . '|' .$date_set . '|' . $date_set . '|' . $date_set . '|C000|' . array_sum($Ebeforevatdre_arr[$space_customer_id]) . '|' . array_sum($Evatdre_arr[$space_customer_id]) . '|' . round(array_sum($Eamountdre_arr[$space_customer_id]), 2) . '|' . $space_customer_id . PHP_EOL;
                } else if ($bookingE->marketname_id == 7) {
                    $hEdatasrt = 'H|6600|' . $store_code . '|A0000699|T321' . $space_customer_id . '|' .$date_set . '|' . $date_set . '|' . $date_set . '|C000|' . array_sum($Ebeforevatdre_arr[$space_customer_id]) . '|' . array_sum($Evatdre_arr[$space_customer_id]) . '|' . round(array_sum($Eamountdre_arr[$space_customer_id]), 2) . '|' . $space_customer_id . PHP_EOL;
                }
            }
                // .$ddata.
            ;
            $dEventarr[$space_customer_id][] = $Edata;

            $hEdataarr[0] = $hEdatasrt;
            $hEventdata[$space_customer_id] = [$hEdataarr, $dEventarr[$space_customer_id], array_sum($Ebeforevatdre_arr[$space_customer_id]), array_sum($Evatdre_arr[$space_customer_id]), array_sum($Eamountdre_arr[$space_customer_id])];
        }


        $limit = 50;
        $arr = $hdata + $hEventdata;
        $count_qrray = count($arr);
        $destinationPath = public_path() . "/upload/";

        if ($count_qrray <= ($limit - 2)) {
            $regudata = '';
            foreach ($hdata as $keyall => $value) {
                # code...
                //   dd($value[0]);
                $detail = '';
                foreach ($value[1] as $key => $data) {
                    # code...

                    $detail .= $data;
                }
                $regudata .= $value[0][0] . $detail;
            }

            $eventdata = '';

            foreach ($hEventdata as $keyall => $value) {
                # code...
                //   dd($value[0]);
                $detail = '';
                foreach ($value[1] as $key => $data) {
                    # code...

                    $detail .= $data;
                }
                $eventdata .= $value[0][0] . $detail;
            }
            $alltextflie = $regudata . $eventdata . $hudata1 . $hudata2;
            // dd($alltextflie);
            //date('d/m/Y',$transaction->payment_success_date)
            $file = time() . rand() . '_file.text';
            $destinationPath = public_path() . "/upload/";
            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            File::put($destinationPath . $file, $alltextflie);
            //return response()->download($destinationPath.$file);
            $status = $this->connectftp($file);
            return $status;
        } else {
            $eventdata='';
            $i=0;

            $data_all_limit = array();

            foreach ($arr as $keyall => $value) {
                $i++;
                $detail = '';
                    foreach ($value[1] as $key => $data) {
                        # code...
                        $detail .= $data;
                    }
                $eventdata .= $value[0][0].$detail;

                 if($i%$limit == 0){
                    $data_all_limit[] = $eventdata;
                    $eventdata = '';
                }
            }
            $data_all_limit[] = $eventdata.$hudata1.$hudata2;
            // dd($data_all_limit);

             foreach($data_all_limit as $value){

                $file = time() . rand() . '_file.text';
                $destinationPath = public_path() . "/upload/";
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                File::put($destinationPath.$file,$value);

                //return response()->download($destinationPath.$file);
                $status = $this->connectftp($file);


             }
             return $status;

        }
    }
    public function connectftp($namefile)
    {

        try {
            $ftp_server = "203.146.13.140";
            $port_number = "1069";
            $ftp_user_name = "ftp.orange";
            $ftp_user_pass = "eYghm3yr";
            // $csv_filename = '160756856432787264_file.text';
            // $file = asset('public/upload/'.$namefile);//tobe uploaded
            $file = 'https://sunplaza.singhaestate.co.th/public/upload/' . $namefile;
            // dd($file);
            $target = '/SunMkt/Outbound/' . $namefile;
            $remote_file = 'readme.txt';
            // set up basic connection
            $conn_id = ftp_connect($ftp_server, $port_number) or die("Couldn't connect to $ftp_server");;
            // login with username and password
            $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
            // check connection
            if ((!$conn_id) || (!$login_result)) {
                die("FTP connection has failed !");
            }
            // echo "Current directory: " . ftp_pwd($conn_id) ;
            $ps = ftp_pasv($conn_id, true);
            // ftp_chdir($conn_id,'/SunMkt/Outbound/');
            // ftp_put($conn_id,'160756856432787261_file.text',$file, FTP_BINARY );

            // if (ftp_chdir($conn_id, $remote_file)) {
            //     echo "Current directory is now: " . ftp_pwd($conn_id) ;
            // } else {
            //     echo "Couldn't change directory\n";
            // }
            // upload file
            $upload = ftp_put($conn_id, $target, $file, FTP_ASCII);
            if (!$upload) {
                $status = 'false';
                echo 'FTP upload failed!';
            }

            // if (!$upload) { echo 'FTP upload failed!'; }
            // close the connection
            ftp_close($conn_id);
            $status = 'success';
            return  $status;
            // var_dump($conn_id);

        } catch (Exception $e) {
            echo "Failure: " . $e->getMessage();
        }
    }
    public function serach_customer(Request $request)
    {
        // dd($request->all());
        // $partner = Partners::all();
        $partner = Partners::where('name_customer', 'LIKE', "%{$request->value}%")->where('status', 'Y')->get();
        $html_data = '';
        foreach ($partner as $key => $value) {
            $html_data .= '
            <tr>

              <th class="text-center">' . $value->name_customer . '</th>
              <th class="text-center"><button class="btn btn-info" type="button" onclick="choseecustomer(' . "'$value->name_customer'" . ', ' . $value->partners_id . ')">บันทึก</button></th>

            </tr>
            ';
        }
        $html = '
        <table id="search_customer" class="table  table-bordered" width="100%">
        <thead>
            <tr>
                <th class="text-center">ชื่อลูกค้า</th>
                <th class="text-center">เลือก</th>

            </tr>
        </thead>
        <tbody>
            ' . $html_data . '
        </tbody>
        </table>
        ';
        $data = array(
            'html' => $html,
        );
        return $data;
    }
}
