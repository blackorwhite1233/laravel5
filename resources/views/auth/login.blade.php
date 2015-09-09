@extends('app')

@section('content')
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themepixels.com/demo/webpage/quirk/templates/signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 16 Aug 2015 06:35:39 GMT -->
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <!--<link rel="shortcut icon" href="../images/favicon.png" type="image/png">-->

  <title>Quirk Responsive Admin Templates</title>

  {!! HTML::style('admin/lib/fontawesome/css/font-awesome.css') !!}
  {!! HTML::style('admin//css/quirk.css') !!}

{!! HTML::script('admin/lib/modernizr/modernizr.js') !!}
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="../lib/html5shiv/html5shiv.js"></script>
  <script src="../lib/respond/respond.src.js"></script>
  <![endif]-->
</head>

<body class="signwrapper">

  <div class="sign-overlay"></div>
  <div class="signpanel"></div>

  <div class="panel signin">
    <div class="panel-heading">
      <h1>Quirk</h1>
      <h4 class="panel-title">Welcome! Please signin.</h4>
    </div>
    <div class="panel-body">
    	@if (count($errors) > 0)
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif
      <form method="POST" action="{!!URL::to('/auth/login')!!}">
      	<input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group mb10">
          <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input type="text" name="email" class="form-control" placeholder="Enter Username">
          </div>
        </div>
        <div class="form-group nomargin">
          <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Enter Password">
          </div>
        </div>

        <div class="form-group" style="margin-top:10px">
          <button class="btn btn-success btn-quirk btn-block">Sign In</button>
        </div>
      </form>
      <hr class="invisible">

    </div>
  </div><!-- panel -->

</body>

<!-- Mirrored from themepixels.com/demo/webpage/quirk/templates/signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 16 Aug 2015 06:35:39 GMT -->
</html>

@endsection
