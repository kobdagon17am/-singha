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
                                <h4>รายการโปรโมชั่น</h4>
                                <p class="text-muted m-b-10">รายละเอียดข้อมูลรายการโปรโมชั่น</p>
                                <ul class="breadcrumb-title b-t-default p-t-10"></ul>					
                            </div>
                            
                            <!-- block -->
                            <div class="card-block">
                                {{-- add --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <div class="form-group">
                                                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_add" ><i class="fa fa-plus"></i> เพิ่มข้อมูลโปรโมชั่น</a>		
                                            </div>							
                                        </div>
                                    </div>										
                                </div>

                                {{-- status --}}
                                <div class="d-flex justify-content-end">
                                    <p style="margin-top: 6px;">Show</p>
                                    <div class="col-sm-2">
                                        <select class="form-control" style="width:108%;" name="status_val" id="status_val">
                                            <option value="W">รออนุมัติ</option>
                                            <option value="Y">ใช้งาน</option>
                                            <option value="N">ยกเลิก</option>
                                            <option value="T" selected>ทั้งหมด</option>
                                        </select>
                                    </div>                                
                                </div><br>

                                {{-- datatable --}}
                                <div class="dt-responsive table-responsive">								
                                    <table id="datatables" class="table table-bordered" width="100%">
                                        <thead>
                                            <tr>												
                                                <th class="text-center">รหัสโปรโมชั่น</th>
                                                <th class="text-center">ชื่อโปรโมชั่น</th>
                                                <th class="text-center">ราค่าลด</th>
                                                <th class="text-center">วันที่เริ่ม</th>
                                                <th class="text-center">วันที่สิ้นสุด</th>
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
                        <h4 class="modal-title ">เพิ่มข้อมูลโปรโมชั่น</h4> 
                        <button type="button" class="close" data-dismiss="modal">×</button>					          
                    </div>
                    
                    <div class="modal-body" id="body_modal_add">         
                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <label>รหัสโปรโมชั่น <span class="c-red">*</span></label>
                                <input type="text" class="form-control" name="" id="" placeholder="ระบบสร้างรหัสอัตโนมัติ" autocomplete="off" readonly>
                            </div>                  
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <label>ชื่อโปรโมชั่น <span class="c-red">*</span></label>
                                <input type="text" class="form-control" name="name" id="name_a" placeholder="ชื่อโปรโมชั่น" autocomplete="off" required>
                            </div>                  
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>วันที่เริ่ม <span class="c-red">*</span></label>
                                <input class="form-control" type="date" name="date_start" id="date_start_a" required>
                            </div>              
                            <div class="col-md-3">
                                <label>วันที่สิ้นสุด <span class="c-red">*</span></label>
                                <input class="form-control" type="date" name="date_end" id="date_end_a" required>
                            </div>              
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>ราคาลด <span class="c-red">*</span></label>
                                <div class="input-group input-group-button">
                                    <input type="text" class="form-control text-right numbers checknumber" name="price" id="price_a" autocomplete="off" placeholder="ราคาลด" required>
                                    <select class="form-control" style="height:35px" name="type_con" id="type_con_a">
                                        <option value="1" selected>บาท</option>
                                        <option value="2">%</option>                                                                                                              
                                    </select>
                                </div>           
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
                        <h4 class="modal-title ">แก้ไขข้อมูลโค้ดส่วนลด</h4> 
                        <button type="button" class="close" data-dismiss="modal">×</button>
                     </div>

                     <div class="modal-body" id="body_modal_edit">    
                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <label>รหัสโปรโมชั่น <span class="c-red">*</span></label>
                                <input type="text" class="form-control" name="code" id="code_e" placeholder="ระบบสร้างรหัสอัติโนมัติ" autocomplete="off" readonly>
                            </div>                  
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <label>ชื่อโปรโมชั่น <span class="c-red">*</span></label>
                                <input type="text" class="form-control" name="name" id="name_e" placeholder="ชื่อโปรโมชั่น" autocomplete="off" required>
                            </div>                  
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>วันที่เริ่ม <span class="c-red">*</span></label>
                                <input class="form-control" type="date" name="date_start" id="date_start_e" required>
                            </div>              
                            <div class="col-md-3">
                                <label>วันที่สิ้นสุด <span class="c-red">*</span></label>
                                <input class="form-control" type="date" name="date_end" id="date_end_e" required>
                            </div>              
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <label>ราคาลด <span class="c-red">*</span></label>
                                <div class="input-group input-group-button">
                                    <input type="text" class="form-control text-right numbers checknumber" name="price" id="price_e" autocomplete="off" placeholder="ราคาลด" readonly required>
                                    <select class="form-control" style="height:35px" name="type_con" id="type_con_e" readonly >
                                        <option value="1" selected>บาท</option>
                                        <option value="2">%</option>                                                                                                              
                                    </select>
                                </div>           
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id" id="id">
                    
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
        $(".pcoded-submenu>li a[href='{{ route('backend.promotion') }}']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='{{ route('backend.promotion') }}']").parent().parent().parent().addClass("pcoded-trigger");
    });
</script>

<script>

    // Button Submit Add
    $('#submit_add').click(function(e){
        var name = $('#name_a').val();
        var date_start = $('#date_start_a').val();
        var date_end = $('#date_end_a').val();
        var price = $('#price_a').val();
        if(name != "" && date_start != "" && date_end != "" && price != ""){
            e.preventDefault();
            waitme_reload('#reload_add'); 
            setTimeout(function(){
                $('#form_add').submit();
            }, 3000);
        }
    });

    // Button Submit Update
    $('#submit_edit').click(function(e){
        var name = $('#name_e').val();
        var date_start = $('#date_start_e').val();
        var date_end = $('#date_end_e').val();
        if(name != "" && date_start != "" && date_end != ""){
            e.preventDefault();
            waitme_reload('#reload_edit'); 
            setTimeout(function(){
                $('#form_edit').submit();
            }, 3000);
        }
    });

    $(document).ready(function(){
        // Datable Code
        var oTable = $("#datatables").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthChange: true,
            stateSave: true,
            
			ajax:{ 
                url : "{{ route('api.promotion.datatable') }}",
				data: function (d) {				
                    d.status_val = $('#status_val').val(); // สถานะ	
				},				
            },
            
            columns: [
                { 'className': "text-center", data: 'colum_code', name: 'colum_code' },	
                { 'className': "text-center", data: 'colum_name', name: 'colum_name' },	
                { 'className': "text-center", data: 'colum_price', name: 'colum_price' },	
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

        // Form Add
        $('#form_add').on('submit', function(e) {
            e.preventDefault(); 
            var formData = new FormData(this); // value total in form
            $.ajax({		  
                url:"{{ route('api.promotion.add') }}",
                data:formData,
                type:"POST",
                async: false,
                contentType: false,
                processData: false,
                success:function(data){ 
                    $('#reload_add').waitMe("hide"); // waitme stop
                    $('#modal_add').modal('hide') // modal add hide
                    // $('#body_modal_add').load(document.URL + ' #body_modal_add'); // body modal add refresh
                    if(data.response==true){
                        swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "OK",
                        }).then((value) => {
                           // oTable.draw(); // refresh datatable
                            window.location.reload();
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
               url: "{{ route('api.promotion.update') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){ 
                    $('#reload_edit').waitMe("hide"); // waitme stop
                    $('#modal_edit').modal('hide') // modal add hide
                    // $('#body_modal_edit').load(document.URL + ' #body_modal_add'); // body modal add refresh
                    if(data.response == true){
                        swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "ยืนยัน",
                        }).then((value) => {               
                          //  oTable.draw(); // refresh dadatable
                            window.location.reload();
                        });
                    } 					
                }
            });
        });

    });



    $(document).on('click','.model-data', function(){
        var id = $(this).attr('data-id');
        $.ajax({ 
            url:"{{ route('api.promotion.edit') }}",
            data:{"_token": "{{ csrf_token() }}",'id':id},
            type:"POST",
            success:function(data){ 
                $('#id').val(data.promotion_id);
                $('#code_e').val(data.code);
                $('#name_e').val(data.name);
                $('#date_start_e').val(data.date_start);
                $('#date_end_e').val(data.date_end);
                $('#price_e').val(data.price);
                $('#type_con_e').val(data.type_con).trigger('change');
            }
        });
    });

     // Status Confirm
     function data_confirm(id,name){
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
					url: "{{ route('api.promotion.confirm')}}",
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

    // Status Cancel
    function data_cancel(id,name){
		bootbox.confirm({
			title: "ยืนยัน ?",
			message: "คุณต้องการยกเลิกใช้งานโค้ดส่วนลด <font color='red'>"+name+"</font> นี้หรือไม่ ?",
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
					url: "{{ route('api.promotion.cancel')}}",
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

    // Waitme Reload
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