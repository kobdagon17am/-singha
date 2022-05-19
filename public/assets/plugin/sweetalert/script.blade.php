
return redirect('')->with('insert','1');




@if(Session::has('insert'))
    <script>
        setTimeout(function(){ 
            swal({
                title: "ส่งข้อมูลสำเร็จ",
                text: "ระบบได้ส่งข้อมูล ของท่าน เรียบร้อยแล้ว",
                type: "success"
            });
        }, 1000);
    </script>
@endif

@if(Session::has('update'))
    <script>
        setTimeout(function(){ 
            swal({
                title: "ส่งข้อมูลไม่สำเร็จ",
                text: "ระบบไม่สามารถส่งข้อมูล ของท่าน ได้",
                type: "success"
            });
        }, 1000);
    </script>
@endif


	<!-- #CSS# Alert Session : (insert, update, delete) -->
	<link rel="stylesheet" type="text/css" href="{{asset('manage/sweetalert/css/sweetalert.css')}}"/>   
	<link rel="stylesheet" type="text/css" href="{{asset('manage/sweetalert/css/jQueryUI/jquery-ui-1.10.4.custom.min.css')}}"/>	 
	
	<!-- Js: Alert session -->
	<script src="{{asset('manage/sweetalert/js/sweetalert.min.js')}}"></script> 
	<script src="{{asset('manage/sweetalert/js/jquery-2.1.1.js')}}"></script>
	<script src="{{asset('manage/sweetalert/js/jquery-ui-1.10.4.min.js')}}"></script>