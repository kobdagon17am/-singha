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
                                <h4>ประเภทสินค้า</h4>
                                <p class="text-muted m-b-10">รายละเอียดประเภทสินค้า</p>
                                <ul class="breadcrumb-title b-t-default p-t-10"></ul>
                            </div>

                            <!-- block -->
                            <div class="card-block">

                                {{-- Add --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <div class="form-group">
                                                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_add" ><i class="fa fa-plus"></i> เพิ่มข้อมูลประเภทสินค้า</a>
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
                                <div class="dt-responsive table-responsive" id="div_datatables">
                                    <table id="datatables" class="table  table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="60%">ชื่อประเภท</th>
                                                <th class="text-center" width="20%">ประเภทสมาชิก</th>
                                                <th class="text-center" width="20%">สถานะ</th>
                                                <th class="text-center" width="20%">จัดการ</th>
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
    <form  method="POST" id="form_add" >
    {!! csrf_field() !!}
            <div class="modal-dialog modal-lg" id="reload_add">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">เพิ่มข้อมูลประเภทสินค้า</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body" id="body_modal_add">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อประเภทสินค้า:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name" id="name_a" placeholder="ชื่อประเภทสินค้า"  autocomplete="off" maxlength="20" required>
                            </div>


                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ประเภทสมาชิก:</label>
                            <div class="col-sm-5">
                                <select class="form-control" style="width:108%;" name="partners_type" id="partners_type">
                                    <option value="T" selected>ทั้งหมด</option>
                                    @foreach ($partnerstype as $item)
                                <option value="{{$item->partners_type_id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>

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
        <form method="POST" id="form_edit">
        {!! csrf_field() !!}
            <div class="modal-dialog modal-lg" id="reload_edit">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">แก้ไขข้อมูลประเภทสินค้า</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                     </div>

                    <div class="modal-body" id="body_modal_edit">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อประเภทสินค้า:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name" id="name_e" placeholder="ชื่อประเภทสินค้า"  autocomplete="off" maxlength="20" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ประเภทสมาชิก:</label>
                            <div class="col-sm-5">
                                <select class="form-control" style="width:108%;" name="partners_type" id="partners_type_e">
                                    <option value="T" selected>ทั้งหมด</option>
                                    @foreach ($partnerstype as $item)
                                <option value="{{$item->partners_type_id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <input type="hidden" name="id" id="id">  {{-- ID --}}
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
        $(".pcoded-submenu>li a[href='{{ route('backend.product.type') }}']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='{{ route('backend.product.type') }}']").parent().parent().parent().addClass("pcoded-trigger");
    });
</script>

<script>

    // Submit Add
    $('#submit_add').click(function(e){
        name  = $('#name_a').val();
        if(name != ""){
            e.preventDefault();
            $('#form_add').submit();
        }
    });

    // Submit Update
    $('#submit_edit').click(function(e){
        name  = $('#name_e').val();
        if(name != ""){
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
                url : "{{ route('api.product.type.datatable') }}",
				data: function (d) {
                    d.status_val = $('#status_val').val(); // สถานะ
				},
            },

            columns: [
                { 'className': "text-center", data: 'colum_name', name: 'type_id' },
                { 'className': "text-center", data: 'partners_type', name: 'partners_type' },
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
               url: "{{ route('api.product.type.add') }}",
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
               url: "{{ route('api.product.type.update') }}",
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
        $.ajax({
            url: "{{ route('api.product.type.edit') }}",
            data: {"_token": "{{ csrf_token() }}", 'id': id},
            type: "POST",
            async: false,
            success:function(data){
                $('#id').val(data.type_id);
                $('#name_e').val(data.name);
                $('#partners_type_e').val(data.partners_type);
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
					url: "{{ route('api.product.type.status')}}",
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
