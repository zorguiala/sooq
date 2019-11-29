<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="{{ Protocol::home() }}/application/public/uploads/settings/favicon/favicon.png">
	<title>Finish Installation</title>

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

					<form action="{{ Protocol::home() }}/install/finish" method="POST">
					
						{{ csrf_field() }}	

						<div class="panel panel-body login-form" style="width: 60%;">
							<div class="text-center">
								<div class="icon-object border-grey-400 text-grey-400"><i class="icon-switch"></i></div>
								<h5 class="content-group-lg">Finish Installation</h5>
							</div>

							<blockquote class="mb-20">
								All installation files will be deleted
								<footer>Please read documentation file for more security</footer>
							</blockquote>

							<blockquote class="mb-20">
								You will be logged in and redirect to home page
								<footer><a href="{{ Protocol::home() }}/dashboard">Dashboard</a></footer>
							</blockquote>

							<div class="form-group">
								<button type="submit" class="btn bg-default btn-block">Finish Installation</button>
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
