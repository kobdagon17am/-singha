@extends('backend/inc_main') {{-- main.blade.php --}}

 @section('title','| All Tags')

@section('stylesheet')

@endsection

@section('content')

<style>
	input[type="checkbox"] {
		width: 25px;
		height: 25px;
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
                                <h4>เพิ่มข้อมูลผู้ใช้งานเข้าระบบ</h4>
                                <p class="text-muted m-b-10">รายละเอียดเพิ่มข้อมูลผู้ใช้งานเข้าระบบ</p>
                                <ul class="breadcrumb-title b-t-default p-t-10">

                                </ul>
                            </div>

                            <!-- block -->
                            <div class="card-block" id="waitme_submit">
                                <form class="form-horizontal" id="form_submit"  method="POST">
                                    {!! csrf_field() !!}
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label"> ชื่อ <span class="c-red">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="name" id="name" autocomplete="off" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label"> เบอร์ติดต่อ <span class="c-red">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control number checknumber" name="tel" id="tels"  maxlength="10" minlength="10" autocomplete="off" required >
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label"> Line </label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="line" id="line" autocomplete="off" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label"> อีเมล <span class="c-red">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="email" class="form-control" name="email" id="email" autocomplete="off" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">

                                                        <label class="col-sm-2 col-form-label"> ประเภทสมาชิก <span class="c-red">*</span></label>
                                                        <div class="col-sm-2">
                                                            <select class="form-control" style="width:108%;" name="role_mobile" id="role_mobile">
                                                                <option value="AUDIT">AUDIT</option>
                                                                <option value="ADMIN">ADMIN</option>
                                                                <option value="ALL" selected>ทั้งหมด</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label"> username (ID เข้าใช้งาน)<span class="c-red">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="username" id="username" autocomplete="off" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label"> password <span class="c-red">*</span></label>
                                                        <div class="col-sm-10">
                                                            <input type="password" class="form-control" name="password" id="password" maxlength="12" minlength="6" autocomplete="off" required>
                                                        </div>
                                                    </div>

                                                    <div id="dividrepass">
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 col-form-label">confrm password <span class="c-red">*</span></label>
                                                            <div class="col-sm-10">
                                                                <input type="password" class="form-control" name="confirm_password" id="confirm_password"  autocomplete="off" required>
                                                            </div>
                                                            <label class="col-sm-2 col-form-label"></label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label"> สิทธิ์การเข้าถึง <span class="c-red">*</span></label>
                                                        <div class="col-sm-10">
                                                            @foreach($menu as $menus)
                                                                <input type="checkbox" name="access[]" value="{{$menus->menu_id}}"> {{$menus->name}} &nbsp;&nbsp;&nbsp; <br>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label"> สิทธิ์การดูแลตลาด <span class="c-red">*</span></label>
                                                        <div class="col-sm-10">
                                                            @foreach($markets as $market)
                                                                <input type="checkbox" name="marketname[]" value="{{$market->marketname_id}}"> {{$market->name_market}} &nbsp;&nbsp;&nbsp; <br>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            {{-- <button type="button" class="btn btn-danger" onclick="location.replace(document.referrer);">ยกเลิก</button> --}}
                                            <a href="{{ route('backend.admin') }}"  class="btn btn-danger" >ยกเลิก</a>

                                            <button class="btn btn-primary" id="bt_submit">ยืนยัน</button>
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
        $(".pcoded-left-item>li a[href='{{ route('backend.admin') }}']").parent().addClass("active");
    });
</script>

<script>

    $('#bt_submit').click(function(e){
        name = $('#name').val();
        tels = $('#tels').val();
        email = $('#email').val();
        username = $('#username').val();
        password = $('#password').val();
        pw_confirm = $('#confirm_password').val();
        if(name != "" && tels != "" && email != "" && username != "" && password != "" && pw_confirm != "" ){
            e.preventDefault();
            if(password != pw_confirm){
                swal({
                title: "รหัสผ่านไม่ตรงกัน",
                text: "กรุณาทำรายการใส่รหัสผ่านให้ตรงกัน",
                icon: "warning",
                button: "ยืนยัน",
                }).then((value) => {
                    $('#password').val("").focus();
                    $('#confirm_password').val("");
                });
            }else{
                waitme_reload('#waitme_submit');
                setTimeout(function(){
                    $('#form_submit').submit();
                }, 3000);
            }
        }
    });

    $(document).ready(function(){

        $('#form_submit').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
               url: "{{ route('api.admins.store') }}",
               data:formData,
               type:"POST",
               async: false,
               contentType: false,
               processData: false,
               success:function(data){
                    $('#waitme_submit').waitMe("hide")
                    if(data.response == true){
                        swal({
                        title: data.title,
                        text: data.text,
                        icon: "success",
                        button: "ยืนยัน",
                        }).then((value) => {
                            window.location.href = "{{ route('backend.admin') }}";
                        });
                    }else{
                        swal({
                        title: data.title,
                        text: data.text,
                        icon: "warning",
                        button: "ยืนยัน",
                        }).then((value) => {
                           $('#username').focus();
                        });
                    }
                }
            });
        });
    });

    function waitme_reload(value){
		$(value).waitMe({
			effect: 'facebook',
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

<script>
	$('.number').keydown(function(e){
	if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
		(e.keyCode >= 35 && e.keyCode <= 40)){
		return;
		}
		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)){
			e.preventDefault();
		}
		else{
		}
	});

	 $('.checknumber').keypress(function(event) {
	   if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
		event.preventDefault();
	   }
	  });
</script>



@endsection
