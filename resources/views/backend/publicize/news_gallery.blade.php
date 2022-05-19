@extends('backend/inc_main') {{-- main.blade.php --}}

 @section('title','| All Tags')

@section('stylesheet')
     
@endsection 

@section('content')
 
<style type="text/css">
	.main-section{
		margin:0 auto;
		padding: 20px;
		margin-top: 20px;
		background-color: #fff;
		box-shadow: 0px 0px 20px #c1c1c1;
	}
		.fileinput-remove,
		.fileinput-upload{
		display: none;
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
                                <h4>รูปภาพเพิ่มเติมหัวข้อ : {{$news->title}} </h4>
                                <p class="text-muted m-b-10">รายละเอียดรูปภาพเพิ่มเติม</p>
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
                                                <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal_add" ><i class="fa fa-plus"></i> เพิ่มรุปภาพเพิ่มเติม</a>				
                                            </div>							
                                        </div>
                                    </div>										
                                </div>

                                {{-- datatable --}}
                                <div class="dt-responsive table-responsive">								
                                    <table id="datatables" class="table  table-bordered" width="100%">
                                        <thead>
                                            <tr>												
                                                <th class="text-center" width="5%">ลำดับ</th>
                                                <th class="text-center" width="30%">รูปภาพ</th>	                                           					    																																																							
                                                <th class="text-center" width="10%">สถานะ</th>	                                           					    																																																							
                                                <th class="text-center" width="10%">จัดการ</th>			                                           					    																																																							
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($news->gallery as $key => $gallrys)
                                            <tr>
                                                <td class="text-center">{{$key+1}}</td>
                                                <td class="text-center">
                                                    <img src="{{URL::asset('storage/uploadfile/news_gallery/'.$gallrys->image)}}"  class="img-fluid img-responsive" style="height:275px; width:475px;" > 
                                                </td>
                                                <td class="text-center">
                                                    @if($gallrys->status == "Y")
                                                        <font color="green"><p title="ใช้งาน"><i class="fa fa-check-circle"></i> ใช้งาน</p></font>
                                                    @else
                                                        <font color="red"><p title="ยกเลิก"><i class="fa fa-times-circle"></i> ยกเลิก</p></font>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn-primary model-data" data-id='{{$gallrys->news_gallery_id}}' data-toggle="modal" data-target="#modal_edit" aria-hidden="true"><i class="fa fa-edit"></i> แก้ไข</button>&nbsp;
                                                    <button type="button" class="btn-danger" onclick="status({{$gallrys->news_gallery_id}})"><i class="fa fa-wrench"></i> ใช้งาน/ยกเลิก</button>
                                                    <button type="button" class="btn-dark" onclick="datadelete({{$gallrys->news_gallery_id}})"><i class="fa fa-trash-o"></i> ลบ</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>   
                                </div> 
                                
                                <div class="text-right">
                                    <button type="button" class="btn btn-danger" onclick="location.replace(document.referrer);"><i class="fa fa-history"></i> ยกเลิก</button>
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
        <form  method="POST" id="form_add" enctype="multipart/form-data"> 
        {!! csrf_field() !!}
            <div class="modal-dialog modal-lg" id="reload_add">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">เพิ่มรูปภาพเพิ่มเติม</h4> 
                        <button type="button" class="close" data-dismiss="modal">×</button>					          
                    </div>
                    
                    <div class="modal-body" id="body_modal_add">                      
                        <div class="row form-group">								
                            <div class="col-lg-10 col-sm-8 col-12 main-section">
                                <label >รูปภาพเพิ่มเติม xxx * xxx px (สูงสุดครั้งละ 6 รูป)</label>
                                <div class="form-group">
                                    <div class="file-loading">
                                        <input type="file" class="file" id="fileimg_gallery"  name="fileimg_gallery[]" multiple required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="{{$news->news_id}}"> <!-- ID -->

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
                        <h4 class="modal-title ">แก้รุปภาพเพิ่มเติม</h4> 
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>

                        <div class="modal-body" id="body_modal_edit">    
                        <br>
                        <div class="form-group row"> 
                            <label class="col-sm-4 col-form-label text-right"></label>
                            <div class="col-sm-4">
                                <img src="{{URL::asset('public/assets/img/wait_img.png')}}" id="previewimage" class="img-fluid img-responsive" style="height:275px; width:475px;" > 
                                <p class="c-red">รูปภาพเพิ่มเติม ขนาดรูปภาพ xxx * xxx px</p>
                                <input type="file" class="form-control" name="image_file" id="image_file" onchange='readURL(this);'  autocomplete="off" required>
                            </div> 
                        </div>
                        <input type="hidden" name="fileold" id="fileold">
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
        $("#fileimg_gallery").fileinput({
            theme: 'fa',
            //	uploadUrl: "#",
            allowedFileExtensions: ['jpg', 'png'],
            overwriteInitial: false,
            maxFilesNum: 10,
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
	    });
    });

    // Submit Add
    $('#submit_add').click(function(e){
        img  = $('#fileimg_gallery').val();
        if(img != ""){
            e.preventDefault(); 
            waitme_load('#reload_add');
            setTimeout(function(){
                $('#form_add').submit();
            }, 3000);
        }
    });
    
    $('#submit_edit').click(function(e){
        img  = $('#image_file').val();
        if(img != ""){
            e.preventDefault(); 
            waitme_load('#reload_edit');
            setTimeout(function(){
                $('#form_edit').submit();
            }, 3000);
        }
    });


    $(document).ready(function(){

        // Form Add
        $('#form_add').on('submit', function(e) {
            e.preventDefault(); 
            var formData = new FormData(this);
            $.ajax({		  
               url: "{{ route('api.publicize.news.gallery_add') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){ 
                    $('#reload_add').waitMe("hide"); // waitme stop
                    $('#modal_add').modal('hide'); // modal add hide
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

        // Form Update
        $('#form_edit').on('submit', function(e) {
            e.preventDefault(); 
            var formData = new FormData(this);
            $.ajax({		  
               url: "{{ route('api.publicize.news.gallery_update') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){ 
                    $('#reload_edit').waitMe("hide"); // waitme hind
                    $('#modal_edit').modal('hide') // modal add hide
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

    $(document).on('click', ".model-data", function() {	  
        var id = $(this).attr('data-id');
        $("#previewimage").attr('src',""); // attr image empty
        $.ajax({ 
            url: "{{ route('api.publicize.news.gallery_edit') }}",
            data: {"_token": "{{ csrf_token() }}", 'id': id},
            type: "POST",
            async: false,
            success:function(data){ 
                image_src = "{{asset('storage/uploadfile/news_gallery')}}/"+data.image;
                $('#id').val(data.news_gallery_id); // id
                $('#previewimage').attr('src',image_src); // image
                $('#fileold').val(data.image); // image value old
            }
        });	    
    });


    function status(id){
		bootbox.confirm({
			title: "ยืนยัน ?",
			message: "คุณต้องการอัพเดทสถานะรูปภาพ นี้หรือไม่ ?",
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
					url: "{{ route('api.publicize.news.gallery_status')}}",
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

    function datadelete(id){
		bootbox.confirm({
			title: "ยืนยัน ?",
			message: "คุณต้องการลบรูปภาพนี้ นี้หรือไม่ ?",
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
					url: "{{ route('api.publicize.news.gallery_delete')}}",
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

    function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#previewimage').attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
    
	function waitme_load(value){
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