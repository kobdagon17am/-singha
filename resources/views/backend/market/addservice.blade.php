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
                                <h4>ข้อมูลบริการเสริม</h4>
                                <p class="text-muted m-b-10">รายละเอียดข้อมูลบริการเสริม</p>
                                <ul class="breadcrumb-title b-t-default p-t-10"></ul>
                            </div>

                            <!-- block -->
                            <div class="card-block">
                                {{-- Add --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <div class="form-group">
                                                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_add" ><i class="fa fa-plus"></i> เพิ่มข้อมูลบริการเสริม</a>
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
                                                <th class="text-center">Id_service</th>
                                                <th class="text-center">รูปภาพ</th>
                                                <th class="text-center">ชื่อสินค้า</th>
                                                <th class="text-center">ราคา</th>
                                                <th class="text-center">จำนวน</th>
                                                <th class="text-center">วันทำการ</th>
                                                <th class="text-center">สถานะ</th>
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
                        <h4 class="modal-title ">เพิ่มข้อมูลบริการเสริม</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body" id="body_modal_add">

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">เลือกบริการ:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="service" id="service_a" required>
                                    <option value="1">อุปกรณ์เสริมมาตรฐาน</option>
                                    <option value="2">อุปกรณ์เสริม</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อสินค้า:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name" id="name_a" placeholder="ชื่อสินค้า"  autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">จำนวน:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control numbers checknumber" name="amount" id="amount_a" placeholder="จำนวน"  autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ราคา:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control numbers checknumber" name="price" id="price_a" placeholder="ราคา"  autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">Vat :</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="vat" id="vat" required>
                                    <option value="Y">คำนวณ Vat</option>
                                    <option value="N">ไม่คำนวณ Vat</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">รูปภาพ:</label>
                            <div class="col-sm-5">
                                <img src="{{URL::asset('public/assets/img/wait_img.png')}}" id="PreviewImage" class="img-fluid img-responsive" style="width:600px;height:200px;" >
                                <p class="c-red">รูปภาพสำหรับบริการเสริม ขนาดรูปภาพ 250 * 250 px</p>
                                <input type="file" class="form-control" name="image_file" id="image_file_a" onchange='readURL(this);'  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">รหัสSpace:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="space_id_service" id="space_id_service" placeholder="รหัสSpace" >
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
                        <h4 class="modal-title ">แก้ไขข้อมูลบริการเสริม</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                     </div>

                     <div class="modal-body" id="body_modal_edit">

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">เลือกบริการ:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="service" id="service_e" required>
                                    <option value="1">อุปกรณ์เสริมมาตรฐาน</option>
                                    <option value="2">อุปกรณ์เสริม</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อสินค้า:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name" id="name_e" placeholder="ชื่อสินค้า"  autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">จำนวน:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control numbers checknumber" name="amount" id="amount_e" placeholder="จำนวน"  autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ราคา:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control numbers checknumber" name="price" id="price_e" placeholder="ราคา"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">Vat :</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="vat" id="vat_e" required>
                                    <option value="Y">คำนวณ Vat</option>
                                    <option value="N">ไม่คำนวณ Vat</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">รูปภาพ:</label>
                            <div class="col-sm-5">
                                <img src="{{URL::asset('public/assets/img/wait_img.png')}}" id="PreviewImage_e" class="img-fluid img-responsive" style="width:600px;height:200px;" >
                                <p class="c-red">รูปภาพสำหรับบริการเสริม ขนาดรูปภาพ 250 * 250 px</p>
                                <input type="file" class="form-control" name="image_file" id="image_file_e" onchange='readURL_Edit(this);'  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">รหัส Space:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control " name="space_id_service" id="space_id_service_e" placeholder="รหัส Space"  required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ID_Svervice:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="id_service_e" placeholder="ราคา" readonly >
                            </div>
                        </div>

                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="fileold" id="fileold">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        <button class="btn btn-primary" id="submit_edit">บันทึก</button>
                    </div>
                 </div>
            </div>
        </form>
    </div>

@endsection

@section('script')

<script>
    $(document).ready(function(){
        $(".pcoded-submenu>li a[href='{{ route('backend.market.addservice') }}']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='{{ route('backend.market.addservice') }}']").parent().parent().parent().addClass("pcoded-trigger");
    });
</script>


<script>

    // Submit Add
    $('#submit_add').click(function(e){
        name  = $('#name_a').val();
        amount  = $('#amount_a').val();
        price  = $('#price_a').val();
        if(name != "" && amount != "" && price != ""){
            e.preventDefault();
            $('#form_add').submit();
        }
    });

    // Submit Update
    $('#submit_edit').click(function(e){
        name  = $('#name_e').val();
        amount  = $('#amount_e').val();
        price  = $('#price_e').val();
        if(name != "" && amount != "" && price != ""){
            e.preventDefault();
            $('#form_edit').submit();
        }
    });

    $(document).ready(function(){

        //Datable
        var oTable = $("#datatables").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthChange: true,
            stateSave: true,

			ajax:{
                url : "{{ route('api.market.service.datatable') }}",
				data: function (d) {
                    d.status_val = $('#status_val').val(); // สถานะ
				},
            },

            columns: [
                { 'className': "text-center", data: 'service_id', name: 'service_id' },
                { 'className': "text-center", data: 'colum_image', name: 'service_id' },
                { 'className': "text-center", data: 'colum_name', name: 'colum_name' },
                { 'className': "text-center", data: 'colum_price', name: 'colum_price' },
                { 'className': "text-center", data: 'colum_amount', name: 'colum_amount' },
                { 'className': "text-center", data: 'colum_created_at', name: 'colum_created_at' },
                { 'className': "text-center", data: 'colum_status', name: 'colum_status' },
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
            var formData = new FormData(this);
            $.ajax({
               url: "{{ route('api.market.service.add') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){
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
               url: "{{ route('api.market.service.update') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){
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

    // Modal Edit
    $(document).on('click', ".model-data", function() {
        var id = $(this).attr('data-id');
        $("#PreviewImage_e").attr('src',"");
        $.ajax({
            url: "{{ route('api.market.service.edit') }}",
            data: {"_token": "{{ csrf_token() }}", 'id': id},
            type: "POST",
            async: false,
            success:function(data){
                // image
                if(data.image != null){
                    image_src = "{{asset('storage/uploadfile/service')}}/"+data.image;
                }else{
                    image_src = "{{asset('public/assets/backend/img/wait_img.png')}}";
                }
                $('#id').val(data.service_id);
                $('#service_e').val(data.service).trigger('change');
                $('#name_e').val(data.name);
                $('#amount_e').val(data.amount);
                $('#price_e').val(data.price);
                $('#PreviewImage_e').attr('src',image_src);
                $('#fileold').val(data.image);
                $('#space_id_service_e').val(data.service_space_id);
                $('#id_service_e').val(data.service_id);
                $('#vat_e').val(data.vat);
            }
        });
    });

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
					url: "{{ route('api.market.service.status')}}",
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

    // Preview Image
    function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#PreviewImage').attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
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

    // Check Number
    $('.numbers').keydown(function(e){
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
			(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
			(e.keyCode >= 35 && e.keyCode <= 40)){
			return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)){
            e.preventDefault();
        }
    });

    $('.checknumber').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

</script>



@endsection
