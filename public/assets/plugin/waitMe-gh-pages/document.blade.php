<link rel="stylesheet" href="{{asset('myplugin/waitMe-gh-pages/waitMe.css')}}">
<link rel="stylesheet" href="{{asset('myplugin/waitMe-gh-pages/waitMe.min.css')}}">	

<div id="reload"></div>

<script type="text/javascript" src="{{asset('myplugin/waitMe-gh-pages/waitMe.js')}}"></script>
<script type="text/javascript" src="{{asset('myplugin/waitMe-gh-pages/waitMe.min.js')}}"></script>

<script>
	function run_waitMe(){
		$('#reload').waitMe({
			effect: 'bounce',
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