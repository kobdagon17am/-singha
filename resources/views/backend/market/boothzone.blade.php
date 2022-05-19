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
                                <h4>แบบ Zone</h4>
                                <p class="text-muted m-b-10">รายละเอียดข้อมูลแบบ Booth</p>
                                <ul class="breadcrumb-title b-t-default p-t-10">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('backend.dashboard') }}">
                                        <i class="fa fa-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('backend.market.name') }}">รายชื่อตลาด</a>
                                    </li>
                                    {{-- <li class="breadcrumb-item">
                                        <a href="{{ route('backend.market.name') }}">{{$market->name_market}}</a>
                                    </li> --}}
                                    <li class="breadcrumb-item">
                                        <a href="#!">เลือก Zone </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- block -->
                            <div class="card-block">

                                {{-- <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <div class="form-group">
                                                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_copy" ><i class="fa fa-plus"></i> Copy Model Booth</a>
                                                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_add" ><i class="fa fa-plus"></i> Create Model Booth</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="dt-responsive table-responsive">
                                    <table id="datatables" class="table  table-bordered" width="100%">
                                        <thead>
                                            <tr>

                                                {{-- <th class="text-center">Zone</th> --}}
                                                <th class="text-center">ชื่อแบบ Zone</th>
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

    <input type="hidden" name="marketID" id="marketID" value="{{$mk_marketname->marketname_id}}" />
    <input type="hidden" name="boothID" id="boothID" value="{{$id}}" />
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
                url : "{{ route('api.market.boothzone.datatable') }}",
				data: function (d) {
                    d.marketID = $('#marketID').val(); ; // ID Market
                    d.boothID = $('#boothID').val(); ; // ID boothID
				},
            },

            columns: [
                // { 'className': "text-center", data: 'colum_floor', name: 'zone_id' },
                { 'className': "text-center", data: 'colum_zone', name: 'colum_zone' },
                // { 'className': "text-center", data: 'colum_status', name: 'colum_status' },
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
                        icon: "success",
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
