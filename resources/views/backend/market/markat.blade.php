@extends('backend.inc_main') {{-- main.blade.php --}}

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
                                <h4>รายชื่อตลาด</h4>
                                <p class="text-muted m-b-10">รายละเอียดข้อมูลรายชื่อตลาด</p>
                                <ul class="breadcrumb-title b-t-default p-t-10">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('backend.dashboard') }}">
                                        <i class="fa fa-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="">รายชื่อตลาด</a>
                                    </li>
                                </ul>
                            </div>

                            <!-- block -->
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <div class="form-group">
                                                <a href="{{ route('backend.market.name.create') }}" class="btn btn-dark" ><i class="fa fa-plus"></i> เพิ่มข้อมูลตลาด</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- datatable --}}
                                <div class="dt-responsive table-responsive">
                                    <table id="datatables" class="table  table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="65%">ชื่อตลาด</th>
                                                <th class="text-center" width="10%">เวลาทำการ</th>
                                                <th class="text-center" width="10%">สถานะ</th>
                                                <th class="text-center" width="15%">จัดการ</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @include('backend.inc_footer')
                    </div>
                </div>
            </div>
        </div>
    </div>


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

    $(document).ready(function(){
        //Datable
        var oTable = $("#datatables").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthChange: true,
            stateSave: true,

			ajax:{
                url : "{{ route('api.market.name.datatable') }}",
				data: function (d) {
                    d.status_val = $('#status_val').val(); // สถานะ
				},
            },

            columns: [
                { 'className': "text-center", data: 'colum_name', name: 'colum_name' },
                { 'className': "text-center", data: 'colum_time', name: 'colum_time' },
                { 'className': "text-center", data: 'colum_status', name: 'colum_status' },
                { 'className': "text-center", data: 'colum_manage', name: 'colum_manage' },
            ],
            order: [[0, 'ASC']],
            rowCallback: function(row,data,index ){
				// rowCallback
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
					url: "{{ route('api.market.name.status')}}",
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
