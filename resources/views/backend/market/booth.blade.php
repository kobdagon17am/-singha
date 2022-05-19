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
                                <h4>แบบ Booth</h4>
                                <p class="text-muted m-b-10">รายละเอียดข้อมูลแบบ Booth</p>
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
                                        <a href="#!">แบบ Booth</a>
                                    </li>
                                </ul>
                            </div>

                            <!-- block -->
                            <div class="card-block">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <div class="form-group">
                                                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_copy" ><i class="fa fa-plus"></i> Copy Model Booth</a>
                                                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_add" ><i class="fa fa-plus"></i> Create Model Booth</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="dt-responsive table-responsive">
                                    <table id="datatables" class="table  table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                {{-- <th class="text-center">Floor</th> --}}
                                                {{-- <th class="text-center">Zone</th> --}}
                                                <th class="text-center">ชื่อแบบ Booth</th>
                                                <th class="text-center">วันเริ่ม</th>
                                                <th class="text-center">วันสิ้นสุด</th>
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
                        <h4 class="modal-title ">Create Model Booth</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body" id="body_modal_add">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อตลาด:</label>
                                <div class="col-sm-5">
                                 <input type="text" class="form-control" name="" id="" placeholder="ชื่อตลาด"  value="{{$market->name_market}}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อแบบ Booth:</label>
                                <div class="col-sm-5">
                                 <input type="text" class="form-control" name="name_booth" id="name_booth_a" placeholder="ชื่อแบบ Booth" autocomplete="off" required>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ประเภท Booth:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="type_booth" id="type_booth_a" required>
                                    @foreach($booth_type as $booth_types)
                                        <option value="{{$booth_types->booth_type_id}}">{{$booth_types->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            {{-- <label class="col-sm-4 col-form-label text-right">Floor:</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="floor_booth" id="floor_booth_a" required>
                                    @foreach($floor as $floors)
                                        <option value="{{$floors->floor_id}}">{{$floors->name}}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <label class="col-sm-4 col-form-label text-right">Zone:</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="zone_booth" id="zone_booth_a" required>
                                    @foreach($zone as $zones)
                                        <option value="{{$zones->zone_id}}">{{$zones->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">จำนวน Booth:</label>
                                <div class="col-sm-2">
                                 <input type="number" class="form-control" name="amount_booth" id="amount_booth_a" placeholder="จำนวน Booth" autocomplete="off" required>
                            </div>

                            <label class="col-sm-1 col-form-label text-right">ราคาเริ่มต้น:</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" name="price_start" id="price_start_a" placeholder="ราคาเริ่มต้น" autocomplete="off" required>
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">จำนวน Booth:</label>
                                <div class="col-sm-2">
                                 <input type="number" class="form-control" name="amount_booth" id="amount_booth_a" placeholder="จำนวน Booth" autocomplete="off" required>
                            </div>

                            <label class="col-sm-1 col-form-label text-right">ราคาเริ่มต้น:</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" name="price_start" id="price_start_a" placeholder="ราคาเริ่มต้น" autocomplete="off" required>
                            </div>
                        </div> --}}


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">วันเริ่มต้น:</label>
                                <div class="col-sm-2">
                                 <input type="date" class="form-control" name="date_start" id="date_start_a"  required>
                            </div>

                            <label class="col-sm-1 col-form-label text-right">วันสิ้นสุด:</label>
                                <div class="col-sm-2">
                                 <input type="date" class="form-control" name="date_end" id="date_end_a"  required>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="market_id" value="{{$market->marketname_id}}" >

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
                        <h4 class="modal-title ">Edit Model Booth</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                     </div>

                     <div class="modal-body" id="body_modal_edit">

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อตลาด:</label>
                                <div class="col-sm-5">
                                 <input type="text" class="form-control" id="marketname_e" placeholder="ชื่อตลาด"  value="{{$market->name_market}}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อแบบ Booth:</label>
                                <div class="col-sm-5">
                                 <input type="text" class="form-control" name="name_booth" id="name_booth_e" placeholder="ชื่อแบบ Booth" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">วันเริ่มต้น:</label>
                                <div class="col-sm-2">
                                 <input type="date" class="form-control" name="date_start" id="date_start_e"  required>
                            </div>

                            <label class="col-sm-1 col-form-label text-right">วันสิ้นสุด:</label>
                                <div class="col-sm-2">
                                 <input type="date" class="form-control" name="date_end" id="date_end_e"  required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">สถานะ:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="status" id="status_e" required>
                                    <option value="W">รออนุมัติ</option>
                                    <option value="Y">ใช้งาน</option>
                                    <option value="N">ยกเลิก</option>
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

    {{-- Modal Copy --}}
    <div class="modal fade" id="modal_copy" role="dialog">
        <form method="POST"  id="form_copy">
        {!! csrf_field() !!}
            <div class="modal-dialog modal-lg" id="reload_copy">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">Copy Model Booth</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                     </div>

                     <div class="modal-body" id="body_modal_copy">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">แบบที่ต้องการ Copy:</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="booth_id" id="booth_id_c" required>
                                    <option value="">เลือก</option>
                                    @foreach($booth as $booths)
                                        <option value="{{$booths->booth_id}}">{{$booths->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">ชื่อแบบ Booth:</label>
                                <div class="col-sm-5">
                                 <input type="text" class="form-control" name="name" id="name_c" placeholder="ชื่อแบบ Booth" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right">วันเริ่มต้น:</label>
                                <div class="col-sm-2">
                                 <input type="date" class="form-control" name="date_start" id="date_start_c"  required>
                            </div>

                            <label class="col-sm-1 col-form-label text-right">วันสิ้นสุด:</label>
                                <div class="col-sm-2">
                                 <input type="date" class="form-control" name="date_end" id="date_end_c"  required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        <button class="btn btn-primary" id="submit_copy">บันทึก</button>
                    </div>
                 </div>
            </div>
        </form>
    </div>

<input type="hidden" name="marketID" id="marketID" value="{{$market->marketname_id}}" />

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
        name = $('#name_booth_a').val();
        type = $('#type_booth_a').val();
        floor = $('#floor_booth_a').val();
        zone = $('#zone_booth_a').val();
        amont = $('#amount_booth_a').val();
        price = $('#price_start_a').val();
        d_start = $('#date_start_a').val();
        d_end = $('#date_end_a').val();
        if(name != "" &&  type != "" && floor != "" && zone != "" && amont != "" && price != "" && d_start != "" && d_end != "") {
            e.preventDefault();
            waitme_reload('#reload_add'); // waitme
            setTimeout(function(){
                $('#form_add').submit();
            }, 3000);
        }
    });

    $('#submit_edit').click(function(e){
        name = $('#name_booth_e').val();
        d_start = $('#date_start_e').val();
        d_end = $('#date_end_e').val();
        if(name != "" && d_start != "" && d_end != "") {
            e.preventDefault();
            waitme_reload('#reload_edit'); // waitme
            setTimeout(function(){
                $('#form_edit').submit();
            }, 3000);
        }
    });

    $('#submit_copy').click(function(e){
        booth = $('#booth_id_c').val();
        name = $('#name_c').val();
        d_start = $('#date_start_c').val();
        d_end = $('#date_end_c').val();
        if(booth != "" && name != "" && d_start != "" && d_end != "") {
            e.preventDefault();
            waitme_reload('#reload_copy');
            setTimeout(function(){
                $('#form_copy').submit();
            }, 3000);
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
                url : "{{ route('api.market.booth.datatable') }}",
				data: function (d) {
                    d.marketID = $('#marketID').val(); // ID Market
				},
            },

            columns: [
                // { 'className': "text-center", data: 'colum_floor', name: 'booth_id' },
                // { 'className': "text-center", data: 'colum_zone', name: 'colum_zone' },
                { 'className': "text-center", data: 'colum_name', name: 'colum_name' },
                { 'className': "text-center", data: 'colum_date_start', name: 'colum_date_start' },
                { 'className': "text-center", data: 'colum_date_end', name: 'colum_date_end' },
                { 'className': "text-center", data: 'colum_status', name: 'colum_status' },
                { 'className': "text-center", data: 'colum_manage', name: 'colum_manage' },
            ],
            ordering: false
            // order: [[2, 'desc']],
            // rowCallback: function(row,data,index ){
			// 	// rowCallback
			// }
        });

        // Form Add
        $('#form_add').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
               url: "{{ route('api.market.booth.add') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){
                    $('#reload_add').waitMe('hide') // wiatme stop
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
               url: "{{ route('api.market.booth.update') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){
                    $('#reload_edit').waitMe('hide') // wiatme stop
                    $('#modal_edit').modal('hide') // modal add hide
                    $('#body_modal_edit').load(document.URL + ' #body_modal_edit'); // body modal add refresh
                    if(data.response == true){
                        swal({
                        title: data.title,
                        text: data.text,
                        icon: data.icon,
                        button: "ยืนยัน",
                        }).then((value) => {
                            oTable.draw(); // refresh dadatable
                        });
                    }
                }
            });
        });

        // Form Copy
        $('#form_copy').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
               url: "{{ route('api.market.booth.copy') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){
                    $('#reload_copy').waitMe('hide') // wiatme stop
                    $('#modal_copy').modal('hide') // modal add hide
                    $('#body_modal_copy').load(document.URL + ' #body_modal_copy'); // body modal add refresh
                    if(data.response == true){
                        swal({
                        title: data.title,
                        text: data.text,
                        icon: data.icon,
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
            url: "{{ route('api.market.booth.edit') }}",
            data: {"_token": "{{ csrf_token() }}", 'id': id},
            type: "POST",
            async: false,
            success: function(data){

                $('#id').val(data.booth_id);
                $('#marketname_e').val(data.market.name_market);
                $('#name_booth_e').val(data.name);
                $('#date_start_e').val(data.date_start);
                $('#date_end_e').val(data.date_end);
                $('#status_e').val(data.status).trigger('change');
                if (data.intime == "yes") {
                    // alert("ไม่สามารถแก้ไขได้");
                    document.getElementById("name_booth_e").setAttribute("readonly", true);
                    document.getElementById("marketname_e").setAttribute("readonly", true);
                    // document.getElementById("status_e").setAttribute("readonly", true);
                    $('#status_e').prop('disabled',true);
                }else{
                    document.getElementById("name_booth_e").removeAttribute("readonly");
                    document.getElementById("marketname_e").removeAttribute("readonly");
                    // document.getElementById("status_e").removeAttribute("readonly");
                    $('#status_e').prop('disabled',false);

                }
                console.log(data);
            }
        });
    });

	function waitme_reload(value){
		$(value).waitMe({
			effect: 'rotation',
			text: 'Please wait..',
			bg: 'rgba(255,255,255,0.7)',
			color: '#000',
			maxSize: '',
			waitTime: -1,
			source: '',
			textPos: 'vertical',
			fontSize: '',
			onClose: function() {}
		});
	}

</script>



@endsection
