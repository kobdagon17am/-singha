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
                                <h4>เพิ่มข้อมูลข่าวสาร</h4>
                                <p class="text-muted m-b-10">รายละเอียดเพิ่มข้อมูลข่าวสาร</p>
                                <ul class="breadcrumb-title b-t-default p-t-10">

                                </ul>
                            </div>

                            <!-- block -->
                            <div class="card-block" id="reload_update">
                                <form class="form-horizontal" id="form_update" method="POST" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                    <input type="hidden" name="id" id="id" value="{{$news->news_id}}" >
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-right">หัวข้อ :</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" name="title" id="title" placeholder="หัวข้อ"  autocomplete="off" value="{{$news->title}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-right">วันเริ่มต้น :</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" name="date_start" id="date_start" placeholder="วันเริ่มต้น"  autocomplete="off" value="{{$news->date_start}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-right">วันสิ้นสุด :</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" name="date_end" id="date_end" placeholder="วันสิ้นสุด"  autocomplete="off" value="{{$news->date_end}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-right">รายละเอียด :</label>
                                        <div class="col-sm-8">
                                        <textarea type="text"  class="form-control" name="detail_editer" id="detail_editer"  placeholder="รายละเอียด" autocomplete="off" required>{{$news->detail}}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="product_code" class="col-sm-2 col-form-label "></label>
                                        <div class="col-sm-8">
                                            @if($news->image != NULL)
                                                <img src="{{URL::asset('storage/uploadfile/news_title/'.$news->image)}}" id="imgfile" class="img-fluid img-responsive" style="width:200px;height:200px;" >
                                            @else
                                                <img src="{{URL::asset('public/assets/backend/img/wait_img.png')}}" id="imgfile" class="img-fluid img-responsive" style="width:200px;height:200px;" >
                                            @endif
                                            <br><span class="c-red">ขนาดรูปภาพหน้าปก 450*250 px</span>
                                        </div>
                                    </div>

                                    {{-- Title img --}}
                                    <div class="form-group row">
                                        <label for="product_code" class="col-sm-2 col-form-label text-right">รูปภาพปก <span class="c-red">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="file" class="form-control"  name="fileimg" id="fileimg" placeholder="รูปภาพ" onchange='readURL(this);' required>
                                            <input type="hidden" name="fileold" value="{{$news->image}}" >
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button type="button" class="btn btn-danger" onclick="location.replace(document.referrer);"><i class="fa fa-history"></i> ยกเลิก</button>
                                        <button type="submit" class="btn btn-primary" id="submit_update"><i class="fa fa-send"></i>  บันทึก</button>
                                    </div>

                                </form>
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

    $('#submit_update').click(function(e){
        e.preventDefault();
        waitme_update();
        setTimeout(function(){
            $('#form_update').submit();
        }, 3000);
    });

    $(document).ready(function(){

        // Form Update
        $('#form_update').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this); // value total in form
            $.ajax({
                url:"{{ route('api.publicize.news.update') }}",
                data:formData,
                type:"POST",
                async: false,
                contentType: false,
                processData: false,
                success:function(data){
                    if(data.response==true){
                        swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "OK",
                        }).then((value) => {
							$('#reload_update').hide();
							// window.location.href = "{{ route('backend.publicize.news')}}";
                            window.location.reload();
                        });
                    }
                }
            });
        });

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

    // Send File Editer
	function sendFile(file, editor, welEditable,data_id) {
        setTimeout(function(){
            var data = new FormData();
            data.append("image",file);
            $.ajaxSetup({
                async: false
            });
            $.ajax({
                url: '{{ route("api.publicize.news.editer") }}',
                type: 'POST',
                data: data,
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    setTimeout(function(){
                        var img = data;
                        console.log('imgcheck : '+img)
                      $(''+data_id).summernote("editor.insertImage", img);
                    }, 1000);
                }
            });
        }, 1000);
    }

    // Preview Image
    function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) { $('#imgfile').attr('src', e.target.result); };
			reader.readAsDataURL(input.files[0]);
		}
	}

    // Reload
	function waitme_update(){
		$('#reload_update').waitMe({
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
