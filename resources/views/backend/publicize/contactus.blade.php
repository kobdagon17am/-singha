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
                                <h4>ผู้ติดต่อ</h4>
                                <p class="text-muted m-b-10">รายละเอียดข้อมูลผู้ติดต่อ</p>
                                <ul class="breadcrumb-title b-t-default p-t-10">

                                </ul>					
                            </div>
                            
                            <!-- block -->
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <div class="form-group">
                                                {{-- <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_add" ><i class="fa fa-plus"></i> เพิ่มข้อมูลผู้ติดต่อ</a>		 --}}
                                            </div>							
                                        </div>
                                    </div>										
                                </div>

                                <div class="dt-responsive table-responsive">								
                                    <table id="datatables" class="table  table-bordered" width="100%">
                                        <thead>
                                            <tr>												
                                                <th class="text-center">หัวข้อ</th>
                                                <th class="text-center">ผู้ติดต่อ</th>
                                                <th class="text-center">เบอร์</th>
                                                <th class="text-center">อีเมล</th>
                                                <th class="text-center">ข้อความ</th>			                                           					    																																																							
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
                        <h4 class="modal-title ">เพิ่ม</h4> 
                        <button type="button" class="close" data-dismiss="modal">×</button>					          
                    </div>
                    
                    <div class="modal-body" id="body_modal_add">         
                    
                        <div class="form-group row"> 
                            <label class="col-sm-4 col-form-label text-right">หัวข้อ:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="title" id="title_a" placeholder="หัวข้อ"  autocomplete="off" required>
                            </div> 
                        </div>
                        <div class="form-group row"> 
                            <label class="col-sm-4 col-form-label text-right">ผู้ติดต่อ:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name" id="name_a" placeholder="ผู้ติดต่อ"  autocomplete="off" required>
                            </div> 
                        </div>
                        <div class="form-group row"> 
                            <label class="col-sm-4 col-form-label text-right">เบอร์:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="phone" id="phone_a" placeholder="เบอร์"  autocomplete="off" required>
                            </div> 
                        </div>
                        <div class="form-group row"> 
                            <label class="col-sm-4 col-form-label text-right">อีเมล:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="email" id="email_a" placeholder="อีเมล"  autocomplete="off" required>
                            </div> 
                        </div>
                        <div class="form-group row"> 
                            <label class="col-sm-4 col-form-label text-right">ข้อความ:</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="message" id="message_a" placeholder="ข้อความ"  autocomplete="off" required>
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


@endsection 

@section('script')

<script>
    $(document).ready(function(){
        var route_URL = "{{ route('backend.publicize.contactus') }}"; // URL 
        $(".pcoded-submenu>li a[href='"+route_URL+"']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='"+route_URL+"']").parent().parent().parent().addClass("pcoded-trigger");
    });
</script>

<script>

    // Button Submit Add
    $('#submit_add').click(function(e){
        e.preventDefault(); 
        $('#form_add').submit();
    });

    $(document).ready(function(){
        // Datable
        var oTable = $("#datatables").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthChange: true,
            stateSave: true,
            
			ajax:{ 
                url : "{{ route('api.publicize.contact.datatable') }}",
				data: function (d) {				
                    d.status_val = $('#status_val').val(); // สถานะ	
				},				
            },
            
            columns: [
                { 'className': "text-center", data: 'colum_title', name: 'colum_title' },							
                { 'className': "text-center", data: 'colum_name', name: 'colum_name' },				
                { 'className': "text-center", data: 'colum_phone', name: 'colum_phone' },			
                { 'className': "text-center", data: 'colum_email', name: 'colum_email' },			
                { 'className': "text-center", data: 'colum_message', name: 'colum_message' },			
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
               url: "{{ route('api.publicize.contact.add') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){ 
                    $('#reload_add').waitMe("hide"); // waitme hind
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
    });

    // Delete
    function datadelete(id){
		bootbox.confirm({
			title: "ยืนยัน ?",
			message: "คุณต้องการลบข้อมูล นี้หรือไม่ ?",
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
					url: "{{ route('api.publicize.contact.delete')}}",
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