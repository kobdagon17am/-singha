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
                            <h4>รายชื่อผู้จ่ายค่าปรับแบบโอน</h4>
                            <p class="text-muted m-b-10">รายละเอียดข้อมูลรายชื่อผู้จ่ายค่าปรับแบบโอน</p>
                                <ul class="breadcrumb-title b-t-default p-t-10"></ul>					
                            </div>
                            
                            <!-- block -->
                            <div class="card-block">
                                <div class="dt-responsive table-responsive">								
                                    <table id="datatables" class="table  table-bordered" width="100%">
                                        <thead>
                                            <tr>												
                                                <th class="text-center">ลำดับ</th>
                                                <th class="text-center">เลขที่ใบจอง</th>
                                                <th class="text-center">ตลาด</th>
                                                <th class="text-center">ชื่อผู้จอง</th>
                                                <th class="text-center">สถานะการตรวจสอบ</th>			                                           					    																																																							
                                                <th class="text-center">จำนวนเงินเพิ่ม</th>			                                           					    																																																							
                                                <th class="text-center">ชื่อ Booth</th>	
                                                <th class="text-center">สินค้าขาย</th>                    					    																																																							
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


@endsection 

@section('script')

<script>
    $(document).ready(function(){
        var route_URL = "{{ route('backend.check.listtransfer') }}"; // URL 
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

            // Button Manage
            dom: 'Bfrtip',
            buttons: [
                {
                    className: 'btn-inverse',
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Print',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    className: 'btn-inverse',
                    extend: 'excelHtml5',
                    title: 'data_Excel',
                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, {
                    className: 'btn-inverse',
                    extend: 'pdfHtml5',
                    title: 'data_PDF',
                    text: '<i class="fa fa-file-pdf-o"></i> PDF',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
            ],

            ajax:{ 
                url : "{{ route('api.listtransfer.datatable') }}",
                data: function (d) {
                   
                },				
            },
            columns: [
                { 'className': "text-center", data: 'no', name: 'no' },				               
                { 'className': "text-center", data: 'number', name: 'number' },				               
                { 'className': "text-center", data: 'market', name: 'market' },				               
                { 'className': "text-center", data: 'nameapp', name: 'nameapp' },				               
                { 'className': "text-center", data: 'status', name: 'status' },				               
                { 'className': "text-center", data: 'amoumt', name: 'amoumt' },				               
                { 'className': "text-center", data: 'booth', name: 'booth' },				               
                { 'className': "text-center", data: 'product', name: 'product' },				               		                          
            ],
            order: [[0, 'asc']],
            rowCallback: function(row,data,index ){			
                // row callback			
            },
        });
    });
</script>

@endsection                   