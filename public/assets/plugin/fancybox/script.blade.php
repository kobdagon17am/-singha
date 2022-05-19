
<a class="btn btn-defaultlink fancyboxart fancybox.iframe" href="#"><button type="button" class="btn btn-success"><i class="fa fa-search"></i> เรียกดูไฟล์แนบ</button></a>

<!-- Fancybox -->
<script type="text/javascript" src="{{asset('manage/fancybox/lib/jquery.mousewheel-3.0.6.pack.js')}}"></script>
<script type="text/javascript" src="{{asset('manage/fancybox/source/jquery.fancybox.js?v=2.1.5')}}"></script>
<link href="{{asset('manage/fancybox/source/jquery.fancybox.css?v=2.1.5')}}" rel="stylesheet" type="text/css" media="screen">
<link href="{{asset('manage/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5')}}" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{{asset('manage/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5')}}"></script>
<link href="{{asset('manage/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7')}}" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{{asset('manage/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7')}}"></script>
<script type="text/javascript" src="{{asset('manage/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6')}}"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('.fancyboxart').fancybox({
			openEffect: 'elastic',
			closeEffect: 'elastic',
			prevEffect: 'none',
			nextEffect: 'none',
			width: '100%',
			maxWidth: '900',
			height: '80%',
			autoScale: false,
			autoSize: false,
			type: 'iframe'
		});
	});

</script>