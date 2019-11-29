<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="{{ Protocol::home() }}/application/public/uploads/settings/favicon/favicon.png">
	<title>Verify Purchase</title>

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

					<form action="{{ Protocol::home() }}/install/verify" method="POST">
					
						{{ csrf_field() }}	

						<div class="panel panel-body login-form" style="width: 60%;">
							<div class="text-center">
								<div class="icon-object border-grey-400 text-grey-400"><i class="icon-checkmark3"></i></div>
								<h5 class="content-group-lg">Verify purchase <small class="display-block">Enter your purchase code below</small></h5>
							</div>

							<!-- Purchase Code -->
							<div class="form-group has-feedback has-feedback-left {{ $errors->has('code') ? 'has-error' : '' }}">
								<input type="text" class="form-control" placeholder="Your purchase code here" name="code">
								<div class="form-control-feedback">
									<i class="icon-barcode2 text-muted"></i>
								</div>
								@if ($errors->has('code'))
								<span class="help-block">{{ $errors->first('code') }}</span>
								@endif
							</div>

							<!-- Domain url -->
							<div class="form-group has-feedback has-feedback-left {{ $errors->has('domain') ? 'has-error' : '' }}">
								<input type="text" class="form-control" placeholder="Your domain here" name="domain" value="{{ Protocol::home() }}" readonly="">
								<div class="form-control-feedback">
									<i class="icon-link text-muted"></i>
								</div>
								@if ($errors->has('domain'))
								<span class="help-block">{{ $errors->first('domain') }}</span>
								@endif
							</div>

							<!-- Envato username -->
							<div class="form-group has-feedback has-feedback-left {{ $errors->has('username') ? 'has-error' : '' }}">
								<input type="text" class="form-control" placeholder="Your Envato username here" name="username">
								<div class="form-control-feedback">
									<i class="icon-user-tie text-muted"></i>
								</div>
								@if ($errors->has('username'))
								<span class="help-block">{{ $errors->first('username') }}</span>
								@endif
							</div>

							<!-- Terms -->
							<div class="form-group">
								<div style="border: 1px solid #e5e5e5; height: 200px; overflow: auto; padding: 10px;">
									<p class="text-muted text-uppercase">Welcome to EVEREST script rules section. First, Thank you so much for purchasing our product and for being one of our loyal customers. <b>You are awesome!</b>.<br></p>
									<ul>
										<li class="text-muted">- Your purchase code is unique and can't be shared. We are doing our best to fight nulled versions.</li>
										<li class="text-muted mt-10">- Your details above will be sent to our servers to <b>ONLY</b> verify your purchase. We don't track your website or do anything like that.</li>
										<li class="text-muted mt-10">- <u>12/08/2017</u>  We no longer accept refunds, we are providing the best, fast support and high quality.</li>
										<li class="text-muted mt-10">- Regular License is valid for only one domain.</li>
									</ul>
								</div>
								<span class="help-block">Please read these terms and conditions carefully before continuing</span>
							</div>

							<div class="form-group login-options">
								<div class="row">
									<div class="col-sm-12">
										<label class="checkbox-inline text-grey-400 {{ $errors->has('terms') ? 'has-error' : '' }}">
											<input name="terms" type="checkbox" class="control-primary">
											I have read and agree to the terms and conditions
										</label>
										@if ($errors->has('terms'))
										<span class="help-block">{{ $errors->first('terms') }}</span>
										@endif
									</div>
								</div>
							</div>

							<div class="form-group">
								<button type="submit" class="btn bg-default btn-block">Verify</button>
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
