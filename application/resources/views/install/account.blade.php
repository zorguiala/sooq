<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="{{ Protocol::home() }}/application/public/uploads/settings/favicon/favicon.png">
	<title>Create Account</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ Protocol::home() }}/content/assets/front-end/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="{{ Protocol::home() }}/content/assets/front-end/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="{{ Protocol::home() }}/content/assets/front-end/css/core.css" rel="stylesheet" type="text/css">
	<link href="{{ Protocol::home() }}/content/assets/front-end/css/components.css" rel="stylesheet" type="text/css">
	<link href="{{ Protocol::home() }}/content/assets/front-end/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/core/libraries/bootstrap.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/core/app.js"></script>
	<!-- /theme JS files -->

</head>

<body class="login-container" style="background-color: #ECEDED">

	<div class="page-container">

		<div class="page-content">

			<div class="content-wrapper">

				<div class="content">

					@if (Session::has('error'))
			        <div class="alert bg-danger alert-styled-left" style="width: 60%;margin: 20px auto;">
			            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
			            {{ Session::get('error') }}
			        </div>
			        @endif

			        @if (Session::has('success'))
			        <div class="alert bg-success alert-styled-left" style="width: 60%;margin: 20px auto;">
			            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
			            {{ Session::get('success') }}
			        </div>
			        @endif

					<form action="{{ Protocol::home() }}/install/account" method="POST">
					
						{{ csrf_field() }}	

						<div class="panel panel-body login-form" style="width: 60%;">
							<div class="text-center">
								<div class="icon-object border-grey-400 text-grey-400"><i class="icon-user-plus"></i></div>
								<h5 class="content-group-lg">Create Account</h5>
							</div>

							<div class="form-group has-feedback has-feedback-left {{ $errors->has('fname') ? 'has-error' : '' }}">
								<input type="text" class="form-control" placeholder="Your first name" name="fname">
								<div class="form-control-feedback">
									<i class="icon-address-book text-muted"></i>
								</div>
								@if ($errors->has('fname'))
								<span class="help-block">{{ $errors->first('fname') }}</span>
								@endif
							</div>

							<div class="form-group has-feedback has-feedback-left {{ $errors->has('lname') ? 'has-error' : '' }}">
								<input type="text" class="form-control" placeholder="Your last name" name="lname">
								<div class="form-control-feedback">
									<i class="icon-address-book text-muted"></i>
								</div>
								@if ($errors->has('lname'))
								<span class="help-block">{{ $errors->first('lname') }}</span>
								@endif
							</div>

							<div class="form-group has-feedback has-feedback-left {{ $errors->has('username') ? 'has-error' : '' }}">
								<input type="text" class="form-control" placeholder="Your username" name="username">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
								@if ($errors->has('username'))
								<span class="help-block">{{ $errors->first('username') }}</span>
								@endif
							</div>

							<div class="form-group has-feedback has-feedback-left {{ $errors->has('email') ? 'has-error' : '' }}">
								<input type="email" class="form-control" placeholder="Your e-mail address" name="email">
								<div class="form-control-feedback">
									<i class="icon-envelop5 text-muted"></i>
								</div>
								@if ($errors->has('email'))
								<span class="help-block">{{ $errors->first('email') }}</span>
								@endif
							</div>

							<div class="form-group has-feedback has-feedback-left {{ $errors->has('password') ? 'has-error' : '' }}">
								<input type="password" class="form-control" placeholder="Your password" name="password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
								@if ($errors->has('password'))
								<span class="help-block">{{ $errors->first('password') }}</span>
								@endif
							</div>

							<div class="form-group has-feedback has-feedback-left {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
								<input type="password" class="form-control" placeholder="Confirm your password" name="password_confirmation">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
								@if ($errors->has('password_confirmation'))
								<span class="help-block">{{ $errors->first('password_confirmation') }}</span>
								@endif
							</div>

							<div class="form-group">
								<button type="submit" class="btn bg-default btn-block">Continue</button>
							</div>

						</div>
					</form>

				</div>

			</div>

		</div>

	</div>


	<script type="text/javascript" src="{{ Protocol::home() }}/content/assets/front-end/js/plugins/ui/ripple.min.js"></script>
	<script type="text/javascript">
	    // Primary
	    $(".control-primary").uniform({
	        radioClass: 'choice',
	        wrapperClass: 'border-grey-400 text-grey-400'
	    });
	</script>

</body>
</html>
