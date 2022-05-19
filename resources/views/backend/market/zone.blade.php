@extends('backend/inc_main') {{-- main.blade.php --}}

 @section('title','| All Tags')

@section('stylesheet')

@endsection

@section('content')

<style>
    .modal-lg {
        max-width: 700px !important;
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
                                <h4>จัดการ Zone</h4>
                                <p class="text-muted m-b-10">รายละเอียดจัดการ Zone</p>
                                <ul class="breadcrumb-title b-t-default p-t-10">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('backend.dashboard') }}">
                                        <i class="fa fa-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('backend.market.name') }}">รายชื่อตลาด</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('backend.market.name') }}">{{$market->name_market}}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="">จัดการ Zone</a>
                                    </li>
                                </ul>
                            </div>

                            <!-- block -->
                            <div class="card-block">
                                {{-- add --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <div class="form-group">
                                                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_add" ><i class="fa fa-plus"></i> เพิ่มข้อมูล Zone</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- datatable --}}
                                <div class="dt-responsive table-responsive">
                                    <table id="datatables" class="table  table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                {{-- <th class="text-center" width="35%">ชื่อ Floor</th> --}}
                                                <th class="text-center" width="35%">ชื่อ Zone</th>
                                                <th class="text-center" width="10%">สถานะ</th>
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

    <!-- Modal Add -->
    <div class="modal fade" id="modal_add" role="dialog" >
        <form  method="POST" id="form_add">
        {!! csrf_field() !!}
            <div class="modal-dialog modal-lg" id="reload_add">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">เพิ่มข้อมูล Zone</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body" id="body_modal_add">
                        {{-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อชั้น:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="floor" id="floor_a" required>
                                    @foreach($floor as $floors)
                                        <option value="{{$floors->floor_id}}">{{$floors->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อพื้นที่:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="zone" id="zone_a" placeholder="ชื่อพื้นที่"  autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">รูปภาพรายละเอียดzone:</label>
                            <div class="col-sm-5">
                                <img src="{{asset('public/assets/backend/img/wait_img.png')}}" id="PreviewImage"
                                    class="img-fluid img-responsive" style="width:400px;height:200px;">
                                <p class="c-red">รูปภาพรายละเอียดบูธ ขนาดรูปภาพ xxx * xxx px</p>
                                <input type="file" class="form-control" name="zone_image" id="fileimg_gallery"
                                    onchange="readURL(this);" autocomplete="off" required="">
                            </div>
                        </div>
                        <input type="hidden" name="marketname_id" value="{{$market->marketname_id}}" /> <!-- ID Market -->
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
                        <h4 class="modal-title ">แก้ไขข้อมูล Zone</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body" id="body_modal_edit">
                        {{-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อชั้น:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="floor" id="floor_e" required>
                                    @foreach($floor as $floors)
                                        <option value="{{$floors->floor_id}}">{{$floors->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อพื้นที่:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="zone" id="zone_e" placeholder="ชื่อพื้นที่"  autocomplete="off" required>
                            </div>
                        </div>
                          <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-right">รูปภาพรายละเอียดzone:</label>
                        <div class="col-sm-5">
                            <img src="{{asset('public/assets/backend/img/wait_img.png')}}" id="PreviewImage_e"
                                class="img-fluid img-responsive" style="width:400px;height:200px;">
                            <p class="c-red">รูปภาพรายละเอียดบูธ ขนาดรูปภาพ xxx * xxx px</p>
                            <input type="file" class="form-control" name="zone_image_e" id="fileimg_gallery_e"
                                onchange="readURL_Edit(this);" autocomplete="off" required="">
                        </div>
                    </div>
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



<input type="hidden" id="marketID" value="{{$market->marketname_id}}" />
@endsection

@section('script')

<script>
    $(document).ready(function(){
        var route_URL = "{{ route('backend.market.name') }}"; // URL
        $(".pcoded-submenu>li a[href='"+route_URL+"']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='"+route_URL+"']").parent().parent().parent().addClass("pcoded-trigger");
    });
</script>

<script>

    // Submit Add
    $('#submit_add').click(function(e){
        floor_a  = $('#floor_a').val();
        zone_a  = $('#zone_a').val();
        if(zone_a != "" && floor_a != ""){
            e.preventDefault();
            $('#form_add').submit();
        }
    });

    // Submit Update
    $('#submit_edit').click(function(e){
        floor_e  = $('#floor_e').val();
        zone_e  = $('#zone_e').val();
        if(floor_e != "" && zone_e != ""){
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
			ajax:{
                url : "{{ route('api.market.zone.datatable') }}",
				data: function (d) {
                    d.marketID = $('#marketID').val(); // ID Market
				},
            },

            columns: [
                // { 'className': "text-center", data: 'colum_floor', name: 'zone_id' },
                { 'className': "text-center", data: 'colum_zone', name: 'colum_zone' },
                { 'className': "text-center", data: 'colum_status', name: 'colum_status' },
                { 'className': "text-center", data: 'colum_manage', name: 'colum_manage' },
            ],
            order: [[0, 'asc']],
            rowCallback: function(row,data,index ){
				// rowCallback
			}
        });

        // Form Add
        $('#form_add').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
               url: "{{ route('api.market.zone.add') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){
                    $('#modal_add').modal('hide')
                    $('#body_modal_add').load(document.URL + ' #body_modal_add');
                    if(data.response == true){
                        swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "ยืนยัน",
                        }).then((value) => {
                            oTable.draw();
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
               url: "{{ route('api.market.zone.update') }}",
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
            url: "{{ route('api.market.zone.edit') }}",
            data: {"_token": "{{ csrf_token() }}", 'id': id},
            type: "POST",
            async: false,
            success:function(data){
                if (data.zone_image != null) {
                    image_src = data.zone_image;
                } else {
                    image_src = "{{asset('public/assets/backend/img/wait_img.png')}}";
                }

                $('#id').val(data.zone_id);
                $('#zone_e').val(data.name);
                $('#floor_e').val(data.floor_id).trigger('change'); // type
                $('#PreviewImage_e').attr('src', image_src); // image
            }
        });
    });
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
					url: "{{ route('api.market.zone.status')}}",
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
     // Update Status
     function destroy(id,name){
		bootbox.confirm({
			title: "ยืนยัน ?",
			message: "คุณต้องการลบข้อมูลบูธ <font color='red'>"+name+"</font> นี้หรือไม่ ?",
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
					url: "{{ route('api.market.zone.delete')}}",
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
