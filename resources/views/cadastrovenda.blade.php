@extends('dashboard',['titulo'=>'cadastrar Cliente','active'=>'vendas'])

@section('formulario')

	<h2 class='card-title'>Cadastrar Venda</h2>
	
	<form class="vendaform" style='margin:auto; font-size:12pt;'action='cadastrandovenda'  method="post">
		{{ csrf_field() }}
		@if(count($clientes)==0 || count($modelos)==0)
		<?php die('<h1>Ação impossível</h1> é necessario ao menos 1 cliente e 1 modelo cadastrados <a href="dashboard">voltar</a>') ?>
		@endif
		
		<label>
			Cliente
		<select name='cliente' class='form-control'>
			@foreach($clientes as $cliente)
				<option value='{{$cliente->id}}'>{{ucfirst($cliente->nome)}}</option>
			@endforeach
		</select>
		</label>

		<label>
			Modelo
		<select name='modelo' class='form-control'>			
			@foreach($modelos as $modelo)
				<option value='{{$modelo->id}}'>{{$modelo->nome}} / R${{$modelo->preco}} / {{$modelo->marca}}</option>
			@endforeach
		</select>
		</label>

		<input type="hidden" name="_method" value='post'>
		<input type="submit" value='enviar' class='btn btn-primary' style='height:50px;'>

		@if($errors->any())
			@foreach($erros->all() as $error)
				<div class='alert alert-danger'>{{$error}}</div>
			@endforeach
		@endif
	</form>
	<script type="text/javascript">
		$("input").addClass("form-control");
		$("select").css({"font-size":'12pt',height:'30px'});
	</script>
@endsection