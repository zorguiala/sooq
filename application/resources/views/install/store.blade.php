<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="{{ Protocol::home() }}/application/public/uploads/settings/favicon/favicon.png">
	<title>Create Store</title>

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

					<form action="{{ Protocol::home() }}/install/store" method="POST">
					
						{{ csrf_field() }}	

						<div class="panel panel-body login-form" style="width: 60%;">
							<div class="text-center">
								<div class="icon-object border-grey-400 text-grey-400"><i class="icon-store"></i></div>
								<h5 class="content-group-lg">Create Store</h5>
							</div>

							<div class="form-group has-feedback has-feedback-left {{ $errors->has('username') ? 'has-error' : '' }}">
								<input type="text" class="form-control" placeholder="Your store username" name="username">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
								@if ($errors->has('username'))
								<span class="help-block">{{ $errors->first('username') }}</span>
								@endif
							</div>

							<div class="form-group has-feedback has-feedback-left {{ $errors->has('title') ? 'has-error' : '' }}">
								<input type="text" class="form-control" placeholder="Your store title" name="title">
								<div class="form-control-feedback">
									<i class="icon-pen6 text-muted"></i>
								</div>
								@if ($errors->has('title'))
								<span class="help-block">{{ $errors->first('title') }}</span>
								@endif
							</div>

							<div class="form-group has-feedback has-feedback-left {{ $errors->has('short_desc') ? 'has-error' : '' }}">
								<input type="text" class="form-control" placeholder="Your store short description" name="short_desc">
								<div class="form-control-feedback">
									<i class="icon-keyboard text-muted"></i>
								</div>
								@if ($errors->has('short_desc'))
								<span class="help-block">{{ $errors->first('short_desc') }}</span>
								@endif
							</div>

							<div class="form-group">
								<button type="submit" class="btn bg-default btn-block">Finish</button>
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
