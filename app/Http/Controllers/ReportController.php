<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use PDF;
use Maatwebsite\Excel\Excel as Excel_yaja;
use Excel;
use Yajra\Datatables\Datatables;
use App\BookExport;
use DateTime;
use DB;
// Model
use App\Exports\reportCheckIn;
use App\Model\MK_Booth;
use App\Model\MK_BoothDetail;
use App\Model\MK_MarketName;
use App\Model\MK_Zone;
use App\Model\Booking;
use App\Model\Booking_Detail;
use App\Model\Partners;
use App\Model\PartnersProduct;
use App\Model\Product;
use App\Model\Transaction;
use App\Model\Transaction_Detail;
use App\Model\AuditDetailsAccessories;
class ReportController extends Controller
{
    public function __construct(Excel_yaja $excel){
        $this->excel = $excel;
    }
    //ออกรายงาน
    // ===================================================

    // รายงานการจอง
    public function report_booking(){
        $marketname = MK_MarketName::all();
        $booth = MK_Booth::all();
        $data = array(
            'marketname' => $marketname,
            'booth' => $booth,
        );
        return view('backend/report/report_booking',$data);
    }

    public function report_booking_pdf(Request $request){
        // dd($request->All());
        // $d_start = $request->date_start;
        // $d_end = $request->date_end;
        $month = ($request->month);
        // dd(date("n", strtotime($month)));
        $market_id = ($request->market_id);
        $market = MK_MarketName::find($market_id);
        $booth_id = ($request->booth_id);
        $fdata = array(
            'market_id' => $market_id,
            'booth_id' => $booth_id,
        );

        $boothdetail = MK_BoothDetail::
        whereHas('booth', function ($query)  use ($fdata) {
            $query->where('marketname_id',$fdata['market_id'])->where('booth_id',$fdata['booth_id']);
        })
        // ->orderByRaw('LENGTH(name)', 'ASC')
        // ->orderBy('name', 'ASC')
        // ->orderByRaw('SUBSTR(name FROM 1 FOR 1),
        // CAST(SUBSTR(name FROM 2) AS UNSIGNED)')
        ->orderBy(DB::raw("SUBSTR(name FROM 1 FOR 1),
        CAST(SUBSTR(name FROM 2) AS UNSIGNED)"))
        ->get();
        // dd($boothdetail);
        $html = '';
        // $find = [];
        foreach ($boothdetail as $key => $booth) {
            // $find[] = $booth;
            $status = "all";
            $findbooks =  Booking_Detail::
            whereMonth('booking_detail_date',date("n", strtotime($month)))
            ->where('booth_detail_id', $booth->booth_detail_id) //$booth->booth_detail_id
            ->whereHas('booking', function ($query)  use ($booth,$status) {
                // $query->orWhere('booking_status_id',2)->orWhere('booking_status_id',3);

                if ($status == "all") {
                    $query->whereIn('booking_status_id', [2, 3]);
                }else if($status == "2"){
                    $query->Where('booking_status_id',2);
                }else {
                    // dd($status);
                    $query->Where('booking_status_id',3);
                }

                // ->where('',1);
            })
        ->get();
        // dd($findbooks->groupBy('booking_detail_date'));
        $htmltd = '';

        for ($i=0; $i < 31; $i++) {
           $finddate = null;
           $bc_date = $month.'-'.($i+1);
           $c_date = new DateTime($bc_date);
            // dd($c_month);
            //  $finddate = $this->checkbooking($booth->booth_detail_id,$c_date,'all');
            foreach ($findbooks->groupBy('booking_detail_date') as $key => $findbook) {
                foreach ($findbook as $value) {
                    $f_date = new DateTime($value->booking_detail_date);
                    if ($f_date == $c_date) {
                        if ($findbook->count() > 1) {
                            $finddate[] = $value;
                        } else {
                            $finddate = $value;
                        }
                        $find[$booth->name] =  $findbook;
                    }
                }
            }
            // dump($finddate);
            //  $find = ($findbook->booking_detail_date == $c_month);
           $mess = "";
           $cstyle = '';
           $setBorder = '';
           $borderR = '';
            if ($finddate != null) {

                if (is_array($finddate)) {
                    $tr = '';
                    foreach ($finddate as $value) {
                        $databook = $value;
                        $name = 'ชื่อผู้จอง ...';
                        $lastname = '';
                        $product = '-';
                        if ($databook->partners != null) {
                            # code...
                            $name = $databook->partners->name;
                            $lastname = $databook->partners->lastname;
                            $product = $databook->partners->prtnersproduct->product->name ?? '';
                        }
                        $textDesc = '';
                        $cstyle = 'background-color:#ffcc66 ';
                        if($databook->booking->booking_status_id == 3){
                            $cstyle = 'background-color: #99ff99;';
                            $textDesc = '';
                        }

                        if($databook->audit_status_id == '99'){
                            $cstyle = 'color: red';
                            $textDesc = ' (บูธถูกตัดล๊อค)';
                            $setBorder = true;
                        }

                        $text = 'ชื่อ '.$name.' '. $lastname.'<br> ชื่อบูธ '.$databook->boothdetail->name .' '.'<br>สินค้าที่ขาย '.$product . $textDesc;

                        $tr .= "<div style='{$cstyle}'>{$text}</div>";
                    }

                    $mess = $tr;
                } else {
                    $databook = $finddate;
                        $name = 'ชื่อผู้จอง ...';
                        $lastname = '';
                        $product = '-';
                    if ($databook->partners != null) {
                        # code...
                        $name = $databook->partners->name;
                        $lastname = $databook->partners->lastname;
                        $product = $databook->partners->prtnersproduct->product->name ?? '';
                    }

                        $mess = 'ชื่อ '.$name.' '. $lastname.'<br> ชื่อบูธ '.$databook->boothdetail->name .' '.'<br>สินค้าที่ขาย '.$product;
                        $cstyle = 'background-color:#ffcc66 ';
                     if($databook->booking->booking_status_id == 3){
                        $cstyle = 'background-color: #99ff99;';
                     }

                     if($databook->audit_status_id == '99'){
                        $cstyle = 'background-color: #e84855';
                     }

                }
            }
            if ($setBorder) {
                $borderR = 'border: 1px solid red';
            }
           $htmltd .= ' <td class="text"  style="width: 15px; '.$cstyle.' '.$borderR.'" >'.$mess.'</td>';
        }

        $html .= '
        <tr  >
        <td style="background-color:#ACD8E5; height: 70px; width: 5px;" >'.$booth->name.'</td>
        <td style="background-color:#d5e7ed; height: 70px; width: 8px;" >'.$booth->price.'</td>
                '. $htmltd.'
        </tr>
        ';
        }
        // dd($find);
        $data = array(
            // 'd_start'=>$d_start,
            // 'd_end'=>$d_end,
            'html'=>$html,
            'month'=>$month,
            'booth' => $boothdetail->count()
        );
        //dd($data);
        // return view('backend/report/pdf/pdf_booking',$data);
        // $pdf = PDF::loadView('backend/report/pdf/pdf_booking',$data);
        return Excel::download(new BookExport("backend/report/pdf/pdf_booking",$data), 'รายงานแสดงข้อมูลการจอง'.$market->name_market.date('Y-m-d',time()).'.xlsx');

		//return $pdf->stream('รายงานการจอง.pdf');
    }
    public function checkbooking($booth,$date,$status){
        // dd($booth,$date,$status);

        $findbook =  Booking_Detail::
        where('booking_detail_date',$date)
        ->where('booth_detail_id',$booth)
        ->whereHas('booking', function ($query)  use ($booth,$status) {
            // $query->orWhere('booking_status_id',2)->orWhere('booking_status_id',3);

            if ($status == "all") {
                $query->Where('booking_status_id',2)->orWhere('booking_status_id',3);
            }else if($status == "2"){
                $query->Where('booking_status_id',2);
            }else {
                // dd($status);
                $query->Where('booking_status_id',3);
            }

            // ->where('',1);
        })
        ->first();
        // dd($findbook);
        return $findbook;
    }
    // ===================================================

    // รายงาน Booth ว่าง
    public function report_booth(){
        $marketname = MK_MarketName::all();
        $booth = MK_Booth::all();
        $data = array(
            'marketname' => $marketname,
            'booth' => $booth,
        );
        return view('backend/report/report_booth',$data);
    }

    public function report_booth_pdf(Request $request){
        // dd($request->all());
        $date = $request->date;
        $d_start = $request->d_start;
        $d_end = $request->date_end;
        $c_month = new DateTime($date);
        $market_id = ($request->market_id);
        $market = MK_MarketName::find($market_id);
        $booth_id = ($request->booth_id);
        $fdata = array(
            'market_id' => $market_id,
            'booth_id' => $booth_id,
        );
        // dd($fdata);
        $boothdetail = MK_BoothDetail::
        whereHas('booth', function ($query)  use ($fdata) {
            $query->where('marketname_id',$fdata['market_id'])->where('booth_id',$fdata['booth_id']);
        })
        ->orderBy(DB::raw("name+0"))
        ->get();
        foreach ($boothdetail as $key => $booth) {
            $check = $this->checkbooking($booth->booth_detail_id,$c_month,3);
            if ($check == null) {

                $findempty[] = $booth;
            }
        }
        // dd($findempty);
        $data = array(
            'findempty' => $findempty,
            'd_start' => $d_start,
            'd_end' => $d_end,
        );
        return Excel::download(new BookExport("backend/report/pdf/pdf_booth", $data), 'รายงานBoothว่าง'.$market->name_market.date('Y-m-d',time()).'.xlsx');

        $pdf = PDF::loadView('backend/report/pdf/pdf_booth',['d_start'=>$d_start,'d_end'=>$d_end]);
		// return $pdf->stream('รายงาน Booth ว่าง.pdf');
    }
    // ===================================================

    // รายงานชำระเงิน
    public function report_payment(){
        return view('backend/report/report_payment');
    }

    public function report_payment_pdf(Request $request){
        $d_start = $request->date_start;
        $d_end = $request->date_end;
        $pdf = PDF::loadView('backend/report/pdf/pdf_payment',['d_start'=>$d_start,'d_end'=>$d_end]);
		return $pdf->stream('รายงานชำระเงิน.pdf');
    }
    // ===================================================

    // รายงานการขายรายวัน
    public function report_payment_day(){
        $market = MK_MarketName::all();
        $booth = MK_Booth::all();
        $data = array(
            'market' => $market,
            'booth' => $booth,
        );
        return view('backend/report/report_payment_day',$data);
    }

    public function report_payment_day_pdf(Request $request){
        // dd($request->all());
        $d_start = $request->date_start;
        // $d_end = $request->date_end;
        $market_id = ($request->market_id);
        $booth_id = ($request->booth_id);
        $market = MK_MarketName::find($market_id);
        $fdata = array(
            'market_id' => $market_id,
            'booth_id' => $booth_id,
        );
        $booth = MK_BoothDetail::whereHas('booth', function ($queryin)  use ($fdata) {
                    // $queryin->where('marketname_id',$fdata['market_id'])->where('booth_id',$fdata['booth_id'])->where('status','Y');
                    $queryin->where('marketname_id',$fdata['market_id'])->where('booth_id',$fdata['booth_id']);
                })
        // $booking = Booking_Detail::whereDate('booking_detail_date', '>=', $d_start)
        // ->whereDate('booking_detail_date', '<=', $d_end)
        // ->whereHas('boothdetail', function ($query)  use ($fdata) {
        //     $query->whereHas('booth', function ($queryin)  use ($fdata) {
        //         $queryin->where('marketname_id',$fdata['market_id']);
        //     });
        // })
        // ->join('mk_booth_detail', 'booking_detail.booth_detail_id', '=', 'mk_booth_detail.booth_detail_id')
        ->orderBy(DB::raw("SUBSTR(name FROM 1 FOR 1),CAST(SUBSTR(name FROM 2) AS UNSIGNED)"))
        ->where('status','Y')
        ->get();
        // dd($book);
        $html ='';
        foreach ($booth as $key => $item) {
            // $datepayment  = '';
            $date = new DateTime( $item->booking_detail_date);
            $today = new DateTime( $request->date_start);
            $books = Booking_Detail::where('booking_detail_date',$today)
            ->where('booth_detail_id',$item->booth_detail_id)->
            whereHas('booking', function ($queryin)  {
                $queryin->whereIn('booking_status_id',[3,2]);
            })->get();

            $datepayment = '';
            $partners = '' ;
            $status = 'ว่าง';
            if (count($books) > 0) {
                # code...
                // dd($books);

                foreach ($books as $keyin => $book) {

                    if ($book->booking->booking_status_id == 3 || $book->booking->booking_status_id == 2 ) {
                        $partners = $book->partners->name_customer ;
                        $datepayment = ($book->booking_payment_date != null)?date("d-m-Y", strtotime($book->booking_payment_date)):'' ;
                        $status = $book->booking->status->booking_status_name;
                    }


                }

            }

            $html .= ' <tr>
            <th class="text">'.($key+1).'</th>
            <th class="text">'.$item->name.'</th>
            <th class="text">'.$partners.'</th>
            <th class="text">'.$datepayment.'</th>
            <th class="text">'.$item->price.'</th>
            <th class="text">'.$item->producttype->name.'</th>
            <th class="text">'.$status.'</th>


        </tr>';
        }
        $html .= '';
        // dd($booking);
        $data = array(
            'booth' => $booth,
            'd_start' => $d_start,
            // 'd_end' => $d_end,
            'market' => $market,
            'html' => $html,
        );
        // dd($data);
        // return view('backend/report/pdf/pdf_payment_day', $data);
        return Excel::download(new BookExport("backend/report/pdf/pdf_payment_day", $data), 'รายงานการขายรายวัน'.$market->name_market.date('Y-m-d',time()).'.xlsx');
        // $pdf = PDF::loadView('backend/report/pdf/pdf_payment_day',['d_start'=>$d_start,'d_end'=>$d_end]);
		// // return $pdf->stream('รายงานการขายรายวัน.pdf');
    }
    // ===================================================

    // รายงานการจองบุคคล
    public function report_payment_person(){
        $partners = Partners::all();
        $data = array(
            'partners' => $partners
        );
        return view('backend/report/report_payment_person',$data);
    }

    public function report_payment_person_pdf(Request $request){
        // $bookings = Booking_Detail::whereHas('partners', function ($query)  use ($data) {
        //     $query->where('name_customer',$request->name_customer);
        // })->get();
        $bookings = Booking_Detail::where('partners_id',$request->name_customer)
        ->get();

        $data = array(
            'bookings' => $bookings
        );
        return Excel::download(new BookExport("backend/report/pdf/pdf_payment_person", $data), 'รายงานการขายรายวัน'.date('Y-m-d',time()).'.xlsx');
        // $pdf = PDF::loadView('backend/report/pdf/pdf_payment_person',$data);
		// return $pdf->stream('รายงานการจองบุคคล.pdf');
    }
    // ===================================================

    // รายงานหลุดการจอง
    public function report_cancel(){
        return view('backend/report/report_cancel');
    }

    public function report_cancel_pdf(Request $request){
        $d_start = $request->date_start;
        $d_end = $request->date_end;
        $pdf = PDF::loadView('backend/report/pdf/pdf_cancel',['d_start'=>$d_start,'d_end'=>$d_end]);
		return $pdf->stream('รายงานหลุดการจอง.pdf');
    }
    // ===================================================


    // บัญชี
    // ===================================================

    // รายงานแสดงข้อมูลทั้งหมด
    public function report_audit_total(){
        $market = MK_MarketName::all();
        $data = array(
            'market' => $market,
        );
        return view('backend/report/report_audit_total',$data);
    }

    public function report_audit_total_pdf(Request $request){

        $d_start = $request->date_start;
        $d_end = $request->date_end;
        $data = array(
            'market' => $request->market_id,
            // 'd_start' => $d_start,
            // 'd_end' => $d_end,
            // 'tbodyhtml' => $tdhtml,
            // 'sumgrand_total' => $sumgrand_total,
        );
        $market_id = $request->market_id;
        $market = MK_MarketName::find($market_id);
        $bookings = Booking_Detail::whereDate('booking_detail_date', '>=', $d_start)->where('booth_detail_id', '!=',0)
        ->whereDate('booking_detail_date', '<=', $d_end)

        ->whereHas('booking', function ($query)  use ($data) {
            $query->where('marketname_id',$data['market']);
        })->get();

        $tdhtml = '';

        foreach ($bookings as $key => $booking) {


                $booking_payment_date = ($booking->booking_payment_date != null)?date("d-m-Y", strtotime($booking->booking_payment_date)):' ' ;
                $status = 'ใช้งาน';
                $statusval = $booking->booking->booking_status_id;
                if ($statusval == 4 || $statusval == 5 || $statusval == 6) {
                    $status = 'ไม่ใช้งาน';

                }

                if($booking->booking_payment_date and  $booking->booking->status->booking_status_id == 5){
                    $detail = 'ยกเลิกการขาย (ตัดล็อค)';

                }else{
                    $detail = $booking->booking->status->booking_status_name ;

                }
                // dd($transaction);
                $discount = $booking->booking->booking_coupon;
                $amount = $booking->boothdetail->price;
                $beforevat = (($amount-$discount) * (100/107));

                $vat = $beforevat * 0.07;
                // $transaction = $booking->transactiondetail->transaction;
                // dd($beforevat,$vat,$transaction->trans_id);
                $day = date('w',strtotime($booking->booking_detail_date));
                $thday = array ( "อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์" );
                $namebooth = 'บูธเรียกเก็บพิเศษ';
                if ($booking->boothdetail != null) {
                    $namebooth = $booking->boothdetail->name;
                }


                    # code...
                    $tdhtml .= '<tr class="text" >
                    <td class="text">'.($key+1).'</td>
                    <td class="text">'.$booking->booking_id.'</td>
                    <td class="text">'.$thday[$day].'</td>
                    <td class="text">'.$namebooth.'</td>
                    <td class="text">'.date('d-m-Y',strtotime($booking->booking_detail_date)).'</td>
                    <td class="text">'.$booking->partners->name_customer.'</td>
                    <td class="text">'.$booking_payment_date.'</td>
                    <td class="text" algin="left">'.number_format($amount,2).'</td>
                    <td class="text" algin="left">-</td>
                    <td class="text" algin="left">'.number_format($discount,2).'</td>
                    <td class="text" algin="left">'.number_format($beforevat,2).'</td>
                    <td class="text" algin="left">'.number_format($vat,2).'</td>
                    <td class="text">'.number_format($beforevat+$vat,2).'</td>
                    <td class="text">-</td>
                    <td class="text">'.number_format($beforevat+$vat,2).'</td>
                    <td class="text">'.$status.'</td>
                    <td class="text">'.$detail.'</td>
                    <td class="text">'.$booking->cancel_detail.'</td>
                </tr>';


        }
        $tbodyhtml = '
        '.$tdhtml.'
        ';

        $data = array(
            'bookings' => $bookings,
            'd_start' => $d_start,
            'd_end' => $d_end,
            'tbodyhtml' => $tdhtml,
            'market' => $market,
            // 'sumgrand_total' => $sumgrand_total,
        );
        return Excel::download(new BookExport("backend/report/pdf/pdf_audit_total", $data), 'รายงานแสดงข้อมูลการจอง'.date('Y-m-d',time()).'.xlsx');
        // $pdf = PDF::loadView('backend/report/pdf/pdf_audit_total',['d_start'=>$d_start,'d_end'=>$d_end],[],['format'=>'A4-L']);
        // return $pdf->stream('รายงานแสดงข้อมูลทั้งหมด.pdf');
        // return Excel::download(new BookExport("backend/report/pdf/pdf_audit_total", $data), 'รายงานแสดงข้อมูลการจอง'.date('Y-m-d',time()).'.xlsx');


    }
    // ===================================================

    // รายงานทะเบียนคุมจอง
    public function report_audit_booking(){
        return view('backend/report/report_audit_booking');
    }

    public function report_audit_booking_pdf(Request $request){
        $d_start = $request->date_start;
        $d_end = $request->date_end;
        $pdf = PDF::loadView('backend/report/pdf/pdf_audit_booking',['d_start'=>$d_start,'d_end'=>$d_end],[],['format'=>'A4-L']);
		return $pdf->stream('รายงานทะเบียนคุมจอง.pdf');
    }
    // ===================================================

    // รายงานการชำระเงิน
    public function report_audit_payment(){
        $market = MK_MarketName::all();
        $data = array(
            'market' => $market,
        );
        return view('backend/report/report_audit_payment',$data);
    }

    public function report_audit_payment_pdf(Request $request){
        // dd($request->all());
        $d_start = $request->date_start;
        $d_end = $request->date_end;
          $data = array(
            'market' => $request->market_id,
            // 'd_start' => $d_start,
            // 'd_end' => $d_end,
            // 'tbodyhtml' => $tdhtml,
            // 'sumgrand_total' => $sumgrand_total,
        );
        $market_id = $request->market_id;
        $market = MK_MarketName::find($market_id);
        // dd($market);
        // $booking = Booking_Detail::where('booking_status_id',"3")->get();
        $bookings = Booking_Detail::whereYear('booking_payment_date', '=', date("Y", strtotime($d_start)))
        ->whereMonth('booking_payment_date',date("n", strtotime($d_start)))
        ->whereDate('booking_payment_date', '>=', $d_start)
        ->whereDate('booking_payment_date', '<=', $d_end)
        ->whereHas('booking', function ($query)  use ($data) {
            $query->where('booking_status_id',3)->where('marketname_id',$data['market']);
        })
        ->groupby('booking_id','booking_detail_date','booth_detail_id')
        ->orderBy('booking_payment_date', 'ASC')->get();
        // dd($booking);
        // $transactions = Transaction::where('status',"Y")->get();
        // dd( $transactions);
        // $transaction = Transaction_Detail::all();
        // $books = Booking::all();
        // $sumgrand_total = Transaction::where('status',"Y")->sum('amount');
        $tdhtml = '';
        $amount_total = 0;
        $beforevat_total = 0;
        $vat_total = 0;
        $service_charge_total = 0;
        $after_total = 0;
        $discount_total = 0;
        foreach ($bookings as $key => $booking) {

            //วันที่ขาย
            // $bookingdetaildate = "";
            // foreach ($transaction->transction_detail as $keyin => $transction_detail) {
            //     // dd($transction_detail);
            //     // $bookingdetaildate .= $transction_detail->booking_detail_date;
            //     foreach ($transction_detail->booking->bookdetail as  $value) {
            //     //     # code...
            //         $bookingdetaildate .= '<br>'.$value->booking_detail_date;
            //     }
            //     // $bookingdetaildate .= $value;
            // }
            // dd( $bookingdetaildate);

            $transaction = Transaction::where('status',"Y")
            ->join('transaction_details', 'transaction_master.trans_id', '=', 'transaction_details.trans_id')
            // ->join('transaction', 'transaction_details.trans_id', '=', 'transaction.trans_id')
            ->where('transaction_details.booking_id',$booking->booking_id)
            ->first();

            $transactiondtail  = Transaction_Detail::where('trans_id',$transaction->trans_id)->where('CartType','Charge')->first();
            $charge = 0;
            if ($transactiondtail != null) {
                $counttransactiondtail  = Transaction_Detail::where('trans_id',$transaction->trans_id)->where('CartType','Booking')->count();
                $auditDA  = AuditDetailsAccessories::where('booking_detail_id',$transactiondtail->charge_id)->first();
                $charge  = $auditDA->price/$counttransactiondtail;
            }

            // dd($transaction);
            $service_charge = 0;
            $countbookin = Booking_Detail::where('booking_id',$booking->booking_id)->count();

            $price = 0;
            if ($booking->boothdetail != null ) {
                 $price =  $booking->boothdetail->price;


            }

            if ($countbookin > 1) {
                $amount_area = $transaction->amount_area;

                    if ($transaction->amount_area == 0) {
                        $amount_area = 1;
                        // $charge = 1;
                    }
                // $price = 0;
                // if ($booking->boothdetail != null ) {
                //      $price =  $booking->boothdetail->price;
                //     if ($booking->boothdetail->booth_detail_id == 0) {
                //         $price =  $booking->booking_grand_total;
                //     }

                // }
                $amount = $price + (($transaction->amount_accessoire)/($amount_area)) ;
                $service_charge = ($transaction->service_charge)/($amount_area) + ($charge/$amount_area);
            }else{
                $amount = ($price + $booking->booking->booking_service_total);
                if ($booking->booth_detail_id == 0) {
                    // $price =  $booking->bookingdetail->booking_grand_total;
                    $amount = $booking->bookingdetail->booking_grand_total;
                }
                $service_charge = ($transaction->service_charge + $charge);
            }

            // $amount = $booking->boothdetail->price;
            $discount = 0;
            if($booking->booking->booking_coupon != null){
                $discount = $booking->booking->booking_coupon;
            }
            $beforevat = (($amount-$discount) * (100/107));

            // $vat = $beforevat * 0.07;

            $vat = ($amount-$discount) - $beforevat;

            // $transaction = $booking->transactiondetail->transaction;
            // dd($beforevat,$vat,$transaction->trans_id);
            $type_customer = "ลูกค้าทั่วไป";
            if ($booking->booking->booking_type == "Regular" && $booking->partners->space_customer_id != '') {
                    $type_customer = "ลูกค้าประจำ";
            }


            // if ($transaction != null) {
            //
            // }
            // $countbookin = Booking_Detail::where('booking_id',$booking->booking_id)->count();
            // if ($countbookin > 1) {
            //     $amount_area = $transaction->amount_area;
            //         if ($transaction->amount_area == 0) {
            //             $amount_area = 1;
            //         }
            //     $service_charge = ($transaction->service_charge+$transaction->amount_accessoire)/($amount_area) ;
            // }else{
            //     $service_charge = ($booking->booking->booking_service_total+$booking->booking->amount_accessoire);
            // }

            $amount_service_charge = $service_charge+$amount;
            // dd();
            if ($transaction != null) {
                $name_customer =  'ชื่อลูกค้า';
                if ($booking->partners != null) {
                    $name_customer =  $booking->partners->name_customer;
                }
                $namebooth = 'บูธเรียกเก็บพิเศษ';
                if ($booking->boothdetail != null) {
                    $namebooth =    $booking->boothdetail->name;
                }


                if($booking->partners->partners_type == 2){//นิติบุคคลไม่คิด
                    $vat3 = $beforevat*(3/100);
                }else{

                    $vat3 = 0;//ภาษีหัก ณ ที่จ่าย
                }


                $tdhtml .= '<tr class="text" >
                <td class="text" alt="ลำดับ">'.($key+1).'</td>
                <td class="text" alt="เลขที่ใบจอง">'.$transaction->trans_id.'</td>
                <td class="text" alt="ประเภทสมาชิก">'.$type_customer.'</td>
                <td class="text" alt="ชื่อบูธ">'. $namebooth.'</td>
                <td class="text" alt="วันที่จัดงาน">'.date('d/m/Y', strtotime($booking->booking_detail_date)).'</td>
                <td class="text" alt="ลูกค้า">'.$name_customer.'</td>
                <td class="text" alt="วันที่ชำระเงิน">'.date('d/m/Y', strtotime($transaction->payment_success_date)).'</td>
                <td class="text" alt="ค่าบริการ" algin="left">'.number_format($amount,2,".","").'</td>
                <td class="text" alt="ส่วนลด" algin="left">'.number_format($discount,2,".","").'</td>
                <td class="text" alt="จำนวนเงินก่อน VAT" algin="left">'.number_format($beforevat,2,".","").'</td>
                <td class="text" alt="VAT 7%" algin="left">'.number_format($vat,2,".","").'</td>
                <td class="text" alt="ภาษีหัก ณ ที่จ่าย" algin="left">'.number_format($vat3,2,".","").'</td>
                <td class="text" alt="ยอดที่ชำระ">'.number_format(($beforevat)+$vat-$vat3,2,".","").'</td>
                <td class="text" alt="ค่าธรรมเนียม">'.$service_charge.'</td>
                <td class="text" alt="ยอดรวมที่ชำระ">'.number_format((($beforevat)+$vat-$vat3)+$service_charge,2,".","").'</td>
                <td class="text" alt="สถานะ">ชำระเงิน</td>
                <td class="text" alt="หมายเหตุ">'.$transaction->channel.'</td>
            </tr>';
            }
            $beforevat_total += $beforevat;
            $vat_total += $vat;
            $amount_total += (($amount-$discount)+$service_charge);
            $service_charge_total += $service_charge;
            $after_total += $amount;
            $discount_total += $discount;
        }
        $tbodyhtml = '
        '.$tdhtml.'
        ';
        //dd($tdhtml);
        $data = array(
            'bookings' => $bookings,
            'd_start' => $d_start,
            'd_end' => $d_end,
            'tbodyhtml' => $tdhtml,
            'market' => $market,
            'amount_total' => $amount_total,
            'vat_total' => $vat_total,
            'beforevat_total' => $beforevat_total,
            'service_charge_total' => $service_charge_total,
            'after_total'=>$after_total,
            'discount_total'=>$discount_total,
        );

        return Excel::download(new BookExport("backend/report/pdf/pdf_audit_payment", $data), 'รายงานการชำระเงิน'.date('Y-m-d',time()).'.xlsx');
        //return view('backend/report/pdf/pdf_audit_payment',$data);

		//return $pdf->stream('รายงานการชำระเงิน.pdf');
    }
    // ===================================================

    // รายงานสรุปยอดขาย
    public function report_audit_summary(){
        $market = MK_MarketName::all();
        $data = array(
            'market' => $market,
        );
        return view('backend/report/report_audit_summary',$data);
    }

    public function report_audit_summary_pdf(Request $request){
        $d_start = $request->date_start;
        $d_end = $request->date_end;
        $data = array(
            'market' => $request->market_id,
            // 'd_start' => $d_start,
            // 'd_end' => $d_end,
            // 'tbodyhtml' => $tdhtml,
            // 'sumgrand_total' => $sumgrand_total,
        );
        $market_id = $request->market_id;
        $market = MK_MarketName::find($market_id);
        $bookings = Booking_Detail::whereDate('booking_detail_date', '>=', $d_start)
        ->where('booth_detail_id', '!=',0)
        ->whereDate('booking_detail_date', '<=', $d_end)
        ->whereHas('booking', function ($query)  use ($data) {
            $query->where('booking_status_id',3)->where('marketname_id',$data['market']);
        })->get();

        $tdhtml = '';
        foreach ($bookings as $key => $booking) {



            // dd($transaction);
            $amount = $booking->boothdetail->price;
            $beforevat = (($amount*100)/107);
            $vat = $amount-$beforevat;
            // $transaction = $booking->transactiondetail->transaction;
            // dd($beforevat,$vat,$transaction->trans_id);

                # code...
                $tdhtml .= '<tr class="text" >
                <td class="text">'.($key+1).'</td>
                <td class="text">'.$booking->booking_id.'</td>
                <td class="text">'.$booking->boothdetail->name.'</td>
                <td class="text">'.$booking->booking_detail_date.'</td>
                <td class="text">'.$booking->partners->name_customer.'</td>
                <td class="text">'.$booking->payment_success_date.'</td>
                <td class="text">'.$amount.'</td>
                <td class="text">ชำระเงินแล้ว</td>

            </tr>';


        }
        $tbodyhtml = '
        '.$tdhtml.'
        ';
        // dd($tdhtml);
        $data = array(
            'bookings' => $bookings,
            'd_start' => $d_start,
            'd_end' => $d_end,
            'tbodyhtml' => $tdhtml,
            'market' => $market,
            // 'sumgrand_total' => $sumgrand_total,
        );
        return Excel::download(new BookExport("backend/report/pdf/pdf_audit_summary", $data), 'รายงานสรุปยอดขาย'.date('Y-m-d',time()).'.xlsx');
        // $pdf = PDF::loadView('backend/report/pdf/pdf_audit_summary',['d_start'=>$d_start,'d_end'=>$d_end],[],['format'=>'A4-L']);
		// return $pdf->stream('รายงานสรุปยอดขาย.pdf');
    }
    // ===================================================


    public function report_audit_excel(){
        return view('backend/report/report_audit_excel');
    }


    // รายงานประเภทสินค้าที่ขาย
    public function report_audit_type(){
        $market = MK_MarketName::all();
        $data = array(
            'market' => $market,
        );
        return view('backend/report/report_audit_type',$data);
    }

    public function report_audit_type_pdf(Request $request){
        $d_start = $request->date_start;
        $d_end = $request->date_end;
        $data = array(
            'market' => $request->market_id,
            // 'd_start' => $d_start,
            // 'd_end' => $d_end,
            // 'tbodyhtml' => $tdhtml,
            // 'sumgrand_total' => $sumgrand_total,
        );
        $market_id = $request->market_id;
        $market = MK_MarketName::find($market_id);
        $bookings = Booking_Detail::whereDate('booking_detail_date', '>=', $d_start)
        ->whereDate('booking_detail_date', '<=', $d_end)
        ->whereHas('booking', function ($query)  use ($data) {
            $query->where('booking_status_id',3)->where('marketname_id',$data['market']);
        })->get();
        // dd($bookings,$d_start,$d_end);
        $tdhtml = '';
        foreach ($bookings as $key => $booking) {



            // dd($transaction);
            $amount = $booking->boothdetail->price;
            $beforevat = (($amount*100)/107);
            $vat = $amount-$beforevat;
            // $transaction = $booking->transactiondetail->transaction;
            // dd($beforevat,$vat,$transaction->trans_id);

                # code...
                $tdhtml .= '<tr class="text" >
                <td class="text">'.$booking->boothdetail->name.'</td>
                <td class="text">'.$booking->booking_id.'</td>
                <td class="text">'.$booking->boothdetail->producttype->name.'</td>
                <td class="text">'.$booking->partners->name_customer.'</td>
                <td class="text">'.$booking->payment_success_date.'</td>
                <td class="text">'.$amount.'</td>
                <td class="text">ใช้งาน</td>

            </tr>';


        }
        $tbodyhtml = '
        '.$tdhtml.'
        ';
        // dd($tdhtml);
        $data = array(
            'bookings' => $bookings,
            'd_start' => $d_start,
            'd_end' => $d_end,
            'tbodyhtml' => $tdhtml,
            'market' => $market,
            // 'sumgrand_total' => $sumgrand_total,
        );
        // return view('backend/report/pdf/pdf_audit_type',$data);

        return Excel::download(new BookExport("backend/report/pdf/pdf_audit_type", $data), 'รายงานประเภทสินค้า'.date('Y-m-d',time()).'.xlsx');
        // $pdf = PDF::loadView('backend/report/pdf/pdf_audit_type',['d_start'=>$d_start,'d_end'=>$d_end],[],['format'=>'A4']);
		// return $pdf->stream('รายงานประเภทสินค้าที่ขาย.pdf');
    }
     // ===================================================
    public function report_booking_exprot(Request $request){


        return view('backend/report/tem_export/report_book_all');
        // $pdf = PDF::loadView('backend/report/pdf/pdf_audit_type',['d_start'=>$d_start,'d_end'=>$d_end],[],['format'=>'A4']);
		// return $pdf->stream('รายงานประเภทสินค้าที่ขาย.pdf');
    }
    public function report_rent_exprot(Request $request){


        $bootall = MK_BoothDetail::all();

        $data = array(
            'bootall' => $bootall,
        );
        // return Excel::download(new InvoicesExport, 'invoices.xlsx');
        return Excel::download(new BookExport("backend.report.tem_export.report_rent_all", $data), 'AssetMasterTables'.date('Y-m-d',time()).'.xlsx');
        // return view('backend/report/tem_export/report_rent_all',$data);

        // $pdf = PDF::loadView('backend/report/pdf/pdf_audit_type',['d_start'=>$d_start,'d_end'=>$d_end],[],['format'=>'A4']);
		// return $pdf->stream('รายงานประเภทสินค้าที่ขาย.pdf');
    }
    // รายงานการจอง
    public function report_audit_rentroll(){

        $marketname = MK_MarketName::all();
        $booth = MK_Booth::all();
        $data = array(
            'marketname' => $marketname,
            'booth' => $booth,
        );
        return view('backend/report/report_audit_rentroll',$data);
    }

    public function report_audit_rentroll_pdf(Request $request){

        // $d_start = $request->date_start;
        // $d_end = $request->date_end;
        $month = ($request->month);
        // dd(date("n", strtotime($month)));
        $market_id = ($request->market_id);
        $market = MK_MarketName::find($market_id);
        $booth_id = ($request->booth_id);
        $fdata = array(
            'market_id' => $market_id,
            'booth_id' => $booth_id,
        );
        // dd($fdata);
        $boothdetail = MK_BoothDetail::
        whereHas('booth', function ($query)  use ($fdata) {
            $query->where('marketname_id',$fdata['market_id'])->where('booth_id',$fdata['booth_id']);
        })
        // ->orderByRaw('LENGTH(name)', 'ASC')
        // ->orderBy('name', 'ASC')
        // ->orderByRaw('SUBSTR(name FROM 1 FOR 1),
        // CAST(SUBSTR(name FROM 2) AS UNSIGNED)')
        ->orderBy(DB::raw("SUBSTR(name FROM 1 FOR 1),
        CAST(SUBSTR(name FROM 2) AS UNSIGNED)"))
        ->get();
        // dd($boothdetail);
        $html = '';
        // $find = [];
        foreach ($boothdetail as $key => $booth) {
            // $find[] = $booth;
            $status = "3";
            $findbooks =  Booking_Detail::
            whereMonth('booking_detail_date',date("n", strtotime($month)))
            ->where('booth_detail_id',$booth->booth_detail_id)
            ->whereHas('booking', function ($query)  use ($booth,$status) {
                // $query->orWhere('booking_status_id',2)->orWhere('booking_status_id',3);

                if ($status == "all") {
                    $query->Where('booking_status_id',2)->orWhere('booking_status_id',3);
                }else if($status == "2"){
                    $query->Where('booking_status_id',2);
                }else {
                    // dd($status);
                    $query->Where('booking_status_id',3);
                }

                // ->where('',1);
            })
        ->get();
        // dd($findbook);
        $htmltd = '';

        for ($i=0; $i < 31; $i++) {
           $finddate = null;
           $bc_date = $month.'-'.($i+1);
           $c_date = new DateTime($bc_date);
            // dd($c_month);
            //  $finddate = $this->checkbooking($booth->booth_detail_id,$c_date,'all');
            foreach ($findbooks as $key => $findbook) {
                $f_date = new DateTime($findbook->booking_detail_date);
                if ($f_date == $c_date) {
                    $finddate = $findbook;
                    $find[$booth->name] =  $findbook;
                }
            }
            //  $find = ($findbook->booking_detail_date == $c_month);
           $mess = "";
           $cstyle = '';
            if ($finddate != null) {
                $databook = $finddate;

                // if ($find->partners != null) {
                //     # code...
                //     $name = $find->partners->name;
                //     $lastname = $find->partners->lastname;
                //     $product = $find->partners->prtnersproduct->product->name;
                // }

                $mess = $booth->price;
                    $cstyle = 'background-color:#ffcc66 ';
                 if($databook->booking->booking_status_id == 3){
                    $cstyle = 'background-color: #99ff99';
                 }


            }

           $htmltd .= ' <td class="text"  style=" width: 15px; '.$cstyle.'" >'.$mess.'</td>';
        }

        $html .= '
        <tr  >
        <td style="background-color:#ACD8E5; height: 70px; width: 5px;" >'.$booth->name.'</td>
        <td style="background-color:#d5e7ed; height: 70px; width: 8px;" >'.$booth->price.'</td>
                '. $htmltd.'
        </tr>
        ';
        }
        // dd($find);
        $data = array(
            // 'd_start'=>$d_start,
            // 'd_end'=>$d_end,
            'html'=>$html,
            'month'=>$month,

        );

        // dd( $boothdetail);
        // return view('backend/report/pdf/pdf_booking',$data);
        // $pdf = PDF::loadView('backend/report/pdf/pdf_booking',$data);
        return Excel::download(new BookExport("backend/report/pdf/pdf_audit_reroll", $data), 'รายงานRentroll'.$market->name_market.date('Y-m-d',time()).'.xlsx');

		// return $pdf->stream('รายงานการจอง.pdf');
    }

    public function checkInsale(Request $request){
        $market = MK_MarketName::all();
        // $zone = MK_Zone::where('status','Y')->get()->groupBy('name');
        $zone = MK_Zone::where('status','Y')->get()->groupBy('marketname_id');
        $report = array();
        $idZone = array();
        $idZoneMk = array();
        $zoneName = array();
        foreach($zone as $i => $z){
            foreach($z as $c){
                if($request->zone == 'All'){
                    $idZone[] = $c->zone_id;
                    $idZoneMk[$c->marketname_id][] = $c->zone_id;
                }else if($c->zone_id == $request->zone){
                    $idZone[] = $c->zone_id;
                    $idZoneMk[$c->marketname_id][] = $c->zone_id;
                }
            }
        }
        $zone_id = $request->zone;
        $checkArray = array();
        $allData = array();
        foreach($zone as $i => $z){
            $zone_id == 'All' ? $check = 'selected' : $check = null;
            $fillZone[$i] = "<option value='All' $check>All</option>";
            foreach($z as $o){
                $checkArray[$i][] = $o->zone_id;
                $zoneName[$o->zone_id] = $o->name;
                $o->zone_id == $zone_id ? $check = 'selected' : $check = null;
                $fillZone[$i] = $fillZone[$i] . "<option value='$o->zone_id' $check>$o->name</option>";
            }

        }
        // dd($zoneName);
        if($request->market_id){
            $getBooth = MK_Booth::where(['marketname_id' => $request->market_id,'status' => 'Y'])
                ->whereYear('date_start',date('Y',strtotime($request->date)))
                ->whereMonth('date_start',date('m',strtotime($request->date)))
                ->first();
            if($getBooth){
            isset($idZoneMk[$getBooth->marketname_id]) ? $onezone = $idZoneMk[$getBooth->marketname_id] : $onezone = array();

                if(count($onezone) > 0){
                    foreach($idZone as $iz){
                        if(in_array($iz,$onezone)){
                            $report = array();
                            $report['booth'] = MK_BoothDetail::where(['booth_id' => $getBooth->booth_id,'zone_id' => $iz, 'status' => 'Y'])
                            ->orderBy('booth_detail_id','asc')->get();
                            foreach( $report['booth'] as $i => $b){
                                $booking = Booking_Detail::find($b->booth_detail_id);
                                if($booking){
                                    $partner = Partners::find($booking->partners_id);
                                    $report['partner'][$i]['partner'] = "$partner->name_customer";
                                    $report['checkIn'][$i] = $booking->check_in_status;
                                    $productId = PartnersProduct::where('partners_id',$partner->partners_id)->first();
                                    $product = Product::find($productId->product_id);
                                    $report['partner'][$i]['product'] = @$product->name;
                                }else{
                                    $report['partner'][$i] = null;
                                    $report['checkIn'][$i] = null;
                                }
                            }
                            if(count($report['booth']) > 0){
                                $allData[$zoneName[$iz]] = $report;
                            }
                        }
                    }
                }
            }
        }
        if($request->excel){
            $report['data'] = json_decode($request->data,true);
            $report['market'] = MK_MarketName::find($request->excel);
            $report['date'] = $request->date;
            return $this->excel->download(new reportCheckIn($report), "CheckInReport.xlsx");
        }

        $data = array(
            'market' => $market,
            'reportAll' => $allData,
            'mkId' => $request->market_id,
            'sdate' => $request->date,
            'zone' => $fillZone,
            'javaZ' => json_encode($fillZone),
            'rzone' => $request->zone
        );
        return view('backend/report/report_audit_checkInsale',$data);
    }
}
