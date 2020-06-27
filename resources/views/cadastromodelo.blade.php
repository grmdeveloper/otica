@extends('dashboard',['titulo'=>'Cadastrar Modelo','active'=>'modelos'])

@section('formulario')
		<h2>Cadastrar Produto</h2>
	<form class="card modeloform" method='post' @if(isset($modelo)) action='/editandomodelo' @else action='cadastrandomodelo' @endif>
		{{ csrf_field() }}
		<div class="form-group">
			<fieldset>
			<legend>informações</legend>
				<label>
					Nome (modelo)
					<input type="text" class="{{$errors->has('nome')?'is-invalid':''}}"  name="nome" @if(isset($modelo)) value='{{$modelo->nome}}' 
					@endif>
				</label>

				<label>
					Marca (produtor)
					<input type="text" class="{{$errors->has('marca')?'is-invalid':''}}"  name="marca" @if(isset($modelo)) value='{{$modelo->marca}}' 
					@endif>
				</label>
			</fieldset>

			<br>
			<fieldset>
				<legend>Valores R$</legend>
				<label>	
					Custo
					<input type="number"  class="{{$errors->has('custo')?'is-invalid':''}}" name="custo" @if(isset($modelo)) value='{{$modelo->custo}}' @endif>
				</label>

				<label>	
					Preço
					<input type="number"  class="{{$errors->has('preco')?'is-invalid':''}}" name="preco" @if(isset($modelo)) value='{{$modelo->preco}}' @endif>
				</label>
			</fieldset>
			<br>
			<fieldset>
				<legend>peças em estoque</legend>
				<label>	
					Estoque
					<input type="number" name="estoque" min='1' @if(isset($modelo)) value='{{$modelo->estoque}}' @endif>
				</label>
			</fieldset>
			<br>
		</div>

			<input type="hidden" name="_method" value='post'>
			@if(isset($modelo))
			<input type="hidden" name="id" value='{{$modelo->id}}'>
			@endif

			<input type="submit" value='enviar' style='height:40px;' class='btn btn-block btn-primary'>

			@if($errors->any())
			@foreach($errors->all() as $error)
				<div class='alert alert-danger'>{{$error}}</div>
			@endforeach
		@endif
	</form>

	<style type="text/css">
		label{
			font-size:12pt;
		}
	</style>
	<script>

		$("input").addClass('form-control');
	</script>
@endsection