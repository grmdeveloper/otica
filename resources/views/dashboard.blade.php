<!DOCTYPE html>
<html>
<head>
	<title>{{$titulo}}</title>
	<meta charset="utf-8">
	<meta name='csrf-token' content='{{ csrf_token() }}'>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
	
	<link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">



</head>
<body style='text-align: center;'>


@component('navbar',['active'=>$active])
@endcomponent
<br>
@hasSection("dashboard")
	@yield('dashboard')
@endif

@hasSection("formulario")
	<div class='card w-75' style='margin:auto'>
	@yield('formulario')
	</div>
@endif





<script type="text/javascript">
	$('input').addClass('form-control');
	$('.glyphicon-remove').removeClass('glyphicon-remove').addClass('glyphicon-ban-circle');
</script>

</html>