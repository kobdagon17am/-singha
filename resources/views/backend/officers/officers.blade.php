@extends('backend/inc_main') {{-- main.blade.php --}}

 @section('title','| All Tags')

@section('stylesheet')

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
                            <div class="card-header">
                                <h4>รายชื่อเจ้าหน้าที่</h4>
                                <p class="text-muted m-b-10">รายละเอียดข้อมูลรายเจ้าหน้าที่</p>
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
                                                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_add" ><i class="fa fa-plus"></i> เพิ่มข้อมูล</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="d-flex justify-content-end">
                                    <p style="margin-top: 6px;">Show</p>
                                    <div class="col-sm-2">
                                        <select class="form-control" style="width:108%;" name="status_val" id="status_val">
                                            <option value="Y">ใช้งาน</option>
                                            <option value="N">ระงับใช้งาน</option>
                                            <option value="T" selected>ทั้งหมด</option>
                                        </select>
                                    </div>
                                </div><br>

                                {{-- Datatable --}}
                                <div class="dt-responsive table-responsive">
                                    <table id="datatables" class="table  table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ชื่อพนักงาน</th>
                                                <th class="text-center">นามสกุล</th>
                                                <th class="text-center">Username</th>
                                                <th class="text-center">ประเภทสมาชิก</th>
                                                <th class="text-center">สถานะ</th>
                                                {{-- <th class="text-center">สถานะ</th> --}}
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
    <div class="modal fade" id="modal_add" role="dialog" >
        <form  method="POST" id="form_add">
        {!! csrf_field() !!}
            <div class="modal-dialog modal-lg" id="reload_add">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">เพิ่มข้อมูล</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body" id="body_modal_add">

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">Username:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">Password:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="password" id="password" placeholder="Password"  autocomplete="off" required>
                            </div>
                        </div>
                         {{-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">SPACECustomerID:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="space_customer_id" id="space_customer_id" placeholder="space_customer_id"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อลูกค้า/นิติบุคล:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name_customer" id="name_customer" placeholder="ชื่อลูกค้า/นิติบุคล"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">เลขที่ประจำตัวผู้เสียภาษี:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="numbertax" id="numbertax" placeholder="เลขที่ประจำตัวผู้เสียภาษี"  autocomplete="off" required>
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อ:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name" id="name" placeholder="ชื่อ"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">สกุล:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="สกุล"  autocomplete="off" required>
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">หมายเลขบัตร:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="citizenid" id="citizenid" placeholder="หมายเลขบัตร"  autocomplete="off" required>
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ประเภทสมาชิก:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="officers_type" id="officers_type" required>
                                        <option value="AUDIT">AUDIT</option>
                                        <option value="ADMIN">ADMIN</option>
                                </select>

                            </div>
                        </div>
                      {{--  <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ที่อยู่:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="address" id="address" placeholder="ที่อยู่"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ซอย:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="soi" id="soi" placeholder="ซอย"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ถนน:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="road" id="road" placeholder="ถนน"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ตำบล:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="district" id="district" placeholder="ตำบล"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">อำเภอ:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="ampure" id="ampure" placeholder="อำเภอ"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">จังหวัด:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="province" id="province" placeholder="จังหวัด"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">รหัสไปษณี:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="รหัสไปษณี"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">อีเมล์:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="email" id="email" placeholder="อีเมล์"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">เบอร์โทร:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="เบอร์โทร"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ไลน์:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="lineid" id="lineid" placeholder="ไลน์"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">สถานะสมาชิก:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="status_partners" id="status_partners" required>
                                    <option value="A">เกรด A</option>
                                    <option value="B">เกรด B</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">รูปภาพ ภ.พ. 20:</label>
                            <div class="col-sm-5">
                                <img src="{{URL::asset('public/assets/img/wait_img.png')}}" id="PreviewImage2" class="img-fluid img-responsive" style="width:600px;height:200px;" >
                                <p class="c-red">รูปภาพ ภ.พ. 20</p>
                                <input type="file" class="form-control" name="imge_KP" id="imge_KP" onchange='readURL(this,"kp20");'  autocomplete="off" required>
                            </div>
                        </div> --}}

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
                        <h4 class="modal-title ">แก้ไขข้อมูล</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                     </div>

                     <div class="modal-body" id="body_modal_edit">
                        <input type="hidden" name="partners_id" id="partners_id">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">Username:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="username" id="username_e" placeholder="Username"  autocomplete="off" readonly required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">Password:</label>
                            <div class="col-sm-5">
                                <input type="password" class="form-control" name="password" id="password_e" placeholder="Password"  autocomplete="off" required>
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">SPACECustomerID:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="space_customer_id" id="space_customer_id_e" placeholder="space_customer_id"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อลูกค้า/นิติบุคล:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name_customer" id="name_customer_e" placeholder="ชื่อลูกค้า/นิติบุคล"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">เลขที่ประจำตัวผู้เสียภาษี:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="numbertax" id="numbertax_e" placeholder="เลขที่ประจำตัวผู้เสียภาษี"  autocomplete="off" required>
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อ:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name" id="firstname_e" placeholder="ชื่อ"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">สกุล:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="lastname" id="lastname_e" placeholder="สกุล"  autocomplete="off" required>
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">หมายเลขบัตร:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="citizenid" id="citizenid_e" placeholder="หมายเลขบัตร"  autocomplete="off" required>
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ประเภทสมาชิก:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="officers_type" id="officers_type_e" required>
                                    <option value="AUDIT">AUDIT</option>
                                    <option value="ADMIN">ADMIN</option>
                            </select>

                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ที่อยู่:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="address" id="address_e" placeholder="ที่อยู่"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ซอย:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="soi" id="soi_e" placeholder="ซอย"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ถนน:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="road" id="road_e" placeholder="ถนน"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ตำบล:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="district" id="district_e" placeholder="ตำบล"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">อำเภอ:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="ampure" id="ampure_e" placeholder="อำเภอ"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">จังหวัด:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="province" id="province_e" placeholder="จังหวัด"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">รหัสไปษณี:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="zipcode" id="zipcode_e" placeholder="รหัสไปษณี"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">อีเมล์:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="email" id="email_e" placeholder="อีเมล์"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">เบอร์โทร:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="phone" id="phone_e" placeholder="เบอร์โทร"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ไลน์:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="lineid" id="lineid_e" placeholder="ไลน์"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">สถานะสมาชิก:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="status_partners" id="status_partners_e" required>
                                    <option value="A">เกรด A</option>
                                    <option value="B">เกรด B</option>
                                </select>

                            </div>
                        </div>
                        <div  id="product_type_edit">

                        </div>
                        <div class="form-group row" id="addproducttype" style="display: none">
                            <label class="col-sm-4 col-form-label text-right"></label>
                            <div class="col-sm-5 col-form-label ">
                                <button type="button" class="btn btn-info btn-sm" onclick="addproducttype()" ><i class="fa fa-plus"></i>เลือกสินค้าที่ต้องการขาย</button>

                            </div>
                        </div> --}}
                        {{-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">รูปบัตรประชาชน:</label>
                            <div class="col-sm-5">
                                <img src="{{URL::asset('public/assets/img/wait_img.png')}}" id="PreviewImage_e" class="img-fluid img-responsive" style="width:600px;height:200px;" >
                                <p class="c-red">รูปภาพบัตรประชาชน</p>
                                <input type="file" class="form-control" name="imge_citizen" id="imge_citizen_e" onchange='readURL(this,"citizen_e");'  autocomplete="off" required>
                            </div>
                        </div> --}}
                        {{-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">รูปภาพ ภ.พ. 20:</label>
                            <div class="col-sm-5">
                                <img src="{{URL::asset('public/assets/img/wait_img.png')}}" id="PreviewImage2_e" class="img-fluid img-responsive" style="width:600px;height:200px;" >
                                <p class="c-red">รูปภาพ ภ.พ. 20</p>
                                <input type="file" class="form-control" name="imge_KP" id="imge_KP_e" onchange='readURL(this,"kp20_e");'  autocomplete="off" required>
                            </div>
                        </div> --}}

                        <input type="hidden" name="image_CZ" id="image_CZ">
                        <input type="hidden" name="image_KP" id="image_KP">
                        <input type="hidden" name="id" id="id">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        <button class="btn btn-primary" id="submit_edit">บันทึก</button>
                    </div>
                 </div>
            </div>
        </form>
    </div>
{{-- Modal Edit --}}
<div class="modal fade" id="modal_product_type" role="dialog">
    <form method="POST"  id="form_edit">
    {!! csrf_field() !!}
        <div class="modal-dialog modal-lg" id="reload_edit">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title " id="title_product_type">แก้ไขข้อมูล</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                 </div>

                 <div class="modal-body" >
                    <input type="hidden" name="product_id_old" id="product_id_old">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-right">Type:</label>
                        <div class="col-sm-5">
                            <select class="form-control" id="producttype" onchange="searchcategory()">
                                    <option value="">กรุณาเลือก</option>
                                {{-- @foreach ($producttypes as $producttype)
                                    <option value="{{$producttype->type_id}}">{{$producttype->name}}</option>
                                @endforeach --}}

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-right">Category:</label>
                        <div class="col-sm-5">
                            <select class="form-control" id="productcategory" onchange="searchproduct()">
                                <option value="">กรุณาเลือก</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-right"  >Poduct:</label>
                        <div class="col-sm-5">
                            <select class="form-control" id="product_search">
                                <option value="">กรุณาเลือก</option>
                             </select>
                        </div>
                    </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" style="display: none" id="update_pt" onclick="updateproducttype()">แก้ไขข้อมูล</button>
                    <button type="button" class="btn btn-primary" style="display: none" id="add_pt" onclick="submitaddproducttype()">บันทึก</button>
                </div>
             </div>
        </div>
    </form>
</div>
<div class="modal fade" id="modal_market" role="dialog">


        <div class="modal-dialog modal-lg" id="reload_edit">
            <div class="modal-content">

             </div>
        </div>

</div>
@endsection

@section('script')

<script>
    $(document).ready(function(){
        $(".pcoded-submenu>li a[href='{{ url('officers') }}']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='{{ url('officers') }}']").parent().parent().parent().addClass("pcoded-trigger");
    });
</script>


<script>

    // Button Submit Add
    $('#submit_add').click(function(e){
        e.preventDefault();
        waitme_reload("FormAdd");
        setTimeout(function(){
            $('#form_add').submit();
        }, 3000);
    });

    // Button Submit Edit
    $('#submit_edit').click(function(e){
        e.preventDefault();
        waitme_reload("FormEdit");
        setTimeout(function(){
            $('#form_edit').submit();
        }, 3000);
    });

    $(document).ready(function(){
        // Datable
        var oTable = $("#datatables").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthChange: true,
            stateSave: true,

			ajax:{
                url : "{{ route('api.officers.datatable') }}",
                type: "POST",
				data: function (d) {
                    d.status_val = $('#status_val').val(); // สถานะ
				},
            },

            columns: [
                { 'className': "text-center", data: 'firstname', name: 'firstname' },
                { 'className': "text-center", data: 'lastname', name: 'lastname' },
                { 'className': "text-center", data: 'username', name: 'username' },
                { 'className': "text-center", data: 'role', name: 'role' },
                { 'className': "text-center", data: 'colum_status', name: 'colum_status' },
                { 'className': "text-center", data: 'manage', name: 'manage' },
                // { 'className': "text-center", data: 'create_at', name: 'create_at' },
                // { 'className': "text-center", data: 'update_at', name: 'update_at' },
            ],
            order: [[0, 'asc']],
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
            var formData = new FormData(this);
            $.ajax({
               url: "{{ route('officers.store') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){
                    $('#reload_add').waitMe("hide"); // waitme hind
                    $('#modal_add').modal('hide') // modal add hide
                    $('#body_modal_add').load(document.URL + ' #body_modal_add'); // body modal add refresh
                    if(data.response == true){
                        swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "ยืนยัน",
                        }).then((value) => {
                            oTable.draw(); // refresh dadatable
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
               url: "{{ route('api.partners.update') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){
                    $('#reload_edit').waitMe("hide"); // waitme hind
                    $('#modal_edit').modal('hide') // modal add hide
                    $('#body_modal_edit').load(document.URL + ' #body_modal_edit'); // body modal add refresh
                    if(data.response == true){
                        swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "ยืนยัน",
                        }).then((value) => {
                            oTable.draw(); // refresh dadatable
                        });
                    }
                }
            });
        });
    });

    // Model Edit
    $(document).on('click', ".model-data", function() {
        var id = $(this).attr('data-id');
        $("#PreviewImage_e").attr('src',""); // attr image empty
        $("#PreviewImage2_e").attr('src',""); // attr image empty
        $.ajax({
            url: "{{ route('api.officers.edit') }}",
            data: {"_token": "{{ csrf_token() }}", 'id': id},
            type: "POST",
            async: false,
            success:function(data){
                console.log(data);
                if (data.countpartnersproduct == 0) {
                    // alert("ไม่มี");
                    $('#addproducttype').show();
                }

                // datapartnersproduct = data.partnersproduct;
                htmlproduct_type = data.htmlproduct_type;
                data = data.officers;

                // รูปภาพบัตรประชาชน
                if(data.image_citizen != null){
                    image_citizen = "{{asset('storage/uploadfile/partners')}}/"+data.image_citizen;
                }else{
                    image_citizen = "{{asset('public/assets/backend/img/wait_img.png')}}";
                }
                // รูปภาพ ก.พ 20
                if(data.image_kp20 != null){
                    image_kp20 = "{{asset('storage/uploadfile/partners')}}/"+data.image_kp20;
                }else{
                    image_kp20 = "{{asset('public/assets/backend/img/wait_img.png')}}";
                }
                // ==================================================================================

                // Display
                $('#partners_id').val(data.officer_id);
                $('#firstname_e').val(data.firstname);
                $('#username_e').val(data.username);
                $('#password_e').val(data.password);
                $('#space_customer_id_e').val(data.space_customer_id);
                $('#name_customer_e').val(data.name_customer);
                $('#numbertax_e').val(data.numbertax);
                $('#name_e').val(data.name);
                $('#lastname_e').val(data.lastname);
                $('#citizenid_e').val(data.citizenid);
                $('#officers_type_e').val(data.role).trigger('change');
                $('#address_e').val(data.address);
                $('#soi_e').val(data.soi);
                $('#road_e').val(data.road);
                $('#district_e').val(data.district);
                $('#ampure_e').val(data.ampure);
                $('#province_e').val(data.province);
                $('#zipcode_e').val(data.zipcode);
                $('#email_e').val(data.email);
                $('#phone_e').val(data.phone);
                $('#lineid_e').val(data.lineid);
                $('#status_partners_e').val(data.status_partners).trigger('change');
                $('#image_CZ').val(data.image_citizen)
                $('#image_KP').val(data.image_kp20)
                // $('#id').val(data.partners_id)
                $('#PreviewImage_e').attr('src',image_citizen); // image
                $('#PreviewImage2_e').attr('src',image_kp20); // image
                // $('#product_edit').val(dataproduct.product_id); // image
                $('#product_type_edit').html(htmlofficermarket);

            }
        });
    });

    // Preview Image
    function readURL(input,value) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
                if(value == "citizen"){
                    $('#PreviewImage').attr('src', e.target.result);
                }else if(value == "kp20"){
                    $('#PreviewImage2').attr('src', e.target.result);
                }else if(value == "citizen_e"){
                    $('#PreviewImage_e').attr('src', e.target.result);
                }else if(value == "kp20_e"){
                    $('#PreviewImage2_e').attr('src', e.target.result);
                }
			};
			reader.readAsDataURL(input.files[0]);
		}
	}

    // Waitme Reload
    function waitme_reload(value){

        var statusForm = "";
        if(value == "FormAdd"){
            statusForm = '#reload_add';
        }else if(value == "FormEdit"){
            statusForm = '#reload_edit';
        }

		$(statusForm).waitMe({
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
    function addproducttype() {
        $('#modal_product_type').modal('show');
        $('#add_pt').show();
        $('#update_pt').hide();
        $('#title_product_type').html('เพิ่มข้อมูล');
        $('#producttype').val('');
        $('#productcategory').val('');
        $('#product_search').val('');
    }
    function submitaddproducttype() {
        partners_id = $('#partners_id').val();
        product_search = $('#product_search').val();
        $.ajax({
               url: "{{ route('api.partners.addproducttype') }}",
               data:{
                partners_id:partners_id,
                product_search:product_search,
               },
               type:"POST",
            //    async: false,
            //    contentType: false,
            //    processData: false,
               success:function(data){
                console.log(data);
                $('#product_type_edit').html(data.htmlproduct_type);
                $('#modal_product_type').modal('hide');
                $('#addproducttype').hide();
                }
            });

    }
    function changeproducttype(partners_id,product_id) {
        console.log(partners_id , product_id);
        // (partners_id , product_id);
        // $('#product_id').val(product_id);
        $('#product_id_old').val(product_id);
        $('#modal_product_type').modal('show');
        $('#update_pt').show();
        $('#add_pt').hide();
        $('#title_product_type').html('แก้ไขข้อมูล');
        $('#producttype').val('');
        $('#productcategory').val('');
        $('#product_search').val('');
    }
    function searchcategory() {

         producttype = $('#producttype').val();
        //  productcategory = $('#productcategory').val();
         console.log(producttype);
         $.ajax({
               url: "{{ route('api.partners.searchcategory') }}",
               data:{
                producttype:producttype,
                // productcategory:productcategory,
               },
               type:"POST",
            //    async: false,
            //    contentType: false,
            //    processData: false,
               success:function(data){
                console.log(data);
                $('#productcategory').html(data.html_partnercategorys);
                }
            });
    }

        function searchproduct() {

         producttype = $('#producttype').val();
         productcategory = $('#productcategory').val();
         console.log(producttype,productcategory);
         $.ajax({
               url: "{{ route('api.partners.searchproduct') }}",
               data:{
                producttype:producttype,
                productcategory:productcategory,
               },
               type:"POST",
            //    async: false,
            //    contentType: false,
            //    processData: false,
               success:function(data){
                console.log(data);
                $('#product_search').html(data.html_product);
                }
            });
    }
    function updateproducttype() {
         product_search = $('#product_search').val();
         partners_id = $('#partners_id').val();
         product_id_old = $('#product_id_old').val();
         console.log(producttype);
         $.ajax({
               url: "{{ route('api.partners.updateproducttype') }}",
               data:{
                product_search:product_search,
                partners_id:partners_id,
                product_id_old:product_id_old,
               },
               type:"POST",
            //    async: false,
            //    contentType: false,
            //    processData: false,
               success:function(data){
                console.log(data);
                $('#product_type_edit').html(data.htmlproduct_type);
                $('#modal_product_type').modal('hide')
                $('#modal_add').modal('hide') // modal add hide

                // $('#product').html(data.html_product);
                }
            });
    }
    function deleteproducttype(partners_id,product_id) {

         $.ajax({
               url: "{{ route('api.partners.deleteproducttype') }}",
               data:{
                partners_id:partners_id,
                product_id:product_id,
               },
               type:"POST",
            //    async: false,
            //    contentType: false,
            //    processData: false,
               success:function(data){
                console.log(data);
                $('#product_type_edit').html(data.htmlproduct_type);
                $('#modal_product_type').modal('hide')
                $('#modal_add').modal('hide') // modal add hide
                $('#addproducttype').show();
                // $('#product').html(data.html_product);
                }
            });
    }
      // Update Status
      function status(id,name){
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
					url: "{{ route('api.partners.status')}}",
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
</script>



@endsection
