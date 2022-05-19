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
                            <h4>จอง Booth แทนสมาชิก</h4>
                            <p class="text-muted m-b-10">รายละเอียดข้อูลจอง Booth แทนสมาชิก</p>
                            <ul class="breadcrumb-title b-t-default p-t-10">

                            </ul>
                        </div>

                        <!-- block -->
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-right">
                                        <div class="form-group">
                                            <a href="#" class="btn btn-inverse" data-toggle="modal"
                                                data-target="#modal_add"><i class="fa fa-plus"></i> เพิ่มข้อมูลจอง
                                                Booth</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dt-responsive table-responsive">
                                <table id="datatables" class="table  table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">เลขที่ใบจอง</th>
                                            <th class="text-center">ตลาด</th>
                                            <th class="text-center">สถานะ</th>
                                            <th class="text-center">ชื่อผู้จอง</th>
                                            <th class="text-center">วันที่จอง</th>
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

<!-- Modal Add -->
<div class="modal fade" id="modal_add" role="dialog">
    <form method="POST" id="form_booking">
        {{-- {!! csrf_field() !!} --}}
        <div class="modal-dialog modal-lg" id="reload_add">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">รายละอียดการจอง</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <div class="card">
                        <div class="card-block">

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">ตลาด</label>
                                <div class="col-sm-8">
                                    <select class="form-control form-control-normal" name="marketname_id" id="select_marketname"
                                        onchange="select_booth_detail()">
                                        <option value="">กรุณาเลือกตลาด</option>
                                        @foreach ($marketnames as $marketname)
                                        <option value="{{$marketname->marketname_id}}">{{$marketname->name_market}}
                                        </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">โมเดลแผนผัง</label>
                                <div class="col-sm-8">
                                    <select class="form-control form-control-normal" name="" id="select_booth"
                                        onchange="select_booth_detail()">
                                        <option value="">โมเดลแผนผัง</option>
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label class="col-sm-4 col-form-label">ชั้น</label>
                                <div class="col-sm-8">
                                    <select class="form-control form-control-normal" name="" id="select_floor"
                                        onchange="select_booth_detail()">
                                        <option value="">กรุณาเลือกชั้น</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">โซน</label>
                                <div class="col-sm-8">
                                    <select class="form-control form-control-normal" name="" id="select_zone"
                                        onchange="select_booth_detail()">
                                        <option value="">กรุณาเลือกโซน</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">เลือกวันที่</label>
                                <div class="col-sm-6">
                                    <input type="hidden" name="date_booking" id="date_booking"
                                        class="form-control form-control-normal" required="" value="">

                                    <input type="date" class="form-control form-control-normal" name="bd_booking_date"
                                        id="ch_Name" autocomplete="off" required="" onchange="getDate()">
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">ชื่อลูกค้า</label>
                                <div class="col-sm-4" id=countryList>
                                    <input class="typeahead form-control" type="text"  name="partners_name">
                                </div>
                                {{-- <div class="col-sm-4" id=countryList> --}}
                                    {{-- <input id="partners_id" class="form-control" type="text"> --}}
                                {{-- </div> --}}
                            </div>



                        </div>
                    </div>
                    <div id="lok">
                        <div class="card">
                            <?php $bt_status = ""; ?>

                            <div class="card-block remove-label" id="booth_detail">

                            </div>
                        </div>
                        <input type="hidden" id="booth_detail_id" name="booth_detail_id">
                            <div class="card">
                                <div class="card-block" id="option">
                                    <div class="form-group row">
                                        <h6><label class="col-12 col-form-label">บริการเสริม</label></h6>
                                    </div>
                                    @foreach ($services as $item)
                                    <div class="form-group row"><label class="col-9 col-form-label">{{$item->name}} </label>
                                        <div class="col-3"><input type="hidden" name="at_id[]" value="9"><select
                                                name="qty[]" class="form-control form-control-primary">
                                                <option value="0">ไม่รับ</option>
                                                @for ($i = 0; $i < $item->amount; $i++)
                                                <option value="{{$i+1}}">{{$i+1}}</option>
                                                @endfor
                                            </select></div>
                                    </div>
                                    @endforeach



                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                            <button type="button" class="btn btn-primary" id="submit_add" onclick="add()">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>

{{-- Modal Bookng --}}
<div class="modal fade" id="modal_booking" role="dialog"  data-show="true">
    <form method="POST" id="form_booking">
        {!! csrf_field() !!}
        <div class="modal-dialog modal-lg" id="reload_add">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ">รายละอียดการจอง</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <div class="card" >
                        <div class="card-block">

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">ตลาด</label>
                                <div class="col-sm-8">
                                    <select class="form-control form-control-normal" name="" id="select_marketname"
                                        onchange="select_booth_detail()">
                                        <option value="">กรุณาเลือกตลาด</option>
                                        @foreach ($marketnames as $marketname)
                                        <option value="{{$marketname->marketname_id}}">{{$marketname->name_market}}
                                        </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">โมเดลแผนผัง</label>
                                <div class="col-sm-8">
                                    <select class="form-control form-control-normal" name="" id="select_booth">
                                        <option value="">โมเดลแผนผัง</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">โซน</label>
                                <div class="col-sm-8">
                                    <select class="form-control form-control-normal" name="" id="select_zone">
                                        <option value="">กรุณาเลือกโซน</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">เลือกวันที่</label>
                                <div class="col-sm-6">
                                    <input type="hidden" name="date_booking" id="date_booking"
                                        class="form-control form-control-normal" required="" value="">

                                    <input type="date" class="form-control form-control-normal" name="bd_booking_date"
                                        id="ch_Name" autocomplete="off" required="" >
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">ชื่อลูกค้า</label>
                                <div class="col-sm-8" id=countryList>
                                    <input class="typeahead form-control" type="text">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="dt-responsive table-responsive">
                        <table id="datatables" class="table  table-bordered" width="100%">
                            <thead>
                                <tr>


                                    <th class="text-center">ชื่อบูธ</th>
                                    {{-- <th class="text-center">วันที่จอง</th> --}}
                                    {{-- <th class="text-center">จัดการ</th> --}}
                                </tr>
                            </thead>

                            {{-- mouk up --}}
                            <tbody id="trdetail" align="center">

                                    <tr>
                                        <td></td>

                                    </tr>

                                </tbody>
                        </table>

                    </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                            <button class="btn btn-primary" id="submit_add" onclick="add()">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>
{{-- Modal Bookng --}}
<div class="modal fade" id="modal_confirmbook" role="dialog"  data-show="true">
    <form method="POST" id="form_booking">
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
                                    <input type="file" class="form-control" name="booth_detail_image" id="fileimg_gallery_e"
                                        onchange="readURL_Edit(this);" autocomplete="off" required="">
                                </div>
                            </div>

                    </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                            <button class="btn btn-primary" id="submit_add" onclick="add()">บันทึก</button>
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
                url: "{{ route('api.booking.datatable') }}",
                type: "POST",
                data: function (d) {
                    d.status_val = $('#status_val').val(); // สถานะ
                },

            },

            columns: [{
                    'className': "text-center",
                    data: 'booking_id',
                    name: 'booking_id'
                },
                {
                    'className': "text-center",
                    data: 'market',
                    name: 'market'
                },
                {
                    'className': "text-center",
                    data: 'booking_status',
                    name: 'booking_status'
                },
                {
                    'className': "text-center",
                    data: 'partners',
                    name: 'partners'
                },
                {
                    'className': "text-center",
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    'className': "text-center",
                    data: 'manage',
                    name: 'manage'
                },

            ],
            order: [
                [0, 'desc']
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
		bootbox.confirm({
			title: "ยืนยัน ?",
			message: "คุณต้องยกเลิกใบจอง <font color='red'>"+keepId+"</font> นี้หรือไม่ ?",
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
</script>



@endsection
