Route::post('/backoffice/banner/ajaxdestroy','BannerController@banner_ajax_destroy')->name('backoffice.banner.ajaxdestroy');


	public function banner_ajax_destroy(Request $request){
		
		$mybanner = Banner::find($request->id_pictures);
		$data_choose = $mybanner->pictures_banner;
		
		$imgold = "local/storage/fileuploade/banner/".$data_choose;
		if(is_file($imgold)){
                unlink($imgold);
		}
		
		$mybanner->delete();
	
	}
	
	
function datadelete(id)
    {
		bootbox.confirm({
			title: "ยืนยัน?",
			message: "คุณต้องการลบรายการนี้ หรือไม่?",
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
					url:"{{ route('backoffice.banner.ajaxdestroy')}}",
					data:{ "_token": "{{ csrf_token() }}", 'id_pictures' : id },
					type:"POST",
					async:false,						
						success:function (data){
							//window.location.reload();
							
							$('#datatables').load(document.URL +  ' #datatables');
							
						},				
					});				
				}
			}
		});
    }	