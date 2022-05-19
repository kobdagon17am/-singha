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
                                <h4>รายชื่อผู้เช่ารอการอนุมัติ</h4>
                                <p class="text-muted m-b-10">รายละเอียดข้อมูลรายชื่อผู้เช่ารอการอนุมัติ</p>
                                <ul class="breadcrumb-title b-t-default p-t-10">

                                </ul>
                            </div>

                            <!-- block -->
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <div class="form-group">
                                                {{-- <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_add" ><i class="fa fa-plus"></i> เพิ่มข้อมูลรายการสินค้า</a>		 --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="dt-responsive table-responsive">
                                    <table id="datatables" class="table  table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="30%">ชื่อลูกค้า</th>
                                                <th class="text-center" width="15%">ชื่อจริง</th>
                                                <th class="text-center" width="15%">นามสกุล</th>
                                                <th class="text-center" width="15%">เบอร์โทร</th>
                                                <th class="text-center" width="15%">สถานะ</th>
                                                <th class="text-center" width="15%">จัดการ</th>
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

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">Username:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="username" id="username_e" placeholder="Username"  autocomplete="off" readonly required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">Password:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="password" id="password_e" placeholder="Password"  autocomplete="off" readonly required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อลูกค้า/นิติบุคล:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name_customer" id="name_customer_e" placeholder="ชื่อลูกค้า/นิติบุคล"  autocomplete="off" readonly required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">เลขที่ประจำตัวผู้เสียภาษี:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="numbertax" id="numbertax_e" placeholder="เลขที่ประจำตัวผู้เสียภาษี"  autocomplete="off" readonly required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อ:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name" id="name_e" placeholder="ชื่อ"  autocomplete="off" readonly required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">สกุล:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="lastname" id="lastname_e" placeholder="สกุล"  autocomplete="off" readonly required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">หมายเลขบัตร:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="citizenid" id="citizenid_e" placeholder="หมายเลขบัตร"  autocomplete="off" readonly required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ประเภทสมาชิก:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="partners_type" id="partners_type_e" readonly required>
                                    @foreach($partnerstype as $type)
                                        <option value="{{$type->partners_type_id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ที่อยู่:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="address" id="address_e" placeholder="ที่อยู่"  autocomplete="off" readonly required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ซอย:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="soi" id="soi_e" placeholder="ซอย"  autocomplete="off" readonly  required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ถนน:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="road" id="road_e" placeholder="ถนน"  autocomplete="off" readonly required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">จังหวัด:</label>
                            <div class="col-sm-5">
                                {{-- <input type="text" class="form-control" name="province" id="province_e" placeholder="จังหวัด"  autocomplete="off" required> --}}
                                <select class="form-control" name="province" id="province_e" required >
                                    @foreach($province as $type)
                                        <option value="{{$type->id}}">{{$type->name_th}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">อำเภอ:</label>
                            <div class="col-sm-5">
                                {{-- <input type="text" class="form-control" name="ampure" id="ampure_e" placeholder="อำเภอ"  autocomplete="off" required> --}}
                                <select class="form-control" name="ampure" id="ampure_e" required>
                                    @foreach($district as $type)
                                        <option value="{{$type->id}}">{{$type->name_th}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ตำบล:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="district" id="district_e" required >
                                    @foreach($subdistrict as $type)
                                        <option value="{{$type->id}}">{{$type->name_th}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">รหัสไปรษณีย์:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="zipcode" id="zipcode_e" placeholder="รหัสไปรษณีย์"  autocomplete="off" readonly required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">อีเมล์:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="email" id="email_e" placeholder="อีเมล์"  autocomplete="off" readonly required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">เบอร์โทร:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="phone" id="phone_e" placeholder="เบอร์โทร"  autocomplete="off" readonly required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ไลน์:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="lineid" id="lineid_e" placeholder="ไลน์"  autocomplete="off" readonly required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">สถานะสมาชิก:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="status_partners" id="status_partners_e" readonly required>
                                    <option value="A">เกรด A</option>
                                    <option value="B">เกรด B</option>
                                </select>

                            </div>
                        </div>
                        <div  id="product_type_edit">

                        </div>
                        {{-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">รูปบัตรประชาชน:</label>
                            <div class="col-sm-5">
                                <img src="{{URL::asset('public/assets/img/wait_img.png')}}" id="PreviewImage_e" class="img-fluid img-responsive" style="width:600px;height:200px;" >
                                <p class="c-red">รูปภาพบัตรประชาชน</p>

                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">รูปภาพ ภ.พ. 20:</label>
                            <div class="col-sm-5">
                                <img src="{{URL::asset('public/assets/img/wait_img.png')}}" id="PreviewImage2_e" class="img-fluid img-responsive" style="width:600px;height:200px;" >
                                <p class="c-red">รูปภาพ ภ.พ. 20</p>
                                {{-- <input type="file" class="form-control" name="imge_KP" id="imge_KP_e" onchange='readURL(this,"kp20_e");'  autocomplete="off" required> --}}
                            </div>
                        </div>

                        <input type="hidden" name="image_CZ" id="image_CZ">
                        <input type="hidden" name="image_KP" id="image_KP">
                        <input type="hidden" name="id" id="id">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        {{-- <button class="btn btn-primary" id="submit_edit">บันทึก</button> --}}
                    </div>
                 </div>
            </div>
        </form>
    </div>

@endsection

@section('script')

<script>
    $(document).ready(function(){
        $(".pcoded-submenu>li a[href='{{ route('backend.partners.approve') }}']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='{{ route('backend.partners.approve') }}']").parent().parent().parent().addClass("pcoded-trigger");
    });
</script>


<script>

    $(document).ready(function(){
        // Datable
        var oTable = $("#datatables").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthChange: true,
            stateSave: true,

			ajax:{
                url : "{{ route('api.partners.approve.datatable') }}",
				data: function (d) {
                    // d.status_val = $('#status_val').val(); // สถานะ
				},
            },

            columns: [
                { 'className': "text-center", data: 'colum_name_customer', name: 'colum_name_customer' },
                { 'className': "text-center", data: 'colum_name', name: 'colum_name' },
                { 'className': "text-center", data: 'colum_lastname', name: 'colum_lastname' },
                { 'className': "text-center", data: 'colum_phone', name: 'colum_phone' },
                { 'className': "text-center", data: 'colum_status', name: 'colum_status' },
                { 'className': "text-center", data: 'colum_manage', name: 'colum_manage' },
            ],
            order: [[0, 'asc']],
            rowCallback: function(row,data,index ){
				// rowCallback
			}
        });
    });

    // Model Edit
    $(document).on('click', ".model-data", function() {
        var id = $(this).attr('data-id');

        $("#PreviewImage_e").attr('src',""); // attr image empty
        $("#PreviewImage2_e").attr('src',""); // attr image empty

        $.ajax({
            url: "{{ route('api.partners.approve.view') }}",
            data: {"_token": "{{ csrf_token() }}",'id':id},
            type: "POST",
            async: false,
            success:function(data){
                console.log(data);
                if (data.countpartnersproduct == 0) {
                    // alert("ไม่มี");
                    $('#addproducttype').show();
                }
                htmlproduct_type = data.htmlproduct_type;
                data = data.partners;
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
                $('#username_e').val(data.username);
                $('#password_e').val(data.password);
                $('#name_customer_e').val(data.name_customer);
                $('#numbertax_e').val(data.numbertax);
                $('#name_e').val(data.name);
                $('#lastname_e').val(data.lastname);
                $('#citizenid_e').val(data.citizenid);
                $('#partners_type_e').val(data.partners_type).trigger('change');
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
                $('#id').val(data.partners_id)
                $('#PreviewImage_e').attr('src',image_citizen); // image
                $('#PreviewImage2_e').attr('src',image_kp20); // image

                $('#product_type_edit').html(htmlproduct_type);
            }
        });
    });

    // Update Status
    function approve(id,name){
		bootbox.confirm({
			title: "ยืนยัน ?",
			message: "คุณต้องการอนุมัติใช้งานผู้ลงทะเบียน <font color='red'>"+ name +"</font> นี้หรือไม่ ?",
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
					url: "{{ route('api.partners.approve.status')}}",
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

    // Delete
    function datadelete(id,name){
		bootbox.confirm({
			title: "ยืนยัน ?",
			message: "คุณต้องการลบข้อมูลลงทะเบียน <font color='red'>"+ name +"</font> นี้หรือไม่ ?",
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
					url: "{{ route('api.partners.approve.delete')}}",
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
