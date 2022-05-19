@extends('backend/inc_main') {{-- main.blade.php --}}

 @section('title','| All Tags')

@section('stylesheet')
     
@endsection 

@section('content')

<style>
    .td_colum {
        column-width:300px !important; 
        white-space: normal !important; 
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
                                <h4>Notification</h4>
                                <p class="text-muted m-b-10">รายละเอียดข้อมูล Notification</p>
                                <ul class="breadcrumb-title b-t-default p-t-10">

                                </ul>					
                            </div>
                            
                            <!-- block -->
                            <div class="card-block">
                                {{-- Add --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <div class="form-group">
                                                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_add" ><i class="fa fa-plus"></i> เพิ่มข้อมูล Notification</a>		
                                            </div>							
                                        </div>
                                    </div>										
                                </div>

                                {{-- Status --}}
                                <div class="d-flex justify-content-end">
                                    <p style="margin-top: 6px;">Show</p>
                                    <div class="col-sm-2">
                                        <select class="form-control" style="width:108%;" name="status_val" id="status_val">
                                            <option value="Y">ยังไม่ส่งข้อความ</option>
                                            <option value="N">ส่งข้อความแล้ว</option>
                                            <option value="T" selected>ทั้งหมด</option>
                                        </select>
                                    </div>                                
                                </div><br>

                                {{-- Datatable --}}
                                <div class="dt-responsive table-responsive">								
                                    <table id="datatables" class="table  table-bordered" width="100%">
                                        <thead>
                                            <tr>												
                                                <th class="text-center" width="30%">หัวข้อ</th>
                                                <th class="text-center" width="40%">ข้อความ</th>
                                                <th class="text-center" width="5%">ผู้ทำรายการ</th>
                                                <th class="text-center" width="5%">วัน/เวลา</th>
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

    <!-- Modal Add -->
    <div class="modal fade" id="modal_add" role="dialog" >
        <form  method="POST" id="form_add">
        {!! csrf_field() !!}
            <div class="modal-dialog modal-lg" id="reload_add">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">เพิ่มข้อมูล Notification</h4> 
                        <button type="button" class="close" data-dismiss="modal">×</button>					          
                    </div>
                    
                    <div class="modal-body" id="body_modal_add">         
                    
                    <input type="hidden" name="userid" value="{{Auth::user()->id}}" >
                        
                        <div class="form-group row"> 
                            <label class="col-sm-4 col-form-label text-right">หัวข้อ:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="title" id="title_a" placeholder="หัวข้อ"  autocomplete="off" required>
                            </div> 
                        </div>

                        <div class="form-group row"> 
                            <label class="col-sm-4 col-form-label text-right">ข้อความ:</label>
                            <div class="col-sm-5">
                               <textarea name="message" id="message_a" class="form-control" rows="4" cols="50" required></textarea>
                            </div> 
                        </div>

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
                        <h4 class="modal-title ">แก้ไขข้อมูล Notification</h4> 
                        <button type="button" class="close" data-dismiss="modal">×</button>
                     </div>

                     <div class="modal-body" id="body_modal_edit">    
                        <input type="hidden" name="id" id="id" >
                        <div class="form-group row"> 
                            <label class="col-sm-4 col-form-label text-right">หัวข้อ:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="title" id="title_e" placeholder="หัวข้อ"  autocomplete="off" required>
                            </div> 
                        </div>
                        <div class="form-group row"> 
                            <label class="col-sm-4 col-form-label text-right">ข้อความ:</label>
                            <div class="col-sm-5">
                               <textarea name="message" id="message_e" class="form-control" rows="4" cols="50" required></textarea>
                            </div> 
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        <button class="btn btn-primary" id="submit_edit">บันทึก</button>
                    </div>
                 </div>
            </div>
        </form>
    </div>

@endsection 

@section('script')

<script>
    $(document).ready(function(){
        var route_URL = "{{ route('backend.publicize.notification') }}"; // URL 
        $(".pcoded-submenu>li a[href='"+route_URL+"']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='"+route_URL+"']").parent().parent().parent().addClass("pcoded-trigger");
    });
</script>


<script>

    // Submit Add
    $('#submit_add').click(function(e){
        title  = $('#title_a').val();
        message  = $('#message_a').val();
        if(title != "" && message != ""){
            e.preventDefault();
            $('#form_add').submit();
        }
    });

    // Submit Update
        $('#submit_edit').click(function(e){
        title  = $('#title_e').val();
        message  = $('#message_e').val();
        if(title != "" && message != ""){
            e.preventDefault();
            $('#form_edit').submit();
        }
    });

    $(document).ready(function(){
        //Datable
        var oTable = $("#datatables").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthChange: true,
            stateSave: true,
            
			ajax:{ 
                url: "{{ route('api.publicize.notification.datatable') }}",
				data: function (d) {				
                    d.status_val = $('#status_val').val(); // สถานะ	
				},				
            },
            
            columns: [
                { 'className': "td_colum text-center", data: 'colum_title', name: 'notification_id' },				
                { 'className': "td_colum text-center", data: 'colum_message', name: 'colum_message' },				
                { 'className': "text-center", data: 'colum_user_id', name: 'colum_user_id' },				
                { 'className': "text-center", data: 'colum_created_at', name: 'colum_created_at' },				
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

        // Form Add
        $('#form_add').on('submit', function(e) {
            e.preventDefault(); 
            var formData = new FormData(this);
            $.ajax({		  
               url: "{{ route('api.publicize.notification.add') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){ 
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
               url: "{{ route('api.publicize.notification.update') }}",
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
        $.ajax({ 
            url: "{{ route('api.publicize.notification.edit') }}",
            data: {"_token": "{{ csrf_token() }}", 'id': id},
            type: "POST",
            async: false,
            success:function(data){ 
                $('#id').val(data.notification_id); 
                $('#title_e').val(data.title); 
                $('#message_e').val(data.message); 
            }
        });	    
    });

    // Update Status
    function status(id,name){
		bootbox.confirm({
			title: "ยืนยัน ?",
			message: "คุณต้องการส่งข้อความ <font color='red'>"+name+"</font> นี้หรือไม่ ?",
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
					url: "{{ route('api.publicize.notification.status')}}",
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