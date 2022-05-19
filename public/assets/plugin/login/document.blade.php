<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login Backoffice</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{asset('myplugin/login/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('myplugin/login/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('myplugin/login/css/core.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('myplugin/login/css/components.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('myplugin/login/css/colors.css')}}" rel="stylesheet" type="text/css">
	<link rel="icon" href="{{URL::asset('bootstrap4/assets/images/favicon.ico')}}" type="image/x-icon"> <!-- Logo -->
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="{{asset('myplugin/login/js/plugins/loaders/pace.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('myplugin/login/js/core/libraries/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('myplugin/login/js/core/libraries/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('myplugin/login/js/plugins/loaders/blockui.min.js')}}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="{{asset('manage/js/plugins/forms/styling/uniform.min.js')}}"></script>

	<script type="text/javascript" src="{{asset('manage/js/core/app.js')}}"></script>
	<script type="text/javascript" src="{{asset('manage/js/pages/login.js')}}"></script>
	<!-- /theme JS files -->

</head>

<body class="login-container login-cover">

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content pb-20">

					<!-- Tabbed form -->
					<div class="tabbable panel login-form width-400">
						<ul class="nav nav-tabs nav-justified">
							<li class="active"><a href="#basic-tab1" data-toggle="tab"><h6>Sign in</h6></a></li>
						</ul>

						<div class="tab-content panel-body">
							<div class="tab-pane fade in active" id="basic-tab1">
								<form class="form-horizontal" method="POST" action="{{ route('login') }}">
									{{ csrf_field() }}
									<div class="text-center">
										<div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
										<h5 class="content-group">Login to your account <small class="display-block">Your credentials</small></h5>
									</div>

									<div class="form-group has-feedback has-feedback-left {{ $errors->has('email') ? ' has-error' : '' }}">
										<input id="email" type="text" class="form-control" name="email" placeholder="Username" value="{{ old('email') }}" required autofocus>
										@if ($errors->has('email'))
											<span class="help-block">
												<strong>{{ $errors->first('email') }}</strong>
											</span>
										@endif
										<div class="form-control-feedback">
											<i class="icon-user text-muted"></i>
										</div>
									</div>

									<div class="form-group has-feedback has-feedback-left {{ $errors->has('password') ? ' has-error' : '' }}">
										<input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

										@if ($errors->has('password'))
											<span class="help-block">
												<strong>{{ $errors->first('password') }}</strong>
											</span>
										@endif
										
										<div class="form-control-feedback">
											<i class="icon-lock2 text-muted"></i>
										</div>
									</div>
									<div class="form-group">
										<button type="submit" class="btn bg-blue btn-block">Login <i class="icon-arrow-right14 position-right"></i></button>
									</div>
								</form>



								<span class="help-block text-center no-margin">By continuing, you're confirming that you've read our <a href="#">Terms &amp; Conditions</a> and <a href="#">Cookie Policy</a></span>
							</div>
						</div>
					</div>
					<!-- /tabbed form -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
</html>
