@extends('backend/inc_main') {{-- main.blade.php --}}

 @section('title','| All Tags')

@section('stylesheet')
     
@endsection 

@section('content')
 
    <?php 
        $page_topic = "ข้อมูลทั่วไป";
        $page_detail = "รายละเอียดข้อมูลทั่วไป"; 
    ?>
	
    {{-- content --}}
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">				
                    <div class="page-body">
                        <div class="card tabs-card">					
                            {{-- header --}}
                            <div class="card-header">
                            <h4>{{$page_topic}}</h4>
                            <p class="text-muted m-b-10">{{$page_detail}}</p>
                                <ul class="breadcrumb-title b-t-default p-t-10"></ul>					
                            </div>
                            
                            <!-- block -->
                            <div class="card-block">
                                
                                {{-- ภาพโปรไฟล์ตลาด --}}
                                <label><i class="fa fa-tags"></i> <b><u>รูปภาพโปรไฟล์ตลาด</b></u></label><br>   
                                <div class="row form-group">
                                    <label class="col-sm-2 col-form-label text-right">&nbsp;</label>
                                    <div class="col-sm-9">
                                        <img src="{{URL::asset('public/assets/backend/img/wait_img.png')}}" id="PreviewImage_pro" class="img-fluid img-responsive" style="width:900px;height:300px;" > 
                                        <p class="c-red">รูปภาพสำหรับโปรไฟล์ตลาด ขนาดรูปภาพ xxx * xxx px</p>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-2 col-form-label text-right"><span class="c-red"></span></label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" name="fileimg_pro" id="fileimg_pro" onchange='preview_img_pro(this);'  autocomplete="off" required>
                                    </div>
                                </div>
                                <hr>

                                {{-- ข้อมูลทั่วไป --}}
                                <label><i class="fa fa-tags"></i> <b><u>ข้อมูลทั่วไป</b></u></label><br>   
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" >ชื่อตลาด :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="" id="" value="" placeholder="ชื่อตลาด" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" >ที่ตั้ง :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="" id="" value="" placeholder="ที่ตั้ง" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" >เวลาทำการ :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="" id="" value="" placeholder="เวลาทำการ" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" >เบอร์โทร :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="" id="" value="" placeholder="เบอร์โทร" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" >Line ID :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="" id="" value="" placeholder="Line ID" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" >Email :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="" id="" value="" placeholder="Email" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                  
                                    <label class="col-sm-2 col-form-label text-right" >เงื่อนไขข้อตกลง :</label>
                                    <div class="col-sm-9">
                                        <textarea type="text"  class="form-control" name="detail_editer" id="detail_editer"  placeholder="เงื่อนไขข้อตกลง" autocomplete="off" required></textarea>                                      
                                    </div>
                                </div>
                                <hr>

                                {{-- รูปภาพผังตลาด --}}
                                <label><i class="fa fa-tags"></i> <b><u>รูปภาพผังตลาด</b></u></label><br>   
                                <div class="row form-group">
                                    <label class="col-sm-2 col-form-label text-right">&nbsp;</label>
                                    <div class="col-sm-9">
                                        <img src="{{URL::asset('public/assets/backend/img/wait_img.png')}}" id="PreviewImage_dia" class="img-fluid img-responsive" style="width:900px;height:300px;" > 
                                        <p class="c-red">รูปภาพสำหรับผังตลาด ขนาดรูปภาพ xxx * xxx px</p>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-2 col-form-label text-right"><span class="c-red"></span></label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" name="fileimg_dia" id="fileimg_dia" onchange='preview_img_dia(this);'  autocomplete="off" required>
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


@endsection 

@section('script')

<script>
    $(document).ready(function(){
        var route_URL = "{{ route('backend.market.general') }}"; // URL 
        $(".pcoded-submenu>li a[href='"+route_URL+"']").parent().addClass("active");
        $(".pcoded-submenu>li a[href='"+route_URL+"']").parent().parent().parent().addClass("pcoded-trigger");
    });
</script>


<script>

    $(document).ready(function(){
        // Editer
        $('#detail_editer').summernote({
            toolbar: [
                ['insert', ['picture','link']],
                ['style', ['style']],
                ['fontsize', ['fontsize']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen']],			
            ],

            fontNames: [
                'Prompt', 'Poppins', 'Arial Black', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 
            ],

            fontSizes: [
                '13','14','16','18', '20', '22','24','36',
            ],
        
            height:250,
            callbacks: {
                onImageUpload: function(files, editor, welEditable) {
                    console.log(files[0]);
                    sendFile(files[0], editor, welEditable,data_id='#detail_editer');
                },
                onpaste: function (e , editor, welEditable) {
                    setTimeout(function(){ 
                        if(navigator.userAgent.search("Firefox") >= 0){
                            var checkfirst = 0;
                            $('.note-editable').contents().each(function(){
                                if(this.nodeType === Node.COMMENT_NODE) {
                                    $(this).remove();
                                    checkfirst = 1;
                                }
                            });
                            if(checkfirst == 0){
                            $('.note-editable *').contents().each(function(){
                                    if(this.nodeType === Node.COMMENT_NODE) {
                                        $(this).remove();
                                        checkfirst = 1;
                                    }
                                });
                            }
                        }
                        $('.note-editable *').contents().each(function(){
                            if($(this).get(0).localName == 'span'){
                            $(this).get(0).style['cssText'] = ''; 
                            }
                        });
                    }, 1000);
                }
            }
        });
    });


    // Preview Image
    function preview_img_pro(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#PreviewImage_pro').attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}

    // Preview Image
    function preview_img_dia(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#PreviewImage_dia').attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}

</script>



@endsection                   