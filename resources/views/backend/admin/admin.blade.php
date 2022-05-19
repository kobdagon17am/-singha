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
                                <h4>ผู้ใช้งานเข้าระบบทดสอบ</h4>
                                <p class="text-muted m-b-10">รายละเอียดข้อมูลผู้ใช้งานเข้าระบบ</p>
                                <ul class="breadcrumb-title b-t-default p-t-10">

                                </ul>
                            </div>

                            <!-- block -->
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <div class="form-group">
                                            <a href="{{ route('backend.admin.create') }}" class="btn btn-dark" ><i class="fa fa-plus"></i> เพิ่มข้อมูลผู้ใช้งานระบบ</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {{-- Status --}}
                            <div class="d-flex justify-content-end">
                                <p style="margin-top: 6px;">Show</p>
                                <div class="col-sm-2">
                                    <select class="form-control" style="width:108%;" name="status_val" id="status_val">
                                        <option value="AUDIT">AUDIT</option>
                                        <option value="ADMIN">ADMIN</option>
                                        <option value="ALL" selected>ทั้งหมด</option>
                                    </select>
                                </div>
                            </div><br>
                                <div class="dt-responsive table-responsive">
                                    <table id="datatables" class="table  table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ชื่อ</th>
                                                <th class="text-center">username</th>
                                                <th class="text-center">อีเมล์</th>
                                                <th class="text-center">เบอร์ติดต่อ</th>
                                                <th class="text-center">สถานะ</th>
                                                <th width="20%" class="text-center">จัดการ</th>
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


    {{-- Modal Edit --}}
    <div class="modal fade" id="modal_edit" role="dialog">
        <form method="POST"  id="form_edit">
        {!! csrf_field() !!}
            <div class="modal-dialog modal-lg" id="waitme_edit">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">แก้ไขข้อมูลผู้ใช้งานเข้าระบบ</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="id" id="id"> {{-- ID --}}

                        <div class="form-group row">
							<label for="product_code" class="col-sm-3 col-form-label text-right">ชื่อ <span class="c-red">*</span></label>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="name" id="name" autocomplete="off" required>
							</div>
                        </div>

                        <div class="form-group row">
							<label for="product_code" class="col-sm-3 col-form-label text-right">เบอร์ติดต่อ <span class="c-red">*</span></label>
							<div class="col-sm-7">
                                <input type="text" class="form-control number checknumber" name="tel" id="tels"  maxlength="10" minlength="10" autocomplete="off" required >
							</div>
                        </div>

                        <div class="form-group row">
							<label for="product_code" class="col-sm-3 col-form-label text-right">Line </label>
							<div class="col-sm-7">
                                <input type="text" class="form-control" name="line" id="line" autocomplete="off" >
							</div>
                        </div>

                        <div class="form-group row">
							<label for="product_code" class="col-sm-3 col-form-label text-right">อีเมล <span class="c-red">*</span></label>
							<div class="col-sm-7">
                                <input type="email" class="form-control" name="email" id="email" autocomplete="off" required>
							</div>
                        </div>

                        <div class="form-group row">
                            <label for="product_code" class="col-sm-3 col-form-label text-right">ประเภทสมาชิก<span class="c-red">*</span></label>
                            <div class="col-sm-2">
                                <select class="form-control" style="width:108%;" name="role_mobile" id="role_mobile">
                                    <option value="AUDIT">AUDIT</option>
                                    <option value="ADMIN">ADMIN</option>
                                    <option value="ALL" selected>ทั้งหมด</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
							<label for="product_code" class="col-sm-3 col-form-label text-right">username (ID เข้าใช้งาน) <span class="c-red">*</span></label>
							<div class="col-sm-7">
                                <input type="text" class="form-control" name="username" id="username" autocomplete="off" required readonly>
							</div>
                        </div>

                        {{-- <div class="form-group row">
							<label for="product_code" class="col-sm-3 col-form-label text-right">username (ID เข้าใช้งาน) <span class="c-red">*</span></label>
							<div class="col-sm-7">
                                <input type="text" class="form-control" name="username" id="username" autocomplete="off" required readonly>
							</div>
                        </div> --}}

                        <div class="form-group row">
							<label for="product_code" class="col-sm-3 col-form-label text-right">password <span class="c-red">*</span></label>
							<div class="col-sm-7">
                                <input type="password" class="form-control" name="password" id="password" maxlength="12" minlength="6" autocomplete="off"  >
							</div>
                        </div>

                        <div class="form-group row">
							<label for="product_code" class="col-sm-3 col-form-label text-right">confrm password <span class="c-red">*</span></label>
							<div class="col-sm-7">
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password"  autocomplete="off"  >
							</div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        <button class="btn btn-primary" id="bt_edit">บันทึก</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


    {{-- สิทธิ์การเข้าถึง --}}
    <div class="modal fade" id="modal_editP" role="dialog">
        <form method="POST"  id="form_editP">
        {!! csrf_field() !!}
            <div class="modal-dialog modal-lg" id="reload_editP">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title ">แก้ไขสิทธิ๋การเข้าถึงเมนู</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="id_admin" id="id_admin"> {{-- ID --}}
                        <div class="dt-responsive table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th width="50%" class="text-center">เมนู</th>
										<th width="20%" class="text-center">สิทธิ์การเข้าถึง</th>
									</tr>
								</thead>
								 <tbody>
                                        @foreach($menu as $menus)
                                            <tr class="text-center">
                                                <td>{{$menus->name}}</td>
                                                <td style="display: flex; justify-content: center;">
                                                    <input type="checkbox" name="access[]" id="access{{$menus->menu_id}}" class="form-control" value="{{$menus->menu_id}}" style="width: 25px; height: 25px; -moz-appearance: none;">
                                                </td>
                                            </tr>
                                        @endforeach
								 </tbody>
							</table>
                        </div>
                        <div class="dt-responsive table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th width="50%" class="text-center">ตลาด</th>
										<th width="20%" class="text-center">สิทธิ์การดูแลตลาด</th>
									</tr>
								</thead>
								 <tbody id="tbody_rule">
                                        {{-- @foreach($adminrules as $adminrule) --}}
                                            {{-- <tr class="text-center" >
                                                <td>{{$adminrule->market}}</td>
                                                <td style="display: flex; justify-content: center;">
                                                    <input type="checkbox" name="access[]" id="access{{$adminrule->market}}" class="form-control" value="{{$adminrule->market}}" style="width: 25px; height: 25px; -moz-appearance: none;">
                                                </td>
                                            </tr> --}}
                                        {{-- @endforeach --}}
								 </tbody>
							</table>
						</div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                        <button class="btn btn-primary" id="bt_editP">บันทึก</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


@endsection

@section('script')

<script>
    $(document).ready(function(){
        $(".pcoded-left-item>li a[href='{{ route('backend.admin') }}']").parent().addClass("active");
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
            pageLength: 10,

            ajax:{
                url : "{{ route('api.admins.datatable') }}",
                type: "POST",
				data: function (d) {
                    d.status_val = $('#status_val').val(); // สถานะ
				},
            },
            columns: [
               { 'className': "text-center", data: 'name', name: 'name' },
               { 'className': "text-center", data: 'colum_username', name: 'colum_username' },
               { 'className': "text-center", data: 'email', name: 'email' },
               { 'className': "text-center", data: 'tel', name: 'tel' },
               { 'className': "text-center", data: 'colum_status', name: 'colum_status' },
               { 'className': "text-center", data: 'colum_manage', name: 'colum_manage' },

            ],
            order: [[0, 'asc']],
            rowCallback: function(row,data,index ){

            }
        });
    // Sort Status | Datatable
    $('#status_val').change(function(e){
                oTable.draw();
            });
    });


    $(document).on('click', ".model-data", function() {
		var id = $(this).attr('data-id');
		$.ajax({
			url: "{{ route('api.admins.edit') }}",
			data: {"_token": "{{ csrf_token() }}",'id':id},
			type: "POST",
			success: function(data){
                data = data.admin;
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#tels').val(data.tel);
                $('#line').val(data.line);
                $('#email').val(data.email);
                $('#username').val(data.username);
                $('#role_mobile').val(data.role_mobile);
			}
		});
	});

    $(document).on('click',".model-dataP", function() {
        var id = $(this).attr('data-id');
        document.getElementById("access1").checked = false;
		document.getElementById("access2").checked = false;
		document.getElementById("access3").checked = false;
		document.getElementById("access4").checked = false;
		document.getElementById("access5").checked = false;
		document.getElementById("access6").checked = false;
		document.getElementById("access7").checked = false;
		document.getElementById("access8").checked = false;
		document.getElementById("access9").checked = false;
		document.getElementById("access10").checked = false;
		document.getElementById("access11").checked = false;
        $.ajax({
            url: "{{ route('api.admins.edit') }}",
            data: { "_token": "{{ csrf_token() }}",'id':id },
            type: "POST",
            success: function(data) {

                $('#tbody_rule').html(data.tbody_rule);
                data = data.admin
                $('#id_admin').val(data.id);
                var premission  = data.status_admin;
				var decode_pre  = decodeURI(premission);
				var	pre_replace = decode_pre.replace(/"/g,"");
					pre_replace = pre_replace.replace('[',"");
					pre_replace = pre_replace.replace(']',"");
				var	value_pre   = pre_replace.split(",");
                value_pre.forEach(function(item,val) {
					if(item == $('#access1').val()){
						document.getElementById("access1").checked = true;
					}else if(item == $('#access2').val()){
						document.getElementById("access2").checked = true;
					}else if(item == $('#access3').val()){
						document.getElementById("access3").checked = true;
					}else if(item == $('#access4').val()){
						document.getElementById("access4").checked = true;
					}else if(item == $('#access5').val()){
						document.getElementById("access5").checked = true;
					}else if(item == $('#access6').val()){
						document.getElementById("access6").checked = true;
					}else if(item == $('#access7').val()){
                        document.getElementById("access7").checked = true;
                    }else if(item == $('#access8').val()){
                        document.getElementById("access8").checked = true;
                    }else if(item == $('#access9').val()){
                        document.getElementById("access9").checked = true;
                    }else if(item == $('#access10').val()){
                        document.getElementById("access10").checked = true;
                    }else if(item == $('#access11').val()){
                        document.getElementById("access11").checked = true;
                    }
				});
            },
            error: function(data) {
                alert("error")
                window.location.reload();
            }
        });
    });


    $('#bt_edit').click(function(e){
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
                waitme_reload('#waitme_edit');
                setTimeout(function(){
                    $('#form_edit').submit();
                }, 3000);
            }
        }
    });

    $(document).ready(function(){
        // Form Edit
        $('#form_edit').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
               url: "{{ route('api.admins.update') }}",
               data: formData,
               type: "POST",
               async: false,
               contentType: false,
               processData: false,
               success: function(data){
                    $('#waitme_edit').waitMe("hide")
                    $('#modal_edit').modal('hide')
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

        // Form EditP
        $('#form_editP').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
               url: "{{ route('api.admins.permission') }}",
               data: formData,
               type: "POST",
               async: false,
               contentType: false,
               processData: false,
               success: function(data){
                    $('#modal_editP').modal('hide')
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

    function update_status(id,name){
		bootbox.confirm({
			title: "ยืนยัน ?",
			message: "คุณต้องการอัพเดทการใช้งาน <font color='red'>"+name+"</font> นี้หรือไม่ ?",
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
                        url:"{{ route('api.admins.status')}}",
                        data:{ "_token": "{{ csrf_token() }}", 'id' : id },
                        type:"POST",
                        async:false,
                        success:function(data){
                            if(data.response == true){
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
