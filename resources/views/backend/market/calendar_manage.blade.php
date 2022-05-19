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
                            <h4>จัดการวันหยุด</h4>
                            <p class="text-muted m-b-10">รายละเอียดข้อมูลจัดการวันหยุด</p>
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
                                        <a href="">จัดการวันหยุด</a>
                                    </li>
                                </ul>
                            </div>

                            <!-- block -->
                            <div class="card-block">
                                {{-- Add --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class=" col-2">
                                            <h6>ค้นหา</h6>
                                            {{-- <input type="month" class="form-control" name="" id="month_serach" onchange="resetable()"> --}}
                                            <select class="form-control" id="month_serach" onchange="resetable()" >
                                                @foreach ($year as $item)
                                                <option value="{{ date("Y", strtotime($item->created_at)) }}">ปี {{ date("Y", strtotime($item->created_at)) }}</option>
                                                @endforeach

                                                <option selected value="{{ date("Y") }}">ปี {{ date("Y") }}</option>

                                                @for ($i = 1; $i < 5; $i++)

                                                <option value="{{ date("Y") + $i}} ">ปี {{ date("Y") + $i}}</option>
                                                @endfor
                                                {{-- @for ($i = 0; $i < 10; $i++)

                                                <option value="{{ 2016+$i }}">{{ 2016+$i }}</option>
                                                @endfor --}}
                                            </select>
                                        </div>
                                        <div class="text-right ">

                                            <div class="form-group row">

                                                <div class="col-12">
                                                <a href="{{ route('backend.market.calendar.holiday', array('id'=>$market->marketname_id)) }}" class="btn btn-dark" ><i class="fa fa-calendar"></i> ปฏิทินวันหยุด</a>
                                                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_add" ><i class="fa fa-plus"></i> เพิ่มวันหยุดตลาด</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Datable --}}
                                <div class="dt-responsive table-responsive">
                                    <table id="datatables" class="table  table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">วันเริ่มต้น</th>
                                                <th class="text-center">ถึงวันที่</th>
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
                        <h4 class="modal-title ">เพิ่มข้อมูลวันหยุดตลาด</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body" id="body_modal_add">

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ตลาด:</label>
                            <div class="col-sm-5">
                            <input type="text" class="form-control" name="marketname_id" value="{{$market->name_market}}" readonly  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">วันเริ่มต้น:</label>
                            <div class="col-sm-5">
                                <input type="date" class="form-control" name="date_start" id=""  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ถึงวันที่:</label>
                            <div class="col-sm-5">
                                <input type="date" class="form-control" name="date_end" id=""  >
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
                        <h4 class="modal-title ">แก้ไขข้อมูลวันหยุดตลาด</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body" id="body_modal_edit">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ตลาด:</label>
                            <div class="col-sm-5">
                            <input type="text" class="form-control" name="" id="" value="{{$market->name_market}}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">วันเริ่มต้น:</label>
                            <div class="col-sm-5">
                                <input type="date" class="form-control" name="date_start" id="date_start_e"  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ถึงวันที่:</label>
                            <div class="col-sm-5">
                                <input type="date" class="form-control" name="date_end" id="date_end_e"  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">สถานะ:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="status" id="status_e" required>
                                    <option value="Y">ใช้งาน</option>
                                    <option value="N">ปิดการใช้งาน</option>
                                </select>
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
    function resetable(params) {
        $('#datatables').DataTable().ajax.reload();
    }
</script>


<script>

    $(document).ready(function(){
        //Datable
        var oTable = $("#datatables").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthChange: true,
            // stateSave: true,

			ajax:{
                url : "{{ route('api.market.calendar.datatable') }}",
				data: function (d) {
                    d.marketID = $('#marketID').val(); // สถานะ
                    d.month_serach = $('#month_serach').val(); // สถานะ
				},
            },

            columns: [
                { 'className': "text-center", data: 'colum_date_startr', name: 'colum_date_startr' },
                { 'className': "text-center", data: 'colum_date_end', name: 'colum_date_end' },
                { 'className': "text-center", data: 'colum_status', name: 'colum_status' },
                { 'className': "text-center", data: 'colum_manage', name: 'colum_manage' },
            ],
            // order: [[0, 'asc']],
            ordering: false,
            rowCallback: function(row,data,index ){
				// rowCallback
			}
        });

        // Form Add
        $('#form_add').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
               url: "{{ route('api.market.calendar.add') }}",
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
               url: "{{ route('api.market.calendar.update') }}",
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
            url: "{{ route('api.market.calendar.edit') }}",
            data: {"_token": "{{ csrf_token() }}", 'id': id},
            type: "POST",
            async: false,
            success:function(data){


                var start = data.date_start.split(" ");
                var end = data.date_end.split(" ");


                $('#id').val(data.calendar_id);
                $('#date_start_e').val(start[0]);
                $('#date_end_e').val(end[0]);
                $('#status_e').val(data.status).trigger('change');
            }
        });
    });

        // Delate
        function deletedata(id){
		bootbox.confirm({
			title: "ยืนยัน ?",
			message: "คุณต้องการลบข้อมูล นี้หรือไม่ ?",
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
					url: "{{ route('api.market.calendar.delete')}}",
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
