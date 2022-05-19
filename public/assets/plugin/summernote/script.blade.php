<textarea rows="7" cols="3" name="detail_th" id="detail_th" class="form-control" placeholder="Enter your message here"></textarea>
<textarea rows="7" cols="3" name="detail_en" id="detail_en" class="form-control" placeholder="Enter your message here"></textarea>


<link type="text/css" rel="stylesheet" href="{{asset('manage/summernote/summernote-lite.css')}}">
<script type="text/javascript" src="{{asset('manage/summernote/summernote-lite.js')}}"></script>


<script type="text/javascript">
$( document ).ready(function() {
	$('#detail_th').summernote({});
	$('#detail_en').summernote({});		
}); 
</script>