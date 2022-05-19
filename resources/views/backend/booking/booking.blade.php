@extends('backend/inc_main') {{-- main.blade.php --}}

@section('title','| All Tags')

@section('stylesheet')
<style>
    .actions_one {
        background-color: #309113;
        border-color: #297c10;
    }
    .booth-data:hover, .sweet-alert button.confirm:hover, .wizard>.actions a:hover {
    background-color: #309113;
    border-color: #297c10;
    }
    .booth-data:focus, .sweet-alert button.confirm:focus, .wizard>.actions a:focus {
    box-shadow: none;
    color: #ffffff;
    background-color: #309113;
    border-color: #297c10;
    }
    a.disableda {
        pointer-events: none;
        cursor: default;
    }
    p.import-td {
        margin: 0 0 1.7px;
    }
</style>
@endsection

@section('content')


{{-- content --}}
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card tabs-card">
                        {{-- header --}}
                        <input type="hidden" name="" value="{{$id}}" id="marketname_id">
                        <div class="card-header">
                            <h4>ข้อมูลการจอง</h4>
                            <p class="text-muted m-b-10">รายละเอียดข้อมูลการจอง Booth </p>
                            <ul class="breadcrumb-title b-t-default p-t-10">

                            </ul>

                        </div>

                        <!-- block -->
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        <p class="text-muted m-b-10">ตัวเลือก</p>
                                        <div class="form-group">

                                            <a href="#" class="btn btn-inverse btn-round " data-toggle="modal"
                                                data-target="#modal_add"><i class="fa fa-plus"></i> เพิ่มข้อมูลจอง
                                                Booth</a>
                                            <a href="#" class="btn btn-inverse btn-round " data-toggle="modal"
                                                data-target="#modal_upload"><i class="fa fa-plus"></i>
                                                อัพโหลดตารางการจองบูธประจำ</a>
                                            <a href="#" class="btn btn-inverse btn-round " data-toggle="modal"
                                                data-target="#modal_upload_more" onclick="resetform('form_import_more','table_import_more')"><i class="fa fa-plus"></i>
                                                อัพโหลดเรียกเก็บเพิ่มเติม</a>
                                            <a href="#" class="btn btn-inverse btn-round " data-toggle="modal"
                                                data-target="#modal_upload_discount" onclick="resetform('form_import_discount','table_import_discount')"><i class="fa fa-plus"></i>
                                                อัพโหลดส่วนลด</a>
                                            <a href="#" class="btn btn-inverse btn-round "
                                                onclick="sentnotification_overdue()">
                                                <i class="fa fa-bell"></i>ส่ง notification เรียกเก็บ</a>

                                        </div>
                                        <p class="text-muted m-b-10">ค้นหาการจอง</p>
                                        <div class="form-group row">

                                            <div class="col-2">
                                             <h6>เดือนที่ทำการค้นหา</h6>
                                            <input type="month" class="form-control" id="datesearch_start"
                                                value="{{date("Y-m")}}" onchange="datesearch()">
                                            </div>
                                            <div class="col-2">
                                                <h6>สถานะการจอง</h6>
                                                <select class="form-control form-control-normal" name="marketname_id" id="status_booking" onchange="datesearch()">
                                                <option value="2">รอชำระเงิน</option>
                                                <option value="3">ชำระเงินแล้ว</option>
                                                <option value="4">ยกเลิกการจองโดยสมาชิก</option>
                                                <option value="5">ยกเลิกการจองโดย Admin</option>
                                                <option value="6">หมดเวลาการจอง</option>


                                            </select>
                                            </div>

                                            {{-- <div class="col-2">
                                                <h6>วันสิ้นสุด</h6>
                                                <input type="date" class="form-control" id="datesearch_end"
                                                value="{{date("Y-m-d")}}" onchange="datesearch()">
                                            </div> --}}
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="dt-responsive table-responsive">
                                <table id="datatables" class="table  table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">เลขที่ใบจอง</th>
                                            <th class="text-center" width="10%">ชื่อบูธ</th>
                                            <th class="text-center">วันที่การจอง</th>
                                            <th class="text-center">สถานะ</th>
                                            <th class="text-center">ชื่อผู้จอง</th>
                                            {{-- <th class="text-center">วันที่ทำรายการ</th> --}}
                                            <th class="text-center">ประเภทลูกค้า</th>
                                            <th class="text-center">ส่วนลดที่ได้</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    @include('backend/inc_footer')
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modal_add" role="dialog">
    <form method="POST" id="form_booking">
        {{-- {!! csrf_field() !!} --}}
        <div class="modal-dialog modal-lg" id="reload_add">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">รายละอียดการจอง</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <div class="card">
                        <div class="card-block">

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">ชื่อลูกค้า</label>
                                <div class="col-sm-4" id=countryList>
                                    <input class=" form-control" type="text" name="partners_name" id="partners_name"
                                        readonly>
                                </div>
                                <input type="hidden" id="partners_id" name="partners_id">
                                <div class="col-sm-4" id=countryList>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal_serach_customer">ค้นหาลูกค้า</button>
                                </div>
                                {{-- <div class="col-sm-4" id=countryList> --}}
                                {{-- <input id="partners_id" class="form-control" type="text"> --}}
                                {{-- </div> --}}
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">ตลาด</label>
                                <div class="col-sm-8">
                                    <select class="form-control form-control-normal" name="marketname_id"
                                        id="select_marketname" onchange="select_booth_detail()">
                                        <option value="">กรุณาเลือกตลาด</option>
                                        @foreach ($marketnames as $marketname)
                                        <option value="{{$marketname->marketname_id}}">{{$marketname->name_market}}
                                        </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">โมเดลแผนผัง</label>
                                <div class="col-sm-8">
                                    <select class="form-control form-control-normal" name="" id="select_booth"
                                        onchange="select_booth_detail()">
                                        <option value="">โมเดลแผนผัง</option>
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label class="col-sm-4 col-form-label">ชั้น</label>
                                <div class="col-sm-8">
                                    <select class="form-control form-control-normal" name="" id="select_floor"
                                        onchange="select_booth_detail()">
                                        <option value="">กรุณาเลือกชั้น</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">โซน</label>
                                <div class="col-sm-8">
                                    <select class="form-control form-control-normal" name="" id="select_zone"
                                        onchange="select_booth_detail()">
                                        <option value="">กรุณาเลือกโซน</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">เลือกวันที่</label>
                                <div class="col-sm-5">
                                    {{-- <input type="hidden" name="date_booking" id="date_booking"
                                        class="form-control form-control-normal" required="" value=""> --}}

                                    <input type="date" class="form-control form-control-normal" name="bd_booking_date"
                                        id="date_booking" autocomplete="off" required=""
                                        onchange="select_booth_detail()">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label ">วันแจ้งเตือน</label>
                                <div class="col-sm-5">
                                    <input type="date" class="form-control" name="date_noti" id="date_noti"
                                        autocomplete="off" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label ">วันหมดอายุ</label>
                                <div class="col-sm-5">
                                    <input type="datetime-local" class="form-control" name="date_timeout" id="date_timeout"
                                        autocomplete="off" required="">
                                </div>
                            </div>
                            <div id="date_html">

                            </div>
                            {{-- <div class="form-group row">
                                <label class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-8">
                                    <button type="button" class="btn btn-info" onclick="adddate()">เพิ่ม</button>
                                </div>
                            </div> --}}




                        </div>
                    </div>
                    <div id="lok">
                        <div class="card">


                            <div class="card-block remove-label" id="booth_detail">

                            </div>


                        </div>
                        <input type="hidden" id="booth_detail_id" name="booth_detail_id">
                        <div class="card">
                            <div class="card-block" id="option">
                                <div class="form-group row">
                                    <h6><label class="col-12 col-form-label">บริการเสริม</label></h6>
                                </div>
                                @foreach ($services as $item)
                                <div class="form-group row"><label class="col-9 col-form-label">{{$item->name}} </label>
                                    <div class="col-3">
                                        <input type="hidden" name="at_id[]" value="{{$item->service_id}}">
                                        <select name="qty[{{$item->service_id}}]" class="form-control form-control-primary">
                                            <option  value="">ไม่รับ</option>
                                            @for ($i = 0; $i < $item->amount; $i++)
                                                <option >{{$i+1}}</option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>
                                @endforeach



                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        <button type="button" class="btn btn-primary" id="submit_add" onclick="add()" >บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
{{-- Modal Bookng --}}
<div class="modal fade" id="modal_serach_customer" role="dialog" data-show="true">
    <form method="POST" id="form_booking">
        {!! csrf_field() !!}
        <div class="modal-dialog " id="reload_add">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">ค้นหาลูกค้า</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <div class="card">
                        <div class="card-block">
                            {{-- <div class="form-group row" id="search_customer">
                                <input type="text" class="form-group "  onkeyup="search_customer( this.value )">
                            </div> --}}
                            <div class="form-group row">
                                <input type="text" class="form-control form-control-normal"
                                    onkeyup="search_customer( this.value )" placeholder="ชื่อลูกค้า">
                            </div>
                            <div class="form-group row" id="search_customer_div">
                                <table id="search_customer" class="table  table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ชื่อลูกค้า</th>
                                            <th class="text-center">เลือก</th>

                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>

                        {{-- <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                            <button class="btn btn-primary" id="submit_add" onclick="add()">บันทึก</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
{{-- Modal Bookng --}}
<div class="modal fade" id="modal_booking" role="dialog" data-show="true">
    <form method="POST" id="form_booking">
        {!! csrf_field() !!}
        <div class="modal-dialog modal-lg" id="reload_add">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">รายละอียดการจอง</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <div class="card">
                        <div class="card-block">


                            <div class="dt-responsive table-responsive" id="htmltable">
                                {{-- <table id="datatables" class="table  table-bordered" width="100%">
                                    <thead>
                                        <tr>

                                            <th class="text-center">ตลาด</th>
                                            <th class="text-center">ชื่อบูธ</th>
                                            <th class="text-center">วันที่จอง</th>
                                            <th class="text-center">ราคา</th>
                                        </tr>
                                    </thead>


                                    <tbody id="trdetail" align="center">

                                        <tr>
                                            <td></td>

                                        </tr>

                                    </tbody>
                                </table> --}}

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        {{-- <button class="btn btn-primary" id="submit_add" onclick="add()">บันทึก</button> --}}
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
{{-- Modal Bookng --}}
<div class="modal fade" id="modal_confirmbook" role="dialog" data-show="true">
    <form method="POST" id="form_confirmbooking">
        {!! csrf_field() !!}
        <div class="modal-dialog " id="reload_add">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">ยืนยันการจอง</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <div class="card">
                        <div class="card-block">

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">อัพโหลดรูปภาพหลักฐานยืนยัน:</label>
                                <div class="col-sm-5">
                                    <img src="{{asset('public/assets/backend/img/wait_img.png')}}" id="PreviewImage_e"
                                        class="img-fluid img-responsive">
                                    {{-- <p class="c-red">รูปภาพรายละเอียดบูธ ขนาดรูปภาพ xxx * xxx px</p> --}}
                                    <input type="file" class="form-control" name="confirmbook" id="fileimg_gallery_e"
                                        onchange="readURL_Edit(this);" autocomplete="off" required="">
                                </div>
                            </div>

                        </div>
                        <input type="hidden" id="booking_id" name="booking_id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                            <button class="btn btn-primary" type="button" onclick="submitconfirmbook()">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
{{-- Modal Bookng --}}
<div class="modal fade" id="modal_upload" role="dialog" data-show="true">

    <form method="POST" action="{{ route('file-import') }}" enctype="multipart/form-data" id="form_import">
        {!! csrf_field() !!}
        <div class="modal-dialog modal-lg" id="reload_add">
            <div class="modal-content ">
                <div class="modal-header">
                    <h4 class="modal-title ">อัพโหลด flie excel ตาราการจองบูธประจำ</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <div class="card">
                        <div class="card-block">

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">อัพโหลดflie excel:</label>
                                <div class="col-sm-5">
                                    {{-- <img src="{{asset('public/assets/backend/img/wait_img.png')}}"
                                    id="PreviewImage_e"
                                    class="img-fluid img-responsive" > --}}
                                    {{-- <p class="c-red">รูปภาพรายละเอียดบูธ ขนาดรูปภาพ xxx * xxx px</p> --}}
                                    <input type="file" class="form-control" name="confirmbook" id="fileimg_gallery_e"
                                        onchange="readURL_Edit(this);" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">เดือน</label>
                                <div class="col-sm-5">
                                    <input type="month" class="form-control" name="month_import" id="month_import"
                                        autocomplete="off" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">ตลาด</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="market_id" id="market_id" required>
                                        <option value="">เลือกตลาด</option>
                                        @foreach ($marketnames as $item)
                                        <option value="{{$item->marketname_id}}">{{$item->name_market}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">แผนผังบูธ</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="booth_id" id="booth_id" required>
                                        <option value="">เลือกผัง</option>
                                        @foreach ($boothstandby as $item)
                                        <option value="{{$item->booth_id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">วันแจ้งเตือน</label>
                                <div class="col-sm-5">
                                    <input type="date" class="form-control" name="date_noti" id="date_noti"
                                        autocomplete="off" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">วันหมดอายุ</label>
                                <div class="col-sm-5">
                                    <input type="date" class="form-control" name="date_timeout" id="date_timeout"
                                        autocomplete="off" required="">
                                </div>
                            </div>
                            <div class="form-group row" id="table_import">

                            </div>
                        </div>

                        <input type="hidden" id="booking_id" name="booking_id">
                        <input type="hidden" id="status" name="status">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                            <button type="button" class="btn btn-warning"
                                onclick="checkexcel('checkexcel')">ตรวจสอบไฟล์</button>
                            <button type="button" class="btn btn-primary" onclick="importfile('insert')"
                                id="insert_button" style="display: none">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="modal_upload_more" role="dialog" data-show="true">
    {{-- <form action="{{ route('file-import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
        <div class="custom-file text-left">
            <input type="file" name="file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
    </div>
    <button class="btn btn-primary">Import data</button>
    <a class="btn btn-success" href="{{ route('file-export') }}">Export data</a>
    </form> --}}
    <form method="POST" action="{{ route('file-import-more') }}" enctype="multipart/form-data"  id="form_import_more">
        {!! csrf_field() !!}
        <div class="modal-dialog modal-lg" id="reload_add">
            <div class="modal-content ">
                <div class="modal-header">
                    <h4 class="modal-title ">อัพโหลดเรียกเก็บเพิ่มเติม</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <div class="card">
                        <div class="card-block">
                            <input type="hidden" name="status" id="statusmore">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">อัพโหลดflie excel:</label>
                                <div class="col-sm-5">

                                    {{-- <img src="{{asset('public/assets/backend/img/wait_img.png')}}"
                                    id="PreviewImage_e"
                                    class="img-fluid img-responsive" > --}}
                                    {{-- <p class="c-red">รูปภาพรายละเอียดบูธ ขนาดรูปภาพ xxx * xxx px</p> --}}
                                    <input type="file" class="form-control" name="confirmbook" id="fileimg_gallery_e"
                                        onchange="readURL_Edit(this);" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row" id="table_import_more">

                            </div>

                        </div>
                        <input type="hidden" id="market_id" name="market_id" value="{{$id}}">
                        <input type="hidden" id="booking_id" name="booking_id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                            <button type="button" class="btn btn-warning" onclick="checkexcelmore('checkexcelmore')">ตรวจสอบไฟล์</button>
                            <button type="button" class="btn btn-primary" style="display: none" id="insert_button_more" onclick="importfilemore('insert')" >บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="modal_upload_discount" role="dialog" data-show="true">
    <form method="POST" action="{{ route('file-import-discount') }}" enctype="multipart/form-data"  id="form_import_discount">
        {!! csrf_field() !!}
        <div class="modal-dialog modal-lg" id="reload_add">
            <div class="modal-content ">
                <div class="modal-header">
                    <h4 class="modal-title ">อัพโหลดส่วนลด</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <div class="card">
                        <div class="card-block">
                            <input type="hidden" name="status" id="statusdiscount">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">เดือนที่ให้ส่วนลด:</label>
                                <div class="col-sm-5">
                                    <input type="month" class="form-control" id="date_discount" value="{{date("Y-m")}}" name="date">
                                </div>
                                <label class="col-sm-4 col-form-label text-right">อัพโหลดflie excel:</label>
                                <div class="col-sm-5">
                                    <input type="file" class="form-control" name="confirmbook" id="fileimg_gallery_e"
                                        onchange="readURL_Edit(this);" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row" id="table_import_discount">

                            </div>
                        </div>
                        <input type="hidden" id="market_id" name="market_id" value="{{$id}}">
                        <input type="hidden" id="booking_id" name="booking_id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                            <button type="button" class="btn btn-warning" onclick="checkexceldiscount('checkexcel')">ตรวจสอบไฟล์</button>
                            <button type="button" class="btn btn-primary" style="display: none" id="insert_button_discount" onclick="importfilediscount('insert')" >บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('script')
{{-- <script>
    $(document).ready(function(){
        var route_URL = "{{ route('backend') }}"; // URL
$(".pcoded-left-item>li a[href='"+route_URL+"']").parent().addClass("active");
});
</script> --}}
<script>
    $(document).ready(function () {
        var oTable = $("#datatables").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthChange: true,
            stateSave: true,

            ajax: {
                url: "{{ route('api.booking.datatable_booking') }}",
                type: "POST",
                data: function (d) {
                    d.marketname_id = $('#marketname_id').val(); // สถานะ
                    d.datesearch_start = $('#datesearch_start').val(); // วันเริ่ม
                    d.status_booking = $('#status_booking').val(); // วันเริ่ม
                    // d.datesearch_end = $('#datesearch_end').val(); // วันเริ่ม
                },

            },

            columns: [{
                    'className': "text-center",
                    data: 'booking_id',
                    name: 'booking_id'
                },
                {
                    'className': "text-center",
                    data: 'boothdetail',
                    name: 'boothdetail'
                },
                {
                    'className': "text-center",
                    data: 'datebooking',
                    name: 'datebooking'
                },
                {
                    'className': "text-center",
                    data: 'booking_status',
                    name: 'booking_status'
                },
                {
                    'className': "text-center",
                    data: 'partners',
                    name: 'partners'
                },
                // {
                //     'className': "text-center",
                //     data: 'created_at',
                //     name: 'created_at'
                // },
                {
                    'className': "text-center",
                    data: 'type_customer',
                    name: 'type_customer'
                },
                {
                    'className': "text-center",
                    data: 'discount_all',
                    name: 'discount_all'
                },

                {
                    'className': "text-center",
                    data: 'manage',
                    name: 'manage'
                },

            ],
            order: [
                [0, 'ASC']
            ],
            rowCallback: function (row, data, index) {
                // rowCallback
            }

        });

        // Sort Status | Datatable
        $('#status_val').change(function (e) {
            oTable.draw();
        });
    });

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

<script>
    function resetform(id,table) {
        $('#'+id)[0].reset();
        $('#'+table).html(' ');
        // alert("เปลียนวัน");

    }
    function datesearch() {
        // alert("เปลียนวัน");
        $('#datatables').DataTable().ajax.reload();
    }

    function readURL_Edit(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#PreviewImage_e').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    // Find Booth
    function select_booth_detail() {
        let select_market = $('#select_marketname').val();
        let select_booth = $('#select_booth').val();
        let select_floor = $('#select_floor').val();
        let select_zone = $('#select_zone').val();
        let date_booking = $('#date_booking').val();
        // e.preventDefault();

        $.ajax({
            url: "{{ route('api.booking.selectmarket') }}",
            data: {
                select_market: select_market,
                select_booth: select_booth,
                select_floor: select_floor,
                select_zone: select_zone,
                date_booking: date_booking,
            },
            type: "POST",
            async: false,

            success: function (data) {
                console.log(data);
                $('#select_floor').html(data.htmlfloor);
                $('#select_zone').html(data.htmlzone);
                $('#select_booth').html(data.htmlbooth);
                $('#booth_detail').html(data.htmlbooth_detail);

                $('#select_zone').val(data.zone_id);
                // $('#booth_id').val(data.booth_id);
                // $('#floor_id').val(data.floor_id);


            }
        });
    }

    function checkexcel(val) {
        // e.preventDefault();
        $('#status').val(val);
        var formData = new FormData($('#form_import')[0]);
        console.log(formData);
        $.ajax({
            url: "{{ url('file-import') }}",
            data: formData,
            type: "POST",
            async: false,
            contentType: false,
            processData: false,
            success: function (data) {

                $('#table_import').html(data.html)
                if (data.result == "check") {

                    $('#insert_button').show();
                }
                // $('#modal_add').modal('hide') // modal add hide
                // if (data.response == true) {
                //     swal({
                //         title: data.title,
                //         text: data.text,
                //         icon: "success",
                //         button: "ยืนยัน",
                //     }).then((value) => {
                //         // window.location.reload();
                //         $('#datatables').DataTable().ajax.reload();
                //     });
                // }
            }
        });
    }

    function checkexcelmore(val) {
        // e.preventDefault();
        // alert(val);
        $('#statusmore').val(val);
        var formData = new FormData($('#form_import_more')[0]);
        console.log(formData);
        $.ajax({
            url: "{{ url('file-import-more') }}",
            data: formData,
            type: "POST",
            async: false,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data);
                $('#table_import_more').html(data.html)
                if (data.result == "check") {

                    $('#insert_button_more').show();
                }
                // $('#modal_add').modal('hide') // modal add hide
                // if (data.response == true) {
                //     swal({
                //         title: data.title,
                //         text: data.text,
                //         icon: "success",
                //         button: "ยืนยัน",
                //     }).then((value) => {
                //         // window.location.reload();
                //         $('#datatables').DataTable().ajax.reload();
                //     });
                // }
            }
        });
    }
    function checkexceldiscount(val) {
        $('#statusdiscount').val(val);
        var formData = new FormData($('#form_import_discount')[0]);
        console.log(formData);
        $.ajax({
            url: "{{ url('file-import-discount') }}",
            data: formData,
            type: "POST",
            async: false,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data);
                $('#table_import_discount').html(data.html)
                if (data.result == "check") {
                    $('#insert_button_discount').show();
                }
            }
        });
    }
    function importfile(val) {
        bootbox.confirm({
            title: "ยืนยัน ?",
            message: "ยืนยันการ import ข้อมูลบูธประจำ ใช่หรือไม่?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> ยกเลิก',
                    className: 'btn-danger'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> ยืนยัน',
                    className: 'btn-success'
                }
            },
            callback: function (result) {
                if (result == true) {
                    $('#status').val(val);
                    $('#form_import').submit();
                    // e.preventDefault();
                    // $('#status').val(val);
                    // var formData =  new FormData($('#form_import')[0]);
                    // console.log(formData);
                    // $.ajax({
                    //     url: "{{ url('file-import') }}",
                    //     data: formData,
                    //     type: "POST",
                    //     async: false,
                    //     contentType: false,
                    //     processData: false,
                    //     success: function (data) {

                    //         $('#table_import').html(data.html);
                    //         $('#modal_upload').modal('hide');
                    //         // $('#modal_add').modal('hide') // modal add hide
                    //         // if (data.response == true) {
                    //         //     swal({
                    //         //         title: data.title,
                    //         //         text: data.text,
                    //         //         icon: "success",
                    //         //         button: "ยืนยัน",
                    //         //     }).then((value) => {
                    //         //         // window.location.reload();
                    //         //         $('#datatables').DataTable().ajax.reload();
                    //         //     });
                    //         // }
                    //     }
                    // });
                }
            }
        });

    }
    function importfilemore(val) {
        bootbox.confirm({
            title: "ยืนยัน ?",
            message: "ยืนยันการ import ข้อมูลบูธประจำ ใช่หรือไม่?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> ยกเลิก',
                    className: 'btn-danger'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> ยืนยัน',
                    className: 'btn-success'
                }
            },
            callback: function (result) {
                if (result == true) {
                    $('#statusmore').val(val);
                    $('#form_import_more').submit();

                }
            }
        });

    }
    function importfilediscount(val) {
        bootbox.confirm({
            title: "ยืนยัน ?",
            message: "ยืนยันการ import ข้อมูลบูธประจำ ใช่หรือไม่?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> ยกเลิก',
                    className: 'btn-danger'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> ยืนยัน',
                    className: 'btn-success'
                }
            },
            callback: function (result) {
                if (result == true) {
                    $('#statusdiscount').val(val);
                    $('#form_import_discount').submit();

                }
            }
        });

    }

    // Booking
    function add() {
        // e.preventDefault();
        var formData = new FormData($('#form_booking')[0]);
        console.log(formData);
        $('#submit_add').attr("disabled", true);
        $.ajax({
            url: "{{ route('booking.store') }}",
            data: formData,
            type: "POST",
            async: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#modal_add').modal('hide') // modal add hide
                if (data.response == true) {
                    swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "ยืนยัน",
                    }).then((value) => {
                        // window.location.reload();
                        $('#form_booking')[0].reset();
                        $('#booth_detail').html('');

                        $('#datatables').DataTable().ajax.reload();
                        $('#submit_add').removeAttr("disabled");
                    });
                }
            }
        });

    }
    // CancleBooking
    function cancle(keepId) {
        bootbox.prompt({
            title: "<h5>คุณต้องยกเลิกใบจอง <br> <font color='red'>" + keepId + "</font> นี้หรือไม่ ?<h5>",
            placeholder: 'กรุณาใส่หมายเหตุ',
            inputType: 'text',
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> ยกเลิก',
                    className: 'btn-danger'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> ยืนยัน',
                    className: 'btn-success'
                }
            },
            callback: function (result) {
                console.log(result);
                if (result != "" && result != null) {
                    $.ajax({
                        url: "{{url('/backoffice/booking')}}/" +
                            keepId, //ส่งข้อมูลไปทีไฟล์ delete.php
                        data: {
                            _method: "DELETE",
                            why: result,
                            id: keepId
                        }, //ส่งข้อมูลไปในรูปแบบ JSON
                        type: "POST",
                        async: false,
                        success: function (data) {
                            if (data.response == true) {
                                swal({
                                    title: data.title,
                                    text: data.text,
                                    icon: "success",
                                    button: "OK",
                                }).then((value) => {
                                    $('#datatables').DataTable().ajax.reload();
                                });
                            }
                        }
                    });
                }
            }
        });
    }
    // CancleBooking
    function confirmbook(keepId) {
        $('#booking_id').val(keepId);
        console.log(keepId);
        $('#modal_confirmbook').modal('show') // modal add hide
        // bootbox.confirm({
        // 	title: "ยืนยัน ?",
        // 	message: "คุณต้องยกเลิกใบจอง <font color='red'>"+keepId+"</font> นี้หรือไม่ ?",
        // 	buttons:{
        // 		cancel: {
        // 			label: '<i class="fa fa-times"></i> ยกเลิก',
        // 			className: 'btn-danger'
        // 		},
        // 		confirm:{
        // 			label: '<i class="fa fa-check"></i> ยืนยัน',
        // 			className: 'btn-success'
        // 		}
        // 	},
        // 	callback: function (result){
        // 		if(result == true){
        // 			$.ajax({
        //             url: "{{url('/backoffice/booking')}}/" + keepId, //ส่งข้อมูลไปทีไฟล์ delete.php
        //             data: {
        //                 _method: "DELETE",
        //                 id: keepId
        //             }, //ส่งข้อมูลไปในรูปแบบ JSON
        // 			type: "POST",
        // 			async:false,
        //             success:function(data){
        //                     if(data.response==true){
        //                         swal({
        //                         title: data.title,
        //                         text: data.text,
        //                         icon: "success",
        //                         button: "OK",
        //                         }).then((value) => {
        //                             $('#datatables').DataTable().ajax.reload();
        //                         });
        //                     }
        //                 }
        // 			});
        // 		}
        // 	}
        // });
    }

    function submitconfirmbook() {
        var formData = new FormData($('#form_confirmbooking')[0]);
        console.log(formData);
        $.ajax({
            url: "{{ route('api.booking.submitconfirmbook') }}",
            data: formData,
            type: "POST",
            async: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#modal_add').modal('hide') // modal add hide
                if (data.response == true) {
                    swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "ยืนยัน",
                    }).then((value) => {
                        // window.location.reload();

                        $('#datatables').DataTable().ajax.reload();
                        $('#modal_confirmbook').modal('hide')
                    });
                }
            }
        });
    }
    // Booking
    function show(keepId) {
        // e.preventDefault();
        console.log(keepId);
        $.ajax({
            url: "{{ route('api.booking.databooking')}}",
            data: {
                keepId: keepId
            },
            type: "POST",
            async: false,

            success: function (data) {
                $('#modal_booking').modal('show')
                $('#htmltable').html(data.htmltable)
            }
        });
    }

    var path = "{{ route('api.booking.searchuser') }}";
    $('input.typeahead').typeahead({
        source: function (query, process) {
            return $.post(path, {
                query: query
            }, function (data) {
                console.log(data);
                // $('#partners_id').val(data.partners_id)
                return process(data);
            });
        }
    });

    function search_customer(value) {
        $.ajax({
            url: "{{ route('api.booking.searchcustomer')}}",
            data: {
                value: value
            },
            type: "POST",
            async: false,

            success: function (data) {
                // console.log(data);
                $('#search_customer_div').html(data.html);

            }
        });
    }

    function selectbooth(keepId) {
        // e.preventDefault();
        // $(this).addClass('actions_one');
        // alert(keepId);
        $('.btnbook').removeClass('actions_one');
        $('#bt_' + keepId).addClass('actions_one');
        console.log('#bt' + keepId);
        $('#booth_detail_id').val(keepId)
    }

    function sentnotification(keepId) {
        // e.preventDefault();
        console.log(keepId);
        $.ajax({
            url: "{{ route('api.booking.sentnotification')}}",
            data: {
                keepId: keepId
            },
            type: "POST",
            async: false,

            success: function (data) {
                console.log(data);
                // $('#modal_booking').modal('show')
                // $('#trdetail').html(data.trdetail)
            }
        });
    }

    function sentnotification_overdue() {
        // e.preventDefault();
        // console.log(keepId);
        $.ajax({
            url: "{{ route('api.booking.sentnotification_overdue')}}",
            // data: {
            // keepId : keepId
            // },
            type: "POST",
            async: false,

            success: function (data) {
                console.log(data);
                // $('#modal_booking').modal('show')
                // $('#trdetail').html(data.trdetail)
            }
        });
    }

    function adddate() {
        var html = ' <div class="form-group row">' +
            '<label class="col-sm-4 col-form-label">เลือกวันที่</label>' +
            '  <div class="col-sm-6">' +
            '<input type="hidden" name="date_booking" id="date_booking"class="form-control form-control-normal" required="" value="">' +
            '<input type="date" class="form-control form-control-normal" name="bd_booking_date[]" id="ch_Name" autocomplete="off" required="" onchange="getDate()">' +
            ' </div>' +
            ' </div>'
        console.log(html);

        $('#date_html').append(html);
    }

    function choseecustomer(name, value) {
        // e.preventDefault();
        console.log(name, value);
        $('#partners_name').val(name)
        $('#partners_id').val(value)
        $('#modal_serach_customer').modal('hide')

    }

</script>



@endsection
