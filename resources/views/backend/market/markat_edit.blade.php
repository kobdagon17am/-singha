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
                            <h4>แก้ไขข้อมูลโปรไฟล์ตลาด</h4>
                            <p class="text-muted m-b-10">รายละเอียดเพิ่มข้อมูลโปรไฟล์ตลาด</p>
                                <ul class="breadcrumb-title b-t-default p-t-10">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('backend.dashboard') }}">
                                        <i class="fa fa-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="">รายชื่อตลาด</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="">{{$market->name_market}}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="">แก้ไขข้อมูลโปรไฟล์ตลาด</a>
                                    </li>
                                </ul>
                            </div>

                            <!-- block -->
                            <div class="card-block" id="reload_update">
                            <form class="form-horizontal" id="form_update" method="POST" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                                <input type="hidden" name="id" id="id"  value="{{$market->marketname_id}}"> {{-- ID --}}

                                {{-- ภาพโปรไฟล์ตลาด --}}
                                <label><i class="fa fa-tags"></i> <b><u>รูปภาพโปรไฟล์ตลาด</b></u></label><br>
                                <div class="row form-group">
                                    <label class="col-sm-2 col-form-label text-right">&nbsp;</label>
                                    <div class="col-sm-9">
                                        <img src="{{URL::asset('storage/uploadfile/market/'.$market->image_profile)}}" id="PreviewImage_pro" class="img-fluid img-responsive" style="width:900px;height:300px;" >
                                        <p class="c-red">รูปภาพสำหรับโปรไฟล์ตลาด ขนาดรูปภาพ 400 * 250 px</p>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-2 col-form-label text-right"><span class="c-red"></span></label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" name="fileimg_pro" id="fileimg_pro" onchange='preview_img_pro(this);'  autocomplete="off" required>
                                        <input type="hidden" name="image_profile" id="image_profile" value="{{$market->image_profile}}" >
                                    </div>
                                </div><hr>
                                {{-- ====================================================================== --}}

                                {{-- ข้อมูลทั่วไป --}}
                                <label><i class="fa fa-tags"></i> <b><u>ข้อมูลทั่วไป</b></u></label><br>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" >ชื่อตลาด :</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name_market" id="name_market" placeholder="ชื่อตลาด" autocomplete="off" required value="{{$market->name_market}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" >ชื่อบริษัท :</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" rows="5" cols="50"  class="form-control" name="company_name" id="company_name"  placeholder="เงื่อนไขข้อตกลง" autocomplete="off" required >{{$market->company_name}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" >ที่ตั้ง :</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" rows="5" cols="50"  class="form-control" name="address_marker" id="address_marker"  placeholder="เงื่อนไขข้อตกลง" autocomplete="off" required >{{$market->address_marker}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" >เวลาทำการ :</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" name="time" id="time"  placeholder="เวลาทำการ" autocomplete="off" required value="{{$market->time}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" >เบอร์โทร :</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" name="phone" id="phone"  placeholder="เบอร์โทร" autocomplete="off" required value="{{$market->phone}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" >Line ID :</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" name="line" id="line"  placeholder="Line ID" autocomplete="off" required value="{{$market->line}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" >Email :</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" name="email" id="email"  placeholder="Email" autocomplete="off" required value="{{$market->email}}">
                                    </div>
                                </div>

                                {{-- <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right" >เงื่อนไขข้อตกลง :</label>
                                    <div class="col-sm-9">
                                    <textarea type="text"  class="form-control" name="detail_editer" id="detail_editer"  placeholder="เงื่อนไขข้อตกลง" autocomplete="off" required >{{$market->agreement}}</textarea>
                                    </div>
                                </div> --}}
                                <hr>
                                {{-- ====================================================================== --}}

                                {{-- รูปภาพผังตลาด --}}
                                <label><i class="fa fa-tags"></i> <b><u>รูปภาพผังตลาด</b></u></label><br>
                                <div class="row form-group">
                                    <label class="col-sm-2 col-form-label text-right">&nbsp;</label>
                                    <div class="col-sm-9">
                                        <img src="{{URL::asset('storage/uploadfile/market/'.$market->image_diagram)}}" id="PreviewImage_dia" class="img-fluid img-responsive" style="width:900px;height:300px;" >
                                        <p class="c-red">รูปภาพสำหรับผังตลาด ขนาดรูปภาพ 400 * 250 px</p>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-2 col-form-label text-right"><span class="c-red"></span></label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" name="fileimg_dia" id="fileimg_dia" onchange='preview_img_dia(this);'  autocomplete="off" required>
                                        <input type="hidden" name="image_dia" id="image_dia" value="{{$market->image_diagram}}" >
                                    </div>
                                </div>
                                <br><br>
                                {{-- =================================================================== --}}

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
        var route_URL = "{{ route('backend.market.name') }}"; // URL
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
                url:"{{ route('api.market.name.update') }}",
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
							// window.location.href = "{{ route('backend.market.name')}}";
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

    // Send File Editer
	function sendFile(file, editor, welEditable,data_id) {
        setTimeout(function(){
            var data = new FormData();
            data.append("image",file);
            $.ajaxSetup({
                async: false
            });
            $.ajax({
                url: '{{ route("api.market.name.editer") }}',
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

    // Reload Update
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
