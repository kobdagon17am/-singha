<style type="text/css">
	.main-section{
		margin:0 auto;
		padding: 20px;
		margin-top: 20px;
		background-color: #fff;
		box-shadow: 0px 0px 10px #c1c1c1;
	}
		.fileinput-remove,
		.fileinput-upload{
		display: none;
	}
</style>



					<div class="row">
						<div class="col-md-2"></div>
						<div class="col-lg-8 col-sm-8 col-12 main-section">
							<label>เพิ่มรูปภาพโลโก้แบนเนอร์  (สูงสุดครั้งละ8รูป) :</label>
							<div class="form-group">
								<div class="file-loading">
									<input id="gallery" type="file" name="gallery[]" multiple class="file" onchange="ModalSize()" required>
								</div>
							</div>
						</div>
					</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" type="text/javascript"></script>

<link rel="stylesheet" href="{{asset('manage/css/uploadfile/fileinput.css')}}">
<script src="{{asset('manage/js/uploadfile/fileinput.js')}}"></script>


<script type="text/javascript">
	$("#gallery").fileinput({
		theme: 'fa',
	//	uploadUrl: "#",
		allowedFileExtensions: ['jpg', 'png', 'gif'],
		overwriteInitial: false,
		maxFilesNum: 10,
		slugCallback: function (filename) {
		  return filename.replace('(', '_').replace(']', '_');
		}
	});
</script>