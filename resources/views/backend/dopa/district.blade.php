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
                                <h4>รายชื่อเขต</h4>
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
                                {{-- <div class="d-flex justify-content-end">
                                    <p style="margin-top: 6px;">Show</p>
                                    <div class="col-sm-2">
                                        <select class="form-control" style="width:108%;" name="status_val" id="status_val">
                                            <option value="Y">ใช้งาน</option>
                                            <option value="N">ระงับใช้งาน</option>
                                            <option value="T" selected>ทั้งหมด</option>
                                        </select>
                                    </div>
                                </div><br> --}}

                                {{-- Datatable --}}
                                <div class="dt-responsive table-responsive">
                                    <table id="datatables" class="table  table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ชื่อเขต</th>
                                                {{-- <th class="text-center">นามสกุล</th>
                                                <th class="text-center">Username</th>
                                                <th class="text-center">ประเภทสมาชิก</th>
                                                <th class="text-center">สถานะ</th> --}}
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
                        <label class="col-sm-4 col-form-label text-right">ชื่อจังหวัด:</label>
                        <div class="col-sm-5">
                            <select name="province" id="province" class="form-control" >
                                @foreach ($province as $item)
                                <option value="{{$item->id}}">{{$item->name_th}}</option>
                                @endforeach

                            </select>

                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-right">ชื่อเขต:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="name_th" id="name_th"  >
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                    <button class="btn btn-primary" onclick="add()">บันทึก</button>
                </div>
            </div>
        </div>

        </form>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modal_edit" role="dialog">
        <form method="POST"  id="form_edit">
        {!! csrf_field() !!}
            <div class="modal-dialog " id="reload_edit">
                <div class="modal-content">
                    <input type="hidden" id="id_district" name="id_district">
                    <div class="modal-header">
                        <h4 class="modal-title ">แก้ไขข้อมูล</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                     </div>

                     <div class="modal-body" id="body_modal_edit">

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อจังหวัด:</label>
                            <div class="col-sm-5">
                                <select name="province" id="province_e" class="form-control" >
                                    @foreach ($province as $item)
                                    <option value="{{$item->id}}">{{$item->name_th}}</option>
                                    @endforeach

                                </select>

                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อเขต:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name_th" id="name_th_e"  >
                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        <button  type="button" class="btn btn-primary" onclick="edit()">บันทึก</button>
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
        $(".pcoded-submenu>li a[href='{{ url('backoffice/district') }}']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='{{ url('backoffice/district') }}']").parent().parent().parent().addClass("pcoded-trigger");
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
                url : "{{ route('api.district.datatable') }}",
                type: "POST",
				data: function (d) {
                    d.status_val = $('#status_val').val(); // สถานะ
				},
            },

            columns: [
                { 'className': "text-center", data: 'name_th', name: 'name_th' },
                // { 'className': "text-center", data: 'lastname', name: 'lastname' },
                // { 'className': "text-center", data: 'username', name: 'username' },
                // { 'className': "text-center", data: 'role', name: 'role' },
                // { 'className': "text-center", data: 'colum_status', name: 'colum_status' },
                { 'className': "text-center", data: 'manage', name: 'manage' },
                // { 'className': "text-center", data: 'create_at', name: 'create_at' },
                // { 'className': "text-center", data: 'update_at', name: 'update_at' },
            ],
            order: [[0, 'asc']],
            rowCallback: function(row,data,index ){
				// rowCallback
			}
        });
    });
        // Sort Status | Datatable
        $('#status_val').change(function(e){
            oTable.draw();
        });

    // Form Add
    $('#form_add').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($('#form_add')[0])
            $.ajax({
               url: "{{ url('adddistrict') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){
                    $('#reload_add').waitMe("hide"); // waitme hind
                    $('#modal_add').modal('hide') // modal add hide
                    $('#body_modal_add').load(document.URL + ' #body_modal_add'); // body modal add refresh
                    $('#datatables').DataTable().ajax.reload();
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
       function show(keep) {
             console.log(keep);

            // e.preventDefault();
            // var formData = new FormData(this);

            $.ajax({
               url: "{{ url('showdistrict') }}",
               data:{
                keep:keep,
                // product_search:product_search,
               },
               type:"POST",
               async: false,
            //  contentType: false,
            //  processData: false,
               success:function(data){
                $('#modal_edit').modal('show');
                $('#id_district').val(data.id);
                $('#province_e').val(data.province_id);
                $('#name_th_e').val(data.name_th); // waitme hind
                    // $('#reload_edit').waitMe("hide"); // waitme hind

                }
            });

        }
        // Form Update
        function edit() {



            // e.preventDefault();
            var formData = new FormData($('#form_edit')[0])
            $.ajax({
               url: "{{ url('editdistrict') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){
                    // $('#reload_edit').waitMe("hide"); // waitme hind
                    $('#datatables').DataTable().ajax.reload();
                    $('#modal_edit').modal('hide') // modal add hide
                    // $('#body_modal_edit').load(document.URL + ' #body_modal_edit'); // body modal add refresh

                }
            });

        }
         // Form Update
         function destroy(keep) {
            bootbox.confirm({
			title: "ยืนยัน ?",
			message: "คุณต้องการยกเลิกข้อมูลนี้หรือไม่ ?",
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
            callback: function (result) {
                console.log(result);
                if (result != "" && result != null) {
                    // var formData = new FormData(this);
                        $.ajax({
                        url: "{{ url('deletedistrict') }}",
                        data:{
                            keep:keep,
                            // product_search:product_search,
                        },
                        type:"POST",
                        async: false,
                        success:function(data){
                                $('#reload_edit').waitMe("hide"); // waitme hind
                                $('#modal_edit').modal('hide') // modal add hide
                                $('#body_modal_edit').load(document.URL + ' #body_modal_edit'); // body modal add refresh
                                $('#datatables').DataTable().ajax.reload();
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
                }
            }
        });

        }
</script>



@endsection
