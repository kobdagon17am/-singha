<style>
.label {
  color: white;
  padding: 2px;
  font-family: Arial;
}
.success {background-color: #4CAF50;} /* Green */
.info {background-color: #2196F3;} /* Blue */
.warning {background-color: #ff9800;} /* Orange */
.danger {background-color: #f44336;} /* Red */ 
.other {background-color: #e7e7e7; color: black;} /* Gray */ 

.ui-autocomplete {
position: absolute;
z-index: 2150000000 !important;
cursor: default;
border: 2px solid #ccc;
padding: 5px 0;
border-radius: 2px;
}
</style>
<link href="{{asset('manage/autocomplese/style.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('manage/autocomplese/jquery-ui.1.10.1.min.css')}}" rel="stylesheet" type="text/css">


<!-- Script autocomplete -->
<script>
	var name_th_shop = "";
	$(".optionselect").autocomplete({
		minLength: 0,
		
		source: function(request, response) {
			$.ajax({
				url:"{{ route('auto.com') }}",
				data:{"_token": "{{ csrf_token() }}",'name_th_shop':request.term},
				type: "POST",
				dataType: "json",
				success: function(data) {
					response(data);
				},
			});
		},
		select: function(event, ui) {
			document.getElementById('id_shop').value = ui.item.id;
			//setdataoption();
		}
	});
	function clearVlue() {
	$(".optionselect").val("");
	}
	
</script>


<!-- onchang image -->	
<script>
	$( document ).ready(function() {
	    $(".edit-gallery").on('click', function() {
			var id_data = $(this).attr('data-id');

			$("#image_gallery").attr('src',"{{asset('manage/images/noimage.jpg')}}");
			document.getElementById("name_shop").value="";
			document.getElementById("phone_shop").value="";
			document.getElementById("time_shop").value="";
			document.getElementById("optionselect").value="";

			document.getElementById("id_area").value="";
			document.getElementById("column_x").value="";
			document.getElementById("row_y").value="";
			document.getElementById("refid_floorplan").value="";
			document.getElementById("refid_shop").value="";
			
			$.ajax({ 
				url:"{{ route('floorplan.data.json') }}",
				data:{"_token": "{{ csrf_token() }}",'id_data':id_data},
				type:"POST",
				
				success:function(data){ 
					var obj = jQuery.parseJSON(data);					

					document.getElementById("id_area").value=obj.datafloorpaln.id_area;
					document.getElementById("column_x").value=obj.datafloorpaln.column_x;
					document.getElementById("row_y").value=obj.datafloorpaln.row_y;
					document.getElementById("refid_floorplan").value=obj.datafloorpaln.refid_floorplan;
					document.getElementById("refid_shop").value=obj.datafloorpaln.refid_shop;
					
					$("#id_shop").val(obj.datafloorpaln.refid_shop);
					setdataoption();

				},
				error:function(){
					alert('error');
				}
			});
	    });
	});

	function readURL1(input) {
		if (input.files && input.files[0]) {
			
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#image_gallery')
					.attr('src', e.target.result);
			};

			reader.readAsDataURL(input.files[0]);
			ImageTitle();
		}
	}
</script>



<script>

function setdataoption(){
	var dataoption = $('#id_shop').val();
	if(dataoption !=""){
		$.get('{!! url("opctionshop/find") !!}',{'optionselect':dataoption},function(data){
			$(data).each(function(index,val){
				$('#idshop').val(val["id"]);
				$('#name_shop').val(val["name"]);
				$('#phone_shop').val(val["phone"]);
				$('#time_shop').val(val["time"]);
				
				$("#image_gallery").attr('src',"");
				$("#image_gallery").attr('src',"{{asset('manage/images/TitleShopping')}}/"+val["pictures"]);
			});
		});
	}
}
</script>