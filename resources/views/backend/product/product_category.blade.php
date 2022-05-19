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
                                <h4>หมวดหมู่สินค้า</h4>
                                <p class="text-muted m-b-10">รายละเอียดหมวดหมู่สินค้า</p>
                                <ul class="breadcrumb-title b-t-default p-t-10"></ul>
                            </div>

                            <!-- block -->
                            <div class="card-block">
                                {{-- Add --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <div class="form-group">
                                                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_add" ><i class="fa fa-plus"></i> เพิ่มข้อมูลหมวดหมู่สินค้า</a>
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
                                                <th class="text-center" width="25%">ประเภท</th>
                                                <th class="text-center" width="25%">ชื่อหมวดหมู่</th>
                                                {{-- <th class="text-center" width="20%">รูปภาพหมวหมู่</th> --}}
                                                <th class="text-center" width="10%">สถานะ</th>
                                                <th class="text-center" width="10%">จัดการ</th>
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
        <form  method="POST" id="form_add" enctype="multipart/form-data">
        {!! csrf_field() !!}
            <div class="modal-dialog modal-lg" id="reload_add">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">เพิ่มข้อมูลหมวดหมู่สินค้า</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body" id="body_modal_add">

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ประเภทสินค้า:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="type" id="type_a" required>
                                    <option value="" >เลือกประเภท</option>
                                    @foreach($type as $types)
                                        <option value="{{$types->type_id}}">{{$types->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อหมวดหมู่:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name" id="name_a" placeholder="ชื่อหมวดหมู่" maxlength="20"  autocomplete="off" required>
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">รูปภาพ:</label>
                            <div class="col-sm-5">
                                <img src="{{URL::asset('public/assets/img/wait_img.png')}}" id="PreviewImage" class="img-fluid img-responsive" style="width:125px;height:125px;" >
                                <p class="c-red">รูปภาพหมวดหมู่สินค้า ขนาดรูปภาพ xxx * xxx px</p>
                                <input type="file" class="form-control" name="image_file" id="image_file_a" onchange='readURL(this);'  autocomplete="off" required>
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
        <form method="POST"  id="form_edit" enctype="multipart/form-data">
        {!! csrf_field() !!}
            <div class="modal-dialog modal-lg" id="reload_edit">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">แก้ไขข้อมูลหมวดหมู่สินค้า</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                     </div>

                     <div class="modal-body" id="body_modal_edit">

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ประเภทสินค้า:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="type" id="type_e" required>
                                    <option value="" disabled selected>เลือกประเภท</option>
                                    @foreach($type as $types)
                                        <option value="{{$types->type_id}}">{{$types->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อหมวดหมู่:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name" id="name_e" placeholder="ชื่อหมวดหมู่" maxlength="20" autocomplete="off" required>
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">รูปภาพ:</label>
                            <div class="col-sm-5">
                                <img src="{{URL::asset('public/assets/img/wait_img.png')}}" id="PreviewImage_e" class="img-fluid img-responsive" style="width:125px;height:125px;" >
                                <p class="c-red">รูปภาพหมวดหมู่สินค้า ขนาดรูปภาพ xxx * xxx px</p>
                                <input type="file" class="form-control" name="image_file" id="image_file_a" onchange='readURL_Edit(this);'  autocomplete="off" required>
                            </div>
                        </div> --}}

                        <input type="hidden" name="id" id="id"> {{-- ID --}}
                        <input type="hidden" name="fileold" id="fileold"> {{-- image --}}

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
        $(".pcoded-submenu>li a[href='{{ route('backend.product.category') }}']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='{{ route('backend.product.category') }}']").parent().parent().parent().addClass("pcoded-trigger");
    });
</script>

<script>

    // Submit Add
    $('#submit_add').click(function(e){
        name  = $('#name_a').val();
        type  = $('#type_a').val();
        if(name != "" && type != ""){
            e.preventDefault();
            $('#form_add').submit();
        }
    });

    // Submit Update
    $('#submit_edit').click(function(e){
        name  = $('#name_e').val();
        type  = $('#type_e').val();
        if(name != "" && type != ""){
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
                url : "{{ route('api.product.category.datatable') }}",
				data: function (d) {
                    d.status_val = $('#status_val').val(); // สถานะ
				},
            },

            columns: [
                { 'className': "text-center", data: 'colum_type', name: 'category_id' },
                { 'className': "text-center", data: 'colum_name', name: 'colum_name' },
                // { 'className': "text-center", data: 'colum_image', name: 'colum_image' },
                { 'className': "text-center", data: 'colum_status', name: 'colum_status' },
                { 'className': "text-center", data: 'colum_manage', name: 'colum_manage' },
            ],
            ordering: false,
            // order: [[0, 'desc']],
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
               url: "{{ route('api.product.category.add') }}",
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
               url: "{{ route('api.product.category.update') }}",
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
        $("#PreviewImage_e").attr('src',""); // attr image empty
        $('#type_e').val(""); // type empty

        $.ajax({
            url: "{{ route('api.product.category.edit') }}",
            data: {"_token": "{{ csrf_token() }}", 'id': id},
            type: "POST",
            async: false,
            success:function(data){

                // image
                if(data.image != null){
                    image_src = "{{asset('storage/uploadfile/productcategory')}}/"+data.image;
                }else{
                    image_src = "{{asset('public/assets/backend/img/wait_img.png')}}";
                }

                $('#id').val(data.category_id); // id
                $('#type_e').val(data.type_id).trigger('change'); // type
                $('#partners_type').val(data.partners_type).trigger('change'); // type
                $('#name_e').val(data.name); // name category
                $('#PreviewImage_e').attr('src',image_src); // image
                $('#fileold').val(data.image); // image value old

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
					url: "{{ route('api.product.category.status')}}",
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

    // Preview Image Add
    function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#PreviewImage').attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}

    // Preview Image Edit
    function readURL_Edit(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#PreviewImage_e').attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}



</script>



@endsection
