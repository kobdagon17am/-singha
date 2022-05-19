<?php

namespace App\Http\Controllers\Market;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Default
use Response;
use Auth;
use Image;
use Yajra\Datatables\Datatables;

// Model
use App\Model\MK_MarketName;
use App\Model\MK_Booth;
use App\Model\MK_BoothDetail;
use App\Model\MK_Floor;
use App\Model\MK_Zone;
use App\Model\MK_BoothType;


class BoothZoneControoler extends Controller
{
    public function index(){
        dd("index");
        $eventcategorys = Eventcategory::all();
        $data = array(
            'eventcategorys' => $eventcategorys,
        );
    return view('backend.event.index',$data);
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
        // dd($request->all());
        $event = new Event;
        $event->title_event = $request->title_event;
        $event->id_event_category_f = $request->id_event_category;
        $event->date_start = formatsdate($request->date_start);
        $event->time_start = $request->time_start;
        $event->date_end = formatsdate($request->date_end);
        $event->time_end = $request->time_end;
        $event->location = $request->location;
        $event->save();
        return response()->json([
            'status' => "pass",
            'data' => $event,
        ]);
    }
    public function datatable() {

        $marketID = request('marketID');
        $boothID = request('boothID');
        // dd($marketID);
        // $booth = MK_Booth::where('marketname_id',$marketID)->get();
        $market_zone = MK_Zone::where('marketname_id',$marketID)->get();
        // dd($market_zone);
        $sQuery	 = Datatables::of($market_zone)


        // ชื่อ Zone
        ->editColumn('colum_zone',function($data){
            return $data->name;
        })

        // สถานะ
        ->editColumn('colum_status',function($data){
            if($data->status == "Y"){
                $status_t = '<font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>';
            }else{
                $status_t = '<font color="red"><p title="ยกเลิก"><i class="fa fa-times-circle"></i> ยกเลิก</p></font>';
            }
            return $status_t;
        })

        // จัดการ
        // ->editColumn('colum_manage',function($data){
        //     $url = url('boothzone/'.$data->zone_id);
        //     return '<a href="'.$url.'" ><button type="button" class="btn-dark"><i class="fa fa-search"></i> ดูข้อมูล Booth</button></a>';

        // });
        ->editColumn('colum_manage',function($data) use ($boothID){

            $url = url('/backoffice/market/booth-detail/'.$boothID.'/'.$data->zone_id.'');
            return '<a href="'.$url.'" class="btn-dark model-data btn-sm" ><i class="fa fa-search"></i> ดูข้อมูล Booth ใน Zone</a>
            ';

        });
        return $sQuery->escapeColumns([])->make(true);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        // dd($id);
        $mk_booth = MK_Booth::find($id);
        $mk_marketname = MK_MarketName::find($mk_booth->marketname_id);
        $mk_zone = MK_Zone::where('marketname_id',$mk_marketname->marketname_id)->get();
        // dd($mk_zone);
        $data = array(
            'mk_marketname' => $mk_marketname,
            'mk_zone' => $mk_zone,
            'id' => $id,
        );
        return view('backend.market.boothzone',$data);
        // return $foodtype;
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
        $event = Event::find($id);
        return $event;
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
        // dd($event,$id);
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
    public function destroy($id)
    {

        $event = Event::find($id);
        $event->delete();
        return "sussec";
    }
    public function calendar_event(Request $request)
    {

        $event = Event::all();
        $result = [];
        $now = new  DateTime('2020-03-18');
        // dd($now);
        // dd($books);
        $daytoday = $now->getTimestamp();
        $events = DB::table('tb_event')
                    ->leftJoin('tb_event_category', 'tb_event.id_event_category_f', '=', 'tb_event_category.id_event_category')
                    ->get();

        foreach ($events as $key => $value) {
            # code...
            $data[] = array(
                'id' => $value->id_event,
                'title'=> $value->title_event,
                'start'=> $value->date_start,
                'end'=> $value->date_end,
                'color'=> $value->color,
                //   url: 'http://google.com/'
            );
        }




        // $data = array(
        //     'event' => $events,
        // );
        // $data = array(
        //     'id' => "55555",
        // );
        // dd($data);
        return $data;

        // return json_encode(array('id' => $events));
    }
}
