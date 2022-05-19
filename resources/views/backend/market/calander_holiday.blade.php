@extends('backend/inc_main') {{-- main.blade.php --}}

 @section('title','| All Tags')

@section('stylesheet')

    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/bootstrap4/bower_components/fullcalendar/css/fullcalendar.css')}}"> 
    <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/bootstrap4/bower_components/fullcalendar/css/fullcalendar.print.css')}}" media="print"> 

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
                            <h4>ปฏิทินวันหยุด</h4>
                            <span class="demo_test">123</span>
                            <p class="text-muted m-b-10">รายละเอียดข้อมูลปฏิทินวันหยุด</p>
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
                                        <a href="">ปฏิทินวันหยุด</a>
                                    </li> 
                                </ul>					
                            </div>
                            
                            <!-- block -->
                            <div class="card-block">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <div class="form-group">
                                                <a href="{{ route('backend.market.calendar.manage', array('id'=>$market->marketname_id)) }}" class="btn btn-dark" ><i class="fa fa-calendar"></i> จัดการวันหยุด</a>		
                                                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_add" ><i class="fa fa-plus"></i> เพิ่มวันหยุดตลาด</a>		
                                            </div>							
                                        </div>
                                    </div>										
                                </div>

                                <div class="card-header">
                                    <h5>ปฏิทินวันหยุด </h5>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 col-md-12">
                                        <div id='calendar'></div>
                                    </div>
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

    <input type="hidden" id="_date" value="{{date('Y-m-d')}}" />
    <input type="hidden" id="_dateJson" value="{{$myJSON}}" />

@endsection 

@section('script')


<script src="{{URL::asset('public/assets/bootstrap4/bower_components/moment/js/moment.min.js')}} "></script>
<script src="{{URL::asset('public/assets/bootstrap4/bower_components/fullcalendar/js/fullcalendar.min.js')}} "></script>
{{-- <script src="{{URL::asset('public/assets/bootstrap4/assets/pages/full-calender/calendar.js')}} "></script> --}}

<script>
    $(document).ready(function(){
        var route_URL = "{{ route('backend.market.name') }}"; // URL 
        $(".pcoded-submenu>li a[href='"+route_URL+"']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='"+route_URL+"']").parent().parent().parent().addClass("pcoded-trigger");
    });
</script>

<script>

    var date = $('#_date').val() // value : วันล่าสุด
    var dataJson = $('#_dateJson').val(); // value : วันหยุด
        dataJson = JSON.parse(dataJson);

    $(document).ready(function() {
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listMonth'
            },
            defaultDate: date,
            navLinks: true, // can click day/week names to navigate views
            businessHours: true, // display business hours
            editable: true,
            events: dataJson 
        });

        $(".fc-time").html(""); // display time


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
                    if(data.response == true){
                        swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "ยืนยัน",
                        }).then((value) => {               
                            window.location.reload();
                        });
                    } 					
                }
            });
        });
        
    });

</script>



@endsection                   