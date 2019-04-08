<!DOCTYPE html>
<html>
<head>
	<title>{{$titulo}}</title>
	<meta charset="utf-8">
	<meta name='csrf-token' content='{{ csrf_token() }}'>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
	
	<link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-glyphicons.css" rel="stylesheet">
	
	<style>
		*{font-size:12pt;}
		.btn{font-size:12pt;}
		label{font-size:12pt;}
	</style>
</head>
<body>
<div style='text-align:center;'>

@component('navbar',['active'=>$active])
@endcomponent

@hasSection("dashboard")
	@yield('dashboard')
@endif

@hasSection("formulario")
	<div class='card w-50' style='margin:auto'>
	@yield('formulario')
	</div>
@endif

<script type="text/javascript" src="js/jquery.mask.js"></script>
<script type="text/javascript">
	$('input').addClass('form-control');
	$('.glyphicon-remove').removeClass('glyphicon-remove').addClass('glyphicon-ban-circle');
</script>

<style type="text/css">
	body{
		font-family:calibri;
	}
</style>


</body>

</html>