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
                            <h4>ข้อมูลการตรวจสอบ</h4>
                            <p class="text-muted m-b-10">รายละเอียดข้อมูลการตรวจสอบ</p>
                                <ul class="breadcrumb-title b-t-default p-t-10"></ul>					
                            </div>
                            
                            <!-- block -->
                            <div class="card-block">
                                <div class="card-block" id="reload">                              
                                    <div class="row">
                                        <div class="col-md-12">                                    
                                            <div class="text-center">
                                                <div class="form-group">
                                                    <div class="form-group row"> 
                                                        <label class="col-sm-2 col-form-label text-right">วันเริ่ม:</label>
                                                        <div class="col-sm-3">
                                                            <input type="date" class="form-control" name="date_start" id="date_start" required  >
                                                        </div> 

                                                        <label class="col-sm-1 col-form-label text-right">วันสิ้นสุด:</label>
                                                        <div class="col-sm-3">
                                                            <input type="date" class="form-control" name="date_end" id="date_end" required  >
                                                        </div> 
                                                        <button type="submit" id="bt_submit" class="btn btn-primary"><i class="fa fa-search"></i> ค้นหา</button>
                                                    </div>
                                                </div>							
                                            </div>                                   
                                        </div>										
                                    </div>                      
                                </div>   

                                <div class="dt-responsive table-responsive">								
                                    <table id="datatables" class="table table-striped table-bordered" width="100%">
                                       <thead>
                                           <tr>												
                                               <th class="text-center">ลำดับ</th>
                                               <th class="text-center">เลขที่ใบจอง</th>
                                               <th class="text-center">ตลาด</th>
                                               <th class="text-center">ชื่อผู้จอง</th>
                                               <th class="text-center">สถานะการครวจสอบ</th>
                                               <th class="text-center">จ่ายเงินเพิ่ม</th>
                                               <th class="text-center">ชื่อ Booth</th>
                                               <th class="text-center">สินค้าขาย</th>
                                               <th class="text-center">วันที่ขาย</th>					    																																																							
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
        var route_URL = "{{ route('backend.check.checklist') }}"; // URL 
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
                url : "{{ route('api.checklist.datatable') }}",
                data: function (d) {
                    d.date_start = $('#date_start').val(); 	
                    d.date_end = $('#date_end').val(); // สถานะ	
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
                { 'className': "text-center", data: 'date', name: 'date' },				                          
            ],
            order: [[0, 'asc']],
            rowCallback: function(row,data,index ){			
                // row callback			
            },
        });

        $('#bt_submit').click(function(e){
            oTable.draw();
        });
    });
</script>

@endsection                   