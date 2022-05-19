@extends('backend/inc_main') {{-- main.blade.php --}}

 @section('title','| All Tags')

@section('stylesheet')

@endsection

@section('content')

<style>
    /* Autocomplate */
    .label {
      color: white;
      padding: 2px;
      font-family: Arial;
    }
    .success {background-color: #4CAF50;} /* Green */
    .info {background-color: #2196F3;} /* Blue */
    .warning {background-color: #ff9800;} /* Orange */
    .danger {background-color: #f44336;} /* Red */
    .other {background-color: #e7e7e7; color: black;} /* Gray */

    .ui-autocomplete {
    position: absolute;
    z-index: 2150000000 !important;
    cursor: default;
    border: 2px solid #ccc;
    padding: 5px 0;
    border-radius: 2px;
    }

    .modal-lgs {
        max-width: 1500px !important;
    }
</style>


    {{-- content --}}
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <div class="card tabs-card">
                            {{-- header --}}
                            <div class="card-header">
                                <h4>รายการโค้ดคูปอง</h4>
                                <p class="text-muted m-b-10">รายละเอียดโค้ดคูปอง</p>
                                <ul class="breadcrumb-title b-t-default p-t-10">

                                </ul>
                            </div>

                            <!-- block -->
                            <div class="card-block">

                                {{-- Add --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <div class="form-group">
                                                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_add" ><i class="fa fa-plus"></i> เพิ่มข้อมูลโค้ดส่วนลด</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="d-flex justify-content-end">
                                    <p style="margin-top: 6px;">Show</p>
                                    <div class="col-sm-2">
                                        <select class="form-control" style="width:108%;" name="status_val" id="status_val">
                                            <option value="W">รออนุมัติ</option>
                                            <option value="Y">ใช้งาน</option>
                                            <option value="N">ยกเลิก</option>
                                            <option value="T" selected>ทั้งหมด</option>
                                        </select>
                                    </div>
                                </div><br>

                                {{-- Datable --}}
                                <div class="dt-responsive table-responsive">
                                    <table id="datatables" class="table  table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">รหัสโค้ด</th>
                                                <th class="text-center">ชื่อโค้ด</th>
                                                <th class="text-center">ราคาลด</th>
                                                <th class="text-center">วันที่เริ่ม</th>
                                                <th class="text-center">วันที่สิ้นสุด</th>
                                                <th class="text-center">จำนวน</th>
                                                <th class="text-center">ใช้แล้ว</th>
                                                <th class="text-center">คงเหลือ</th>
                                                <th class="text-center">สถานะ</th>
                                                <th class="text-center">ประเภท</th>
                                                <th class="text-center" >จัดการ</th>
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
    <div class="modal fade" id="modal_add" role="dialog" >
        <form  method="POST" id="form_add">
        {!! csrf_field() !!}
            <div class="modal-dialog modal-lg" id="reload_add">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">เพิ่มข้อมูลโค้ดส่วนลด</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body" id="body_modal_add">
                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <label>รหัสโค้ดส่วนลด <span class="c-red">*</span></label>
                                <input type="text" class="form-control" name="" id="" placeholder="ระบบสร้างรหัสอัตโนมัติ" autocomplete="off" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <label>ชื่อคูปอง <span class="c-red">*</span></label>
                                <input type="text" class="form-control" name="name" id="name_a" placeholder="ชื่อคูปอง" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>วันที่เริ่ม <span class="c-red">*</span></label>
                                <input class="form-control" type="date" name="date_start" id="date_start_a" required>
                            </div>
                            <div class="col-md-3">
                                <label>วันที่สิ้นสุด <span class="c-red">*</span></label>
                                <input class="form-control" type="date" name="date_end" id="date_end_a" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>วันที่เริ่มต้นลงขาย <span class="c-red">*</span></label>
                                <input class="form-control" type="date" name="date_booking_start" id="date_booking_start_a" required>
                            </div>
                            <div class="col-md-3">
                                <label>วันที่สิ้นสุดลงขาย <span class="c-red">*</span></label>
                                <input class="form-control" type="date" name="date_booking_end" id="date_booking_end_a" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>ราคาลด <span class="c-red">*</span></label>
                                <div class="input-group input-group-button">
                                    <input type="text" class="form-control text-right numbers checknumber" name="price" id="price_a" autocomplete="off" placeholder="ราคาลด" required>
                                    <select class="form-control" style="height:35px" name="type_con" id="type_con_a">
                                        <option value="1" selected>บาท</option>
                                        {{-- <option value="2">%</option> --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>จำนวนโค้ด <span class="c-red">*</span></label>
                                <input type="text" class="form-control checknumber numbers" name="amount" id="amount_a" autocomplete="off" placeholder="จำนวนโค้ด" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>ประเภทโค้ดส่วนลด <span class="c-red">*</span></label>
                                <select class="form-control" style="height:35px" name="type_coupon" id="type_coupon_a">
                                    <option value="Personal" selected>บุคคล</option>
                                    <option value="Everyone">ทุกคน</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{-- <div class="col-md-12"></div> --}}
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>พื้นที่ได้รับสิทธิ์โปรโมชั่น <span class="c-red">*</span></label>
                                <table width="100%">
                                    @foreach($markets as $market)
                                    {{-- <tr >
                                        <td> {{$market->name_market}}  </td>
                                        <td> <input  type="checkbox" name="marketname[]" value="{{$market->marketname_id}}"></td>
                                    </tr> --}}
                                    <tr >
                                        <td> {{$market->name_market}}  </td>
                                        <td style="display: flex; justify-content: center;">
                                            <input type="checkbox" name="marketname[]" id="access{{$market->marketname_id}}" class="form-control" value="{{$market->marketname_id}}" style="width: 25px; height: 25px; -moz-appearance: none;" >
                                        </td>

                                    </tr>
                                    @endforeach
                                </table>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        <button class="btn btn-primary" id="submit_add">บันทึก</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modal_edit" role="dialog">
        <form method="POST"  id="form_edit">
        {!! csrf_field() !!}
            <div class="modal-dialog modal-lg" id="reload_edit">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">แก้ไขข้อมูลโค้ดส่วนลด</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                     </div>

                     <div class="modal-body" id="body_modal_edit">
                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <label>รหัสโค้ดส่วนลด <span class="c-red">*</span></label>
                                <input type="text" class="form-control" name="code" id="code_e" placeholder="ระบบสร้างรหัสอัติโนมัติ" autocomplete="off" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <label>ชื่อคูปอง <span class="c-red">*</span></label>
                                <input type="text" class="form-control" name="name" id="name_e" placeholder="ชื่อคูปอง" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>วันที่เริ่ม <span class="c-red">*</span></label>
                                <input class="form-control" type="date" name="date_start" id="date_start_e" required>
                            </div>
                            <div class="col-md-3">
                                <label>วันที่สิ้นสุด <span class="c-red">*</span></label>
                                <input class="form-control" type="date" name="date_end" id="date_end_e" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>วันที่เริ่มต้นลงขาย <span class="c-red">*</span></label>
                                <input class="form-control" type="date" name="date_booking_start" id="date_booking_start_e" required>
                            </div>
                            <div class="col-md-3">
                                <label>วันที่สิ้นสุดลงขาย <span class="c-red">*</span></label>
                                <input class="form-control" type="date" name="date_booking_end" id="date_booking_end_e" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>ราคาลด <span class="c-red">*</span></label>
                                <div class="input-group input-group-button">
                                    <input type="text" class="form-control text-right numbers checknumber" name="price" id="price_e" autocomplete="off" placeholder="ราคาลด" readonly required>
                                    <select class="form-control" style="height:35px" name="type_con" id="type_con_e" readonly >
                                        <option value="1" selected>บาท</option>
                                        <option value="2">%</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>จำนวนโค้ด <span class="c-red">*</span></label>
                                <input type="text" class="form-control checknumber numbers" name="amount" id="amount_e" autocomplete="off" placeholder="จำนวนโค้ด" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>ประเภทโค้ดส่วนลด <span class="c-red">*</span></label>
                                <select class="form-control" style="height:35px" name="type_coupon" id="type_coupon_e" readonly>
                                    <option value="Personal" selected>บุคคล</option>
                                    <option value="Everyone">ทุกคน</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            {{-- <div class="col-md-12"></div> --}}
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>พื้นที่ได้รับสิทธิ์โปรโมชั่น <span class="c-red">*</span></label>
                                <table width="100%" id="cm-table">
                                    @foreach($markets as $market)
                                    <tr >
                                        <td> {{$market->name_market}}  </td>
                                        <td style="display: flex; justify-content: center;">
                                            <input type="checkbox" name="marketname[]" id="access{{$market->marketname_id}}" class="form-control" value="{{$market->marketname_id}}" style="width: 25px; height: 25px; -moz-appearance: none;" >
                                        </td>

                                    </tr>
                                    @endforeach
                                </table>

                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id" id="id">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        <button class="btn btn-primary" id="submit_edit">บันทึก</button>
                    </div>
                 </div>
            </div>
        </form>
    </div>
    {{-- ===================================================================== --}}


    <!-- Modal Table Person -->
    <div class="modal fade" id="modal_send" role="dialog" >
        {{-- <form  method="POST" id="form_send"> --}}
            <div class="modal-dialog modal-lg" id="reload_send">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">รายการส่งโค้ดส่วนลดรายบุคคล</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body" id="body_modal_send">
                        <div class="col-md-12 form-group row" >
                            <p id="name_t"></p>
                            <p id="code_t"></p>
                            <p id="status_t"></p>
                            <p id="amout_t"></p>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-right">
                                    <div class="form-group">
                                        <a href="#" class="btn btn-dark bt_add_person" data-toggle="modal" data-target="#modal_add_person" id="addpersoner"><i class="fa fa-plus"></i>เพิ่มรายชื่อส่งโค้ด</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Table Send --}}
                        <div class="dt-responsive table-responsive" id="table_send"> </div>

                        <br> <br> <br>
                        <div class="text-right">
                            <p class="c-red"><b>หมายเหตุ : ระบบจะส่งโค้ดให้เฉพาะสถานะ "ยังไม่ส่งโค้ด"</b></p>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <input type="hidden" id="id_coupon" name="id_coupon" >
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        {{-- <button class="btn btn-primary" id="">ส่งโค้ดทั้งหมดที่อยู่ในรายชื่อ</button> --}}
                    </div>
                </div>
            </div>
        {{-- </form> --}}
    </div>

    <!-- Modal Send Code Person -->
    <div class="modal fade" id="modal_add_person" role="dialog" >
        <form  method="POST" id="form_addperson">
        {!! csrf_field() !!}
            <div class="modal-dialog modal-lgs" id="reload_add_person">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">เพิ่มรายชื่อส่งโค้ด</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body" id="body_modal_add_person">
                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <label>ค้นหารายชื่อส่งโค้ด <span class="c-red">*</span></label>
                                <input type="text" class="form-control search_partners" name="name_send" id="name_send" placeholder="ค้นหารายชื่อส่งโค้ด" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>ชื่อลูกค้า/นิติบุคล</label>
                                <input type="text" class="form-control" id="name_customerS" readonly>
                            </div>
                            <div class="col-md-3">
                                <label>เลขที่ประจำตัวผู้เสียภาษี</label>
                                <input type="text" class="form-control" id="numbertaxS" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>ชื่อ</label>
                                <input type="text" class="form-control" id="nameS" readonly>
                            </div>
                            <div class="col-md-3">
                                <label>สกุล</label>
                                <input type="text" class="form-control" id="lastnameS" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-2">
                                <label>หมายเลขบัตร</label>
                                <input type="text" class="form-control" id="citizenidS" readonly>
                            </div>
                            <div class="col-md-2">
                                <label>ประเภทสมาชิก</label>
                                <select class="form-control" id="partners_typeS" readonly>
                                    <option value="">ประเภทสมาชิก</option>
                                    @foreach($partnerstype as $type)
                                        <option value="{{$type->partners_type_id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>สถานะสมาชิก</label>
                                <select class="form-control" id="status_partnersS" readonly>
                                    <option value="">สถานะสมาชิก</option>
                                    <option value="A">เกรด A</option>
                                    <option value="B">เกรด B</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <label>ที่อยู่</label>
                                <input type="text" class="form-control" id="addressS" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-2">
                                <label>ซอย</label>
                                <input type="text" class="form-control" id="soiS" readonly>
                            </div>
                            <div class="col-md-2">
                                <label>ถนน</label>
                                <input type="text" class="form-control" id="roadS" readonly>
                            </div>
                            <div class="col-md-2">
                                <label>ตำบล</label>
                                <input type="text" class="form-control" id="districtS" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-2">
                                <label>อำเภอ</label>
                                <input type="text" class="form-control" id="ampureS" readonly>
                            </div>
                            <div class="col-md-2">
                                <label>จังหวัด</label>
                                <input type="text" class="form-control" id="provinceS" readonly>
                            </div>
                            <div class="col-md-2">
                                <label>รหัสไปษณี</label>
                                <input type="text" class="form-control" id="zipcodeS" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-2">
                                <label>อีเมล์</label>
                                <input type="text" class="form-control" id="emailS" readonly>
                            </div>
                            <div class="col-md-2">
                                <label>เบอร์โทร</label>
                                <input type="text" class="form-control" id="phoneS" readonly>
                            </div>
                            <div class="col-md-2">
                                <label>ไลน์</label>
                                <input type="text" class="form-control" id="lineidS" readonly>
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>รูปบัตรประชาชน</label>
                                <img src="{{URL::asset('public/assets/img/wait_img.png')}}" id="image_citizenS" class="img-fluid img-responsive" style="width:720px;height:200px;" >
                            </div>
                            <div class="col-md-3">
                                <label>รูปภาพ ภ.พ. 20</label>
                                <img src="{{URL::asset('public/assets/img/wait_img.png')}}" id="image_kp20S" class="img-fluid img-responsive" style="width:720px;height:200px;" >
                            </div>
                        </div> --}}
                    </div>

                    <input type="hidden" name="partnersID" id="partnersID"> {{-- ID Partners --}}
                    <input type="hidden" name="couponID" id="couponID"> {{-- ID Coupon --}}

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        <button class="btn btn-primary" id="bt_addperson">บันทึก</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    {{-- ===================================================================== --}}

    <!-- Modal Table Public -->
    <div class="modal fade" id="modal_public" role="dialog" >
        {{-- <form  method="POST" id="form_public"> --}}
            <div class="modal-dialog modal-lg" id="reload_public">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">รายการส่งโค้ดส่วนลดทุกคน</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body" id="body_modal_public">
                        <div class="col-md-12 form-group row">
                            <p id="name_t_public"></p>
                            <p id="code_t_public"></p>
                            <p id="status_t_public"></p>
                            <p id="amout_t_public"></p>
                         </div>

                        {{-- Table Public --}}
                        <div class="dt-responsive table-responsive" id="table_public"> </div>

                        <br><br><br>
                        <div class="text-right">
                            <p class="c-red"><b>หมายเหตุ : ระบบจะส่งโค้ดให้เฉพาะสถานะ "ยังไม่ส่งโค้ด"</b></p>
                        </div>
                    </div>
                    <input type="hidden" id="id_code" >
                    <div class="modal-footer">
                        <input type="hidden" id="id_coupon_public" name="id_coupon_public" >
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        <button class="btn btn-primary" onclick="sendcode_all()" >ส่งโค้ดทั้งหมดที่อยู่ในรายชื่อ</button>
                    </div>
                </div>
            </div>
        {{-- </form> --}}
    </div>
    {{-- ===================================================================== --}}


@endsection

@section('script')


<script>
    $(document).ready(function(){
        $(".pcoded-submenu>li a[href='{{ route('backend.coupon') }}']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='{{ route('backend.coupon') }}']").parent().parent().parent().addClass("pcoded-trigger");
    });
</script>

<script>

    // Button Submit Add
    $('#submit_add').click(function(e){
        var name = $('#name_a').val();
        var date_start = $('#date_start_a').val();
        var date_end = $('#date_end_a').val();
        var price = $('#price_a').val();
        var amount = $('#amount_a').val();
        if(name != "" && date_start != "" && date_end != "" && price != "" && amount != ""){
            e.preventDefault();
            waitme_reload('#reload_add');
            setTimeout(function(){
                $('#form_add').submit();
            }, 3000);
        }
    });

    // Button Submit Update
    $('#submit_edit').click(function(e){
        var name = $('#name_e').val();
        var date_start = $('#date_start_e').val();
        var date_end = $('#date_end_e').val();
        var amount = $('#amount_e').val();
        if(name != "" && date_start != "" && date_end != "" && amount != ""){
            e.preventDefault();
            waitme_reload('#reload_edit');
            setTimeout(function(){
                $('#form_edit').submit();
            }, 3000);
        }
    });

    // Button Submit Add Person
    $('#bt_addperson').click(function(e){
        var name_send = $('#name_send').val();
        if(name_send != ""){
            e.preventDefault();
            waitme_reload('#reload_add_person');
            setTimeout(function(){
                $('#form_addperson').submit();
            }, 3000);
        }
    });

    $(document).ready(function(){

        // Datable Code
        var oTable = $("#datatables").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthChange: true,
            stateSave: true,

			ajax:{
                url : "{{ route('api.coupon.datatable') }}",
				data: function (d) {
                    d.status_val = $('#status_val').val(); // สถานะ
				},
            },

            columns: [
                { 'className': "text-center", data: 'colum_code', name: 'coupon_id' },
                { 'className': "text-center", data: 'colum_name', name: 'colum_name' },
                { 'className': "text-center", data: 'colum_price', name: 'colum_price' },
                { 'className': "text-center", data: 'colum_date_start', name: 'colum_date_start' },
                { 'className': "text-center", data: 'colum_date_end', name: 'colum_date_end' },
                { 'className': "text-center", data: 'colum_amount', name: 'colum_amount' },
                { 'className': "text-center", data: 'colum_amount_use', name: 'colum_amount_use' },
                { 'className': "text-center", data: 'colum_balance', name: 'colum_balance' },
                { 'className': "text-center", data: 'colum_status', name: 'colum_status' },
                { 'className': "text-center", data: 'colum_typecoupon', name: 'colum_typecoupon' },
                { 'className': "text-center", data: 'colum_manage', name: 'colum_manage' },

            ],
            order: [[0, 'desc']],
            rowCallback: function(row,data,index ){
				// rowCallback
			}

        });

        // Sort Status | Datatable
        $('#status_val').change(function(e){
            oTable.draw();
        });

        // Form Add
        $('#form_add').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this); // value total in form
            $.ajax({
                url:"{{ route('api.coupon.add') }}",
                data:formData,
                type:"POST",
                async: false,
                contentType: false,
                processData: false,
                success:function(data){
                    $('#reload_add').waitMe("hide"); // waitme stop
                    $('#modal_add').modal('hide') // modal add hide
                    // $('#body_modal_add').load(document.URL + ' #body_modal_add'); // body modal add refresh
                    if(data.response==true){
                        swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "OK",
                        }).then((value) => {
                           // oTable.draw(); // refresh datatable
                            window.location.reload();
                        });
                    }
                }
            });
        });

        // Form Update
        $('#form_edit').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
               url: "{{ route('api.coupon.update') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){
                    $('#reload_edit').waitMe("hide"); // waitme stop
                    $('#modal_edit').modal('hide') // modal add hide
                    // $('#body_modal_edit').load(document.URL + ' #body_modal_add'); // body modal add refresh
                    if(data.response == true){
                        swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "ยืนยัน",
                        }).then((value) => {
                          //  oTable.draw(); // refresh dadatable
                            window.location.reload();
                        });
                    }
                }
            });
        });


        // Form Send Conde Add Person
        $('#form_addperson').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
               url: "{{ route('api.coupon.add_person') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){
                    $('#reload_add_person').waitMe("hide"); // waitme stop
                    $('#modal_add_person').modal('hide') // modal add hide
                    if(data.response == true){
                        swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "ยืนยัน",
                        }).then((value) => {
                            if(data.disbut == 'disable'){
                                // $('#id_coupon').val(data.coupon_id);
                                // $("#id_coupon").attr("disabled", true);
                                $("#addpersoner").hide();

                            }

                            datatable_person(); // new datatable person

                        });
                    }else{
                        swal({
                        title: data.title,
                        text: data.text,
                        icon: "warning",
                        button: "ยืนยัน",
                        }).then((value) => {
                           // datatable_person(); // new datatable person
                        });
                    }
                }
            });
        });
        // =============================================================================

    });

    // Model Edit
	$(document).on('click', ".model-data", function() {
        var id = $(this).attr('data-id');
        $.ajax({
            url:"{{ route('api.coupon.edit') }}",
            data:{"_token": "{{ csrf_token() }}",'id':id},
            type:"POST",
            success:function(data){
                console.log(data);
                $('#cm-table').html(data.cmtable);
                $('#amount_e').val(data.amount);
                $('#id').val(data.coupon_id);
                $('#code_e').val(data.code);
                $('#name_e').val(data.name);
                $('#date_start_e').val(data.date_start);
                $('#date_end_e').val(data.date_end);
                $('#price_e').val(data.price);
                $('#type_con_e').val(data.type_con).trigger('change');
                $('#date_booking_start_e').val(data.date_booking_start);
                $('#date_booking_end_e').val(data.date_booking_end);
                $('#type_coupon_e').val(data.type_coupon).trigger('change');
            }
        });
    });

    // Model Table Person
	$(document).on('click', ".model-person", function() {
        $("#addpersoner").show();
        var id = $(this).attr('data-id');
        $.ajax({
            url:"{{ route('api.coupon.edit') }}",
            data:{"_token": "{{ csrf_token() }}",'id':id},
            type:"POST",
            success:function(data){
                console.log(data);
                $('#code_t').html("<u>รหัสโค้ด:</u> " + data.code + "&nbsp;&nbsp;|&nbsp;&nbsp;");
                $('#name_t').html("<u>ชื่อโค้ด:</u> " + data.name + "&nbsp;&nbsp;|&nbsp;&nbsp;");
                $('#status_t').html("<u>สถานะ:</u> " + data.type_coupon + "&nbsp;&nbsp;|&nbsp;&nbsp;");
                $('#amout_t').html("<u>จำนวนรายชื่อทีส่ง:</u> " + data.amount);
                $('#id_coupon').val(data.coupon_id);
                if(data.disbut == 'disable'){
                    // $('#id_coupon').val(data.coupon_id);
                    // $("#id_coupon").attr("disabled", true);
                    $("#addpersoner").hide();

                }
                datatable_person();
            }
        });
    });

    // Model Table Public
	$(document).on('click', ".model-public", function() {
        var id = $(this).attr('data-id');
        $.ajax({
            url:"{{ route('api.coupon.edit') }}",
            data:{"_token": "{{ csrf_token() }}",'id':id},
            type:"POST",
            success:function(data){
                console.log(data);
                $('#name_t_public').html("<u>ชื่อโค้ด:</u> " + data.name + "&nbsp;&nbsp;|&nbsp;&nbsp;");
                $('#code_t_public').html("<u>รหัสโค้ด:</u> " + data.code + "&nbsp;&nbsp;|&nbsp;&nbsp;");
                $('#status_t_public').html("<u>สถานะ:</u> " + data.type_coupon + "&nbsp;&nbsp;|&nbsp;&nbsp;");
                $('#amout_t_public').html("<u>จำนวนรายชื่อทีส่ง:</u> " + "ทุกคน");
                $('#id_coupon_public').val(data.coupon_id);
                datatable_public();
            }
        });
    });

    // Click Add Send Code Person
    $(document).on('click',".bt_add_person",function(){
        cleardata(); // Clear Value Empty
        var idcoupon = $('#id_coupon').val();
        $('#couponID').val(idcoupon);
    });

    // Datatble Person [รายบุคคล]
    function datatable_person(){

        $('#table_send').empty();

        var table_s = '<table id="datatables_send" class="table table-striped table-bordered" width="100%">';
            table_s += '<thead>';
            table_s += '<tr>';
            table_s += '<th width="40%" class="text-center">รายชื่อ</th>';
            // table_s += '<th width="10%" class="text-center">วันที่</th>';
            // table_s += '<th width="10%" class="text-center">ผู้ทำรายการ</th>';
            // table_s += '<th width="10%" class="text-center">สถานะส่ง</th>';
            // table_s += '<th width="10%" class="text-center">สถานะใช้</th>';
            table_s += '<th width="10%" class="text-center">จัดการ</th>';
            table_s += '</tr>';
            table_s += '</thead>';
            table_s += '</table>';
            $('#table_send').append(table_s);


        var oTable2 = $("#datatables_send").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthChange: true,
            stateSave: true,

			ajax:{
                url : "{{ route('api.coupon.datatable_person') }}",
				data: function (d) {
                     d.id_coupon = $('#id_coupon').val();
				},
            },

            columns: [
                { 'className': "text-center", data: 'colum_name', name: 'colum_name' },
                // { 'className': "text-center", data: 'colum_date', name: 'colum_date' },
                // { 'className': "text-center", data: 'colum_user', name: 'colum_user' },
                // { 'className': "text-center", data: 'colum_status_send', name: 'colum_status_send' },
                // { 'className': "text-center", data: 'colum_status_use', name: 'colum_status_use' },
                { 'className': "text-center", data: 'colum_manage', name: 'colum_manage' },

            ],
            order: [[0, 'desc']],
            rowCallback: function(row,data,index ){
				// rowCallback
			}

        });
    }

    // Datatble Public [ทุกคน]
    function datatable_public(){

        $('#table_public').empty();

        var table = '<table id="datatables_public" class="table table-striped table-bordered" width="100%">';
            table += '<thead>';
            table += '<tr>';
            table += '<th width="40%" class="text-center">รายชื่อ</th>';
            table += '</tr>';
            table += '</thead>';
            table += '</table>';
            $('#table_public').append(table);

        var oTable = $("#datatables_public").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthChange: true,
            stateSave: true,

			ajax:{
                url : "{{ route('api.coupon.datatable_public') }}",
				data: function (d) {
                     d.id_coupon = $('#id_coupon_public').val();
				},
            },

            columns: [
                { 'className': "text-center", data: 'name_customer', name: 'name_customer' },
            ],
            order: [[0, 'desc']],
            rowCallback: function(row,data,index ){
				// rowCallback
			}
        });
    }

    // Status Confirm
    function data_confirm(id,name){
		bootbox.confirm({
			title: "ยืนยัน ?",
			message: "คุณต้องการอัพเดทสถานะ <font color='red'>"+name+"</font> นี้หรือไม่ ?",
			buttons:{
				cancel: {
					label: '<i class="fa fa-times"></i> ยกเลิก',
					className: 'btn-danger'
				},
				confirm:{
					label: '<i class="fa fa-check"></i> ยืนยัน',
					className: 'btn-success'
				}
			},
			callback: function (result){
				if(result == true){
					$.ajax({
					url: "{{ route('api.coupon.confirm')}}",
                    data: {"_token": "{{ csrf_token() }}", 'id': id},
					type: "POST",
					async:false,
                    success:function(data){
                            if(data.response==true){
                                swal({
                                title: data.title,
                                text: data.text,
                                icon: "success",
                                button: "OK",
                                }).then((value) => {
                                    window.location.reload();
                                });
                            }
                        }
					});
				}
			}
		});
    }

    // Status Cancel
    function data_cancel(id,name){
		bootbox.confirm({
			title: "ยืนยัน ?",
			message: "คุณต้องการยกเลิกใช้งานโค้ดส่วนลด <font color='red'>"+name+"</font> นี้หรือไม่ ?",
			buttons:{
				cancel: {
					label: '<i class="fa fa-times"></i> ยกเลิก',
					className: 'btn-danger'
				},
				confirm:{
					label: '<i class="fa fa-check"></i> ยืนยัน',
					className: 'btn-success'
				}
			},
			callback: function (result){
				if(result == true){
					$.ajax({
					url: "{{ route('api.coupon.cancel')}}",
                    data: {"_token": "{{ csrf_token() }}", 'id': id},
					type: "POST",
					async:false,
                    success:function(data){
                            if(data.response==true){
                                swal({
                                title: data.title,
                                text: data.text,
                                icon: "success",
                                button: "OK",
                                }).then((value) => {
                                    window.location.reload();
                                });
                            }
                        }
					});
				}
			}
		});
    }

    // Delete Send Conde
    function delete_sendconde(id,name){
		bootbox.confirm({
			title: "ยืนยัน ?",
			message: "คุณต้องการลบรายชื่อส่งโค้ดของ <font color='red'>"+name+"</font> นี้หรือไม่ ?",
			buttons:{
				cancel: {
					label: '<i class="fa fa-times"></i> ยกเลิก',
					className: 'btn-danger'
				},
				confirm:{
					label: '<i class="fa fa-check"></i> ยืนยัน',
					className: 'btn-success'
				}
			},
			callback: function (result){
				if(result == true){
					$.ajax({
					url: "{{ route('api.coupon.delete_sendcode')}}",
                    data: {"_token": "{{ csrf_token() }}", 'id': id ,'per': name},
					type: "POST",
					async:false,
                    success:function(data){
                            if(data.response==true){
                                swal({
                                title: data.title,
                                text: data.text,
                                icon: "success",
                                button: "OK",
                                }).then((value) => {
                                    if(data.disbut == 'disable'){
                                        // $('#id_coupon').val(data.coupon_id);
                                        // $("#id_coupon").attr("disabled", true);
                                        $("#addpersoner").hide();

                                    }else{
                                        $("#addpersoner").show();
                                    }
                                   datatable_person(); // New Datable Person
                                });
                            }
                        }
					});
				}
			}
		});
    }

    // Search ค้นหารายชื่อส่งโค้ด
    var keysearch = "";
	$(".search_partners").autocomplete({
		minLength: 0,
		source: function(request,response) {
			$.ajax({
				url:"{{ route('api.coupon.search_partners') }}",
				data:{"_token": "{{ csrf_token() }}",'keysearch':request.term},
				type: "POST",
				dataType: "json",
				success: function(data) {
					response(data);
                    console.log(data);
				},
			});
		},
		select: function(event, ui) {
            console.log(ui);
            // Display Value
            $('#partnersID').val(ui.item.id); // ID
            $('#name_customerS').val(ui.item.name_customer);
            $('#numbertaxS').val(ui.item.numbertax);
            $('#nameS').val(ui.item.name);
            $('#lastnameS').val(ui.item.lastname);
            $('#citizenidS').val(ui.item.citizenid);
            $('#partners_typeS').val(ui.item.partners_type).trigger('change');
            $('#status_partnersS').val(ui.item.status_partners).trigger('change');
            $('#addressS').val(ui.item.address);
            $('#soiS').val(ui.item.soi);
            $('#roadS').val(ui.item.road);
            $('#districtS').val(ui.item.district);
            $('#ampureS').val(ui.item.ampure);
            $('#provinceS').val(ui.item.province);
            $('#zipcodeS').val(ui.item.zipcode);
            $('#emailS').val(ui.item.email);
            $('#phoneS').val(ui.item.phone);
            $('#lineidS').val(ui.item.lineid);

            // รูปภาพบัตรประชาชน
            if(ui.item.image_citizen != null){
                image_citizen = "{{asset('storage/uploadfile/partners')}}/"+ui.item.image_citizen;
            }else{
                image_citizen = "{{asset('public/assets/backend/img/wait_img.png')}}";
            }
            // รูปภาพ ก.พ 20
            if(ui.item.image_kp20 != null){
                image_kp20 = "{{asset('storage/uploadfile/partners')}}/"+ui.item.image_kp20;
            }else{
                image_kp20 = "{{asset('public/assets/backend/img/wait_img.png')}}";
            }
            $('#image_citizenS').attr('src',image_citizen); // image
            $('#image_kp20S').attr('src',image_kp20); // image
		}
    });


    // Waitme Reload
    function waitme_reload(value){

        $(value).waitMe({
			effect: 'rotation',
			text: 'Please wait..',
			bg: 'rgba(255,255,255,0.7)',
			color: '#000',
			maxSize: '',
			waitTime: -1,
			source: '',
			textPos: 'vertical',
			fontSize: '',
			onClose: function() {}
		});
    }

    // Clear Data In Form
    function cleardata(){
        $('#form_addperson').find('input,select').val(''); // value
        $('#form_addperson').find('img').attr('src','{{asset("public/assets/backend/img/wait_img.png")}}'); // image
    }
    // Waitme Reload
    function sendcode_person(id_code,id_user){

        $.ajax({
					url: "{{ route('api.coupon.sendcode_person')}}",
                    data: {
                        id_code: id_code,
                        id_user: id_user,
                    },
					type: "POST",
					async:false,
                    success:function(data){
                            if(data.response==true){
                                swal({
                                title: data.title,
                                text: data.text,
                                icon: "success",
                                button: "OK",
                                }).then((value) => {
                                   datatable_person(); // New Datable Person
                                });
                            }
                        }
					});
    }
    function selectcode($id){

        $('#id_code').val($id);
        console.log($id);
    }
    function sendcode_all(){
        id_code = $('#id_code').val();
        $.ajax({
                    url: "{{ route('api.coupon.sendcode_all')}}",
                    data: {
                        id_code: id_code,
                    },
                    type: "POST",
                    async:false,
                    success:function(data){
                            if(data.response==true){
                                swal({
                                title: data.title,
                                text: data.text,
                                icon: "success",
                                button: "OK",
                                }).then((value) => {
                                datatable_person(); // New Datable Person
                                });
                            }
                        }
                    });
        }
</script>



@endsection
