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
                                <h4>ข่าวสาร</h4>
                                <p class="text-muted m-b-10">รายละเอียดข้อมูลข่าวสาร</p>
                                <ul class="breadcrumb-title b-t-default p-t-10">

                                </ul>					
                            </div>
                            

                            <!-- block -->
                            <div class="card-block">
                                {{-- add --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <div class="form-group">
                                                <a href="{{ route('backend.publicize.news.create') }}" class="btn btn-dark" ><i class="fa fa-plus"></i> เพิ่มข้อมูลข่าวสาร</a>		
                                            </div>							
                                        </div>
                                    </div>										
                                </div>

                                {{-- status --}}
                                <div class="d-flex justify-content-end">
                                    <p style="margin-top: 6px;">Show</p>
                                    <div class="col-sm-2">
                                        <select class="form-control" style="width:108%;" name="status_val" id="status_val">
                                            <option value="Y">ใช้งาน</option>
                                            <option value="N">ยกเลิก</option>
                                            <option value="T" selected>ทั้งหมด</option>
                                        </select>
                                    </div>                                
                                </div><br>

                                {{-- datatable --}}
                                <div class="dt-responsive table-responsive">								
                                    <table id="datatables" class="table  table-bordered" width="100%">
                                        <thead>
                                            <tr>												
                                                <th class="text-center" width="15%">รูปภาพปก</th>
                                                <th class="text-center">หัวข้อ</th>
                                                <th class="text-center" width="10%">วันเริ่มต้น</th>
                                                <th class="text-center" width="10%">วันสิ้นสุด</th>
                                                <th class="text-center" width="10%">สถานะ</th>		                                           					    																																																							
                                                <th class="text-center" width="10%">จัดการ</th>			                                           					    																																																							
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
        var route_URL = "{{ route('backend.publicize.news') }}"; // URL 
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
                url : "{{ route('api.publicize.news.datatable') }}",
				data: function (d) {				
                    d.status_val = $('#status_val').val(); // สถานะ	
				},				
            },
            
            columns: [
                { 'className': "text-center", data: 'colum_image', name: 'news_id' },	
                { 'className': "td_colum", data: 'colum_title', name: 'colum_title' },	
                { 'className': "text-center", data: 'colum_date_start', name: 'colum_date_start' },	
                { 'className': "text-center", data: 'colum_date_end', name: 'colum_date_end' },	
                { 'className': "text-center", data: 'colum_status', name: 'colum_status' },	
                { 'className': "text-center", data: 'colum_manage', name: 'colum_manage' },	
				
    	
            ],
            order: [[0, 'desc']],
            rowCallback: function(row,data,index ){
				// rowCallback
			}

        });

        // Sort Status | Datatable
            $('#status_val').change(function(e){
            oTable.draw();
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
					url: "{{ route('api.publicize.news.status')}}",
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

    // Delate
    function deletedata(id,name){
		bootbox.confirm({
			title: "ยืนยัน ?",
			message: "คุณต้องการลบข้อมูล <font color='red'>"+name+"</font> นี้หรือไม่ ?",
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
					url: "{{ route('api.publicize.news.delete')}}",
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