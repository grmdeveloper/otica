<!DOCTYPE html>
<html>
<head>

	<title>{{$titulo}}</title>
	<meta charset="utf-8">
	<meta name='csrf-token' content='{{ csrf_token() }}'>
	
	<script src='{{asset("js/jquery.min.js")}}'></script>
	
	<link rel="stylesheet" type="text/css" href="{{asset('css/select2.min.css')}}">
	<script type="text/javascript" src='{{asset("js/select2.min.js")}}'></script>

	<link href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
	<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

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

<footer>
	developed by <a href="https://github.com/grmdeveloper" target='_blank'>Grmdeveloper</a> 
	<span>See this project on <a href="https://github.com/grmdeveloper/otica" target='_blank'>github</a></span>
</footer>

<script type="text/javascript">
	$('input').addClass('form-control');
	$('.glyphicon-remove').removeClass('glyphicon-remove').addClass('glyphicon-ban-circle');
</script>

</html>