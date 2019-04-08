@extends('dashboard',['titulo'=>'Cliente','active'=>'clientes'])

@section('formulario')

		<h2>Cadastrar Cliente</h2>
	<form class="card clienteform" method='POST' @if(isset($cliente)) action="editandocliente" @else action='cadastrandocliente' @endif>

		@if(isset($cliente))
			<input type="hidden" name="id" value='{{$cliente->id}}'>
		@endif
	<div class="form-group">
		<fieldset>
			<legend>informações pessoais</legend>
			<label>	
				nome
				<input type="text" name="nome" @if(isset($cliente)) value='{{$cliente->nome}}' @endif
				@if($errors->has('nome')) class='is-invalid' @endif>
			</label>	

			<label>	
				idade
				<input type="number" name="idade" @if(isset($cliente)) value='{{$cliente->idade}}'  @else value='' @endif>
			</label>		

			<label>	
				Telefone
				<input type="text" name="telefone" @if(isset($cliente)) value='{{$cliente->telefone}}'  @else value='(21) ' @endif>
			</label>		
		</fieldset>
	</div>

	<div class="form-group">
		<fieldset>
			<legend>Graus°</legend>
		<blockquote style='display:inline-block; font-size:8pt;'>esquerdo<br>direito</blockquote>
		<label>
		<legend>miopia</legend>	
		@if(isset($cliente))
			<?php 
				$miop=explode('/',$cliente->miop);

				$miope=$miop[0];
				$miopd=$miop[1];
			?>
		@endif
			<input type="text" name="miope" placeholder="esq" @if(isset($cliente)) value='{{$miope}}' @else value='0' @endif data-mask='09,99'>
			<input type="text" name="miopd" placeholder="dir" @if(isset($cliente)) value='{{$miopd}}' @else value='0' @endif data-mask='09,99'>
		</label>	

		<label>	
			<legend>hipermetropia</legend>
			@if(isset($cliente))
			<?php 
				$hipe=explode('/',$cliente->hipe);
				$hipee=$hipe[0]; 
				$hiped=$hipe[1]; 
			?>
			@endif
			<input type="text" name="hipee" placeholder="esq" @if(isset($cliente)) value='{{$hipee}}' @else value='0' @endif data-mask='09,99'> 
			<input type="text" name="hiped" placeholder="dir" @if(isset($cliente)) value='{{$hiped}}' @else value='0' @endif data-mask='09,99'>
		</label>	

		<label>	
			<legend>astigmatismo</legend>
			@if(isset($cliente))
			<?php 
				$asti=explode('/',$cliente->asti);
				$astie=$asti[0];
				$astid=$asti[1];
			?>
			@endif
			<input type="text" name="astie" placeholder="esq" @if(isset($cliente)) value='{{$astie}}' @else value='0' @endif data-mask='09,99'>
			<input type="text" name="astid" placeholder="dir" @if(isset($cliente)) value='{{$astid}}' @else value='0' @endif data-mask='09,99'>
		</label>	

		<label>	
			<legend>presbiopia</legend>
			
			@if(isset($cliente))
			<?php 
				$pres=explode('/',$cliente->pres);
				$prese=$pres[0]; 
				$presd=$pres[1]; 
			?>
			@endif

			<input type="text" name="prese" placeholder="esq" @if(isset($cliente)) value='{{$prese}}' @else value='0'  @endif data-mask='09,99'>
			<input type="text" name="presd" placeholder="dir" @if(isset($cliente)) value='{{$presd}}' @else value='0' @endif data-mask='09,99'>
		</label>
		<input type="hidden" name="_method" value='POST'>
		</fieldset>


		<blockquote>use virgulas para numeros decimais</blockquote>
	</div>

	@if($errors->any())
		@foreach($errors->all() as $error)
			<div class='alert alert-danger'>{{$error}}</div>
		@endforeach
	@endif
		<input type="submit" style='height:50px;'  class='btn btn-primary'@if(isset($cliente)) value='salvar' @else value='enviar' @endif>
		{{ csrf_field() }}
	</form>

	<script>
		//$(".clienteform input[type:number]").addClass('w-25');
		$(".clienteform input").addClass('form-control');
	</script>
@endsection