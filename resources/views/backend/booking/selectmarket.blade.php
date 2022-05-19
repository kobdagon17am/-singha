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
                            <h4>เลือกตลาด</h4>
                            <p class="text-muted m-b-10">รายละเอียดข้อมูลการจอง </p>
                            <ul class="breadcrumb-title b-t-default p-t-10">

                            </ul>

                        </div>

                        <!-- block -->
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-right">


                                    </div>
                                </div>
                            </div>

                            <div class="dt-responsive table-responsive">
                                <table id="datatables" class="table  table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ตลาด</th>
                                            <th class="text-center">จัดการ</th>
                                        </tr>
                                    </thead>

                                    {{-- mouk up --}}
                                    {{-- <tbody>
                                            @for($i=0; $i<3; $i++)
                                            <tr>
                                                <td>data1</td>
                                                <td>data2</td>
                                                <td>data3</td>
                                                <td width="20%">data4</td>
                                                <td width="20%" class="text-center">
                                                    data5
                                                </td>
                                            </tr>
                                            @endfor
                                        </tbody> --}}
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


{{-- Modal Bookng --}}
<div class="modal fade" id="modal_confirmbook" role="dialog"  data-show="true">
    <form method="POST" id="form_confirmbooking">
        {!! csrf_field() !!}
        <div class="modal-dialog " id="reload_add">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">ยืนยันการจอง</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <div class="card" >
                        <div class="card-block">

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">อัพโหลดรูปภาพหลักฐานยืนยัน:</label>
                                <div class="col-sm-5">
                                    <img src="{{asset('public/assets/backend/img/wait_img.png')}}" id="PreviewImage_e"
                                        class="img-fluid img-responsive" >
                                    {{-- <p class="c-red">รูปภาพรายละเอียดบูธ ขนาดรูปภาพ xxx * xxx px</p> --}}
                                    <input type="file" class="form-control" name="confirmbook" id="fileimg_gallery_e"
                                        onchange="readURL_Edit(this);" autocomplete="off" required="">
                                </div>
                            </div>

                    </div>
                    <input type="hidden" id="booking_id" name="booking_id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                            <button class="btn btn-primary" type="button" onclick="submitconfirmbook()">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
{{-- Modal Bookng --}}
<div class="modal fade" id="modal_upload" role="dialog"  data-show="true">
                                {{-- <form action="{{ route('file-import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                                    <div class="custom-file text-left">
                                        <input type="file" name="file" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                                <button class="btn btn-primary">Import data</button>
                                <a class="btn btn-success" href="{{ route('file-export') }}">Export data</a>
                            </form> --}}
    <form method="POST"  action="{{ route('file-import') }}"  enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="modal-dialog " id="reload_add">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">อัพโหลด flie excel ตาราการจองบูธประจำ</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <div class="card" >
                        <div class="card-block">

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">อัพโหลดflie excel:</label>
                                <div class="col-sm-5">
                                    <img src="{{asset('public/assets/backend/img/wait_img.png')}}" id="PreviewImage_e"
                                        class="img-fluid img-responsive" >
                                    {{-- <p class="c-red">รูปภาพรายละเอียดบูธ ขนาดรูปภาพ xxx * xxx px</p> --}}
                                    <input type="file" class="form-control" name="confirmbook" id="fileimg_gallery_e"
                                        onchange="readURL_Edit(this);" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">เดือน</label>
                                <div class="col-sm-5">
                                    <input type="month" class="form-control" name="month_import" id="month_import" autocomplete="off" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">ตลาด</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="market_id" id="market_id" required>
                                        <option value="">เลือกตลาด</option>
                                       @foreach ($marketnames as $item)
                                       <option value="{{$item->marketname_id}}">{{$item->name_market}}</option>
                                       @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">แผนผังบูธ</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="booth_id" id="booth_id" required>
                                        <option value="">เลือกผัง</option>
                                       @foreach ($booth as $item)
                                       <option value="{{$item->booth_id}}">{{$item->name}}</option>
                                       @endforeach
                                    </select>

                                </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">วันแจ้งเตือน</label>
                                <div class="col-sm-5">
                                    <input type="date" class="form-control" name="month_import" id="month_import" autocomplete="off" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right">วันหมดอายุ</label>
                                <div class="col-sm-5">
                                    <input type="date" class="form-control" name="month_import" id="month_import" autocomplete="off" required="">
                                </div>
                            </div>

                    </div>
                    <input type="hidden" id="booking_id" name="booking_id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                            <button class="btn btn-primary">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')

<script>
    $(document).ready(function () {
        var oTable = $("#datatables").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthChange: true,
            stateSave: true,

            ajax: {
                url: "{{ route('api.booking.market.datatable') }}",
                type: "POST",
                data: function (d) {
                    d.status_val = $('#status_val').val(); // สถานะ
                },

            },

            columns: [
                {
                    'className': "text-center",
                    data: 'name_market',
                    name: 'name_market'
                },

                {
                    'className': "text-center",
                    data: 'manage',
                    name: 'manage'
                },

            ],
            order: [
                [0, 'ASC']
            ],
            rowCallback: function (row, data, index) {
                // rowCallback
            }

        });

        // Sort Status | Datatable
        $('#status_val').change(function (e) {
            oTable.draw();
        });
    });

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

<script>
    function readURL_Edit(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#PreviewImage_e').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    // Find Booth
    function select_booth_detail() {
        let select_market = $('#select_marketname').val();
        let select_booth = $('#select_booth').val();
        let select_floor = $('#select_floor').val();
        let select_zone = $('#select_zone').val();
        let date_booking = $('#date_booking').val();
        // e.preventDefault();

        $.ajax({
            url: "{{ route('api.booking.selectmarket') }}",
            data: {
                select_market: select_market,
                select_booth: select_booth,
                select_floor: select_floor,
                select_zone: select_zone,
                date_booking: date_booking,
            },
            type: "POST",
            async: false,

            success: function (data) {
                console.log(data);
                $('#select_floor').html(data.htmlfloor);
                $('#select_zone').html(data.htmlzone);
                $('#select_booth').html(data.htmlbooth);
                $('#booth_detail').html(data.htmlbooth_detail);

                $('#select_zone').val(data.zone_id);
                // $('#booth_id').val(data.booth_id);
                // $('#floor_id').val(data.floor_id);


            }
        });
    }
    // Booking
    function add() {
        // e.preventDefault();
        var formData =  new FormData($('#form_booking')[0]);
        console.log(formData);
        $.ajax({
            url: "{{ route('booking.store') }}",
            data: formData,
            type: "POST",
            async: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#modal_add').modal('hide') // modal add hide
                if (data.response == true) {
                    swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "ยืนยัน",
                    }).then((value) => {
                        // window.location.reload();
                        $('#datatables').DataTable().ajax.reload();
                    });
                }
            }
        });
    }
     // CancleBooking
     function cancle(keepId) {
		bootbox.prompt({
			title: "<h5>คุณต้องยกเลิกใบจอง <br> <font color='red'>"+ keepId +"</font> นี้หรือไม่ ?<h5>",
            placeholder: 'กรุณาใส่หมายเหตุ',
            inputType: 'text',
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
                console.log(result);
				if(result != "" && result != null){
					$.ajax({
                    url: "{{url('/backoffice/booking')}}/" + keepId, //ส่งข้อมูลไปทีไฟล์ delete.php
                    data: {
                        _method: "DELETE",
                        id: keepId
                    }, //ส่งข้อมูลไปในรูปแบบ JSON
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
                                    $('#datatables').DataTable().ajax.reload();
                                });
                            }
                        }
					});
				}
			}
		});
    }
 // CancleBooking
 function confirmbook(keepId) {
    $('#booking_id').val(keepId);
    console.log(keepId);
    $('#modal_confirmbook').modal('show') // modal add hide
		// bootbox.confirm({
		// 	title: "ยืนยัน ?",
		// 	message: "คุณต้องยกเลิกใบจอง <font color='red'>"+keepId+"</font> นี้หรือไม่ ?",
		// 	buttons:{
		// 		cancel: {
		// 			label: '<i class="fa fa-times"></i> ยกเลิก',
		// 			className: 'btn-danger'
		// 		},
		// 		confirm:{
		// 			label: '<i class="fa fa-check"></i> ยืนยัน',
		// 			className: 'btn-success'
		// 		}
		// 	},
		// 	callback: function (result){
		// 		if(result == true){
		// 			$.ajax({
        //             url: "{{url('/backoffice/booking')}}/" + keepId, //ส่งข้อมูลไปทีไฟล์ delete.php
        //             data: {
        //                 _method: "DELETE",
        //                 id: keepId
        //             }, //ส่งข้อมูลไปในรูปแบบ JSON
		// 			type: "POST",
		// 			async:false,
        //             success:function(data){
        //                     if(data.response==true){
        //                         swal({
        //                         title: data.title,
        //                         text: data.text,
        //                         icon: "success",
        //                         button: "OK",
        //                         }).then((value) => {
        //                             $('#datatables').DataTable().ajax.reload();
        //                         });
        //                     }
        //                 }
		// 			});
		// 		}
		// 	}
		// });
    }
    function submitconfirmbook() {
        var formData =  new FormData($('#form_confirmbooking')[0]);
        console.log(formData);
        $.ajax({
            url: "{{ route('api.booking.submitconfirmbook') }}",
            data: formData,
            type: "POST",
            async: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#modal_add').modal('hide') // modal add hide
                if (data.response == true) {
                    swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "ยืนยัน",
                    }).then((value) => {
                        // window.location.reload();

                        $('#datatables').DataTable().ajax.reload();
                        $('#modal_confirmbook').modal('hide')
                    });
                }
            }
        });
    }
  // Booking
  function show(keepId) {
        // e.preventDefault();
        console.log(keepId);
        $.ajax({
            url: "{{ route('api.booking.databooking')}}",
            data: {
                keepId : keepId
                },
            type: "POST",
            async: false,

            success: function (data) {
                $('#modal_booking').modal('show')
                $('#trdetail').html(data.trdetail)
            }
        });
    }

    var path = "{{ route('api.booking.searchuser') }}";
    $('input.typeahead').typeahead({
        source: function (query, process) {
            return $.post(path, {
                query: query
            }, function (data) {
                console.log(data);
                // $('#partners_id').val(data.partners_id)
                return process(data);
            });
        }
    });

    function selectbooth(keepId) {
        // e.preventDefault();
        console.log(keepId);
        $('#booth_detail_id').val(keepId)
    }
    function sentnotification(keepId) {
        // e.preventDefault();
        console.log(keepId);
        $.ajax({
            url: "{{ route('api.booking.sentnotification')}}",
            data: {
                keepId : keepId
                },
            type: "POST",
            async: false,

            success: function (data) {
                console.log(data);
                // $('#modal_booking').modal('show')
                // $('#trdetail').html(data.trdetail)
            }
        });
    }
    function sentnotification_overdue() {
        // e.preventDefault();
        // console.log(keepId);
        $.ajax({
            url: "{{ route('api.booking.sentnotification_overdue')}}",
            // data: {
                // keepId : keepId
                // },
            type: "POST",
            async: false,

            success: function (data) {
                console.log(data);
                // $('#modal_booking').modal('show')
                // $('#trdetail').html(data.trdetail)
            }
        });
    }
    function adddate() {
        var html = ' <div class="form-group row">'+
                                '<label class="col-sm-4 col-form-label">เลือกวันที่</label>'+
                              '  <div class="col-sm-6">'+
                                    '<input type="hidden" name="date_booking" id="date_booking"class="form-control form-control-normal" required="" value="">'+
                                    '<input type="date" class="form-control form-control-normal" name="bd_booking_date[]" id="ch_Name" autocomplete="off" required="" onchange="getDate()">'+
                               ' </div>'+
                           ' </div>'
    console.log(html);

    $('#date_html').append(html);
    }
</script>



@endsection
