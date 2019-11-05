@extends('dashboard',['titulo'=>'cadastrar Cliente','active'=>'vendas'])

@section('formulario')
	<script type="text/javascript">
	$(function(){

		$("input").addClass("form-control");
		$("select").css({"font-size":'12pt',height:'30px'});

		$('.createModel').click(function(){
			var qnt=$(".produtos label").length;
			console.log(qnt);
			var prodqnt=$(".prod"+qnt).length;

			while(prodqnt>0){
				qnt++;
				prodqnt=$(".prod"+qnt).length;
			}

			$('.produtos').append("<label class='prod"+qnt+"'>Produto "+qnt+" <select onchange='calcula()' name='modelo[]'> <option value=''>selecione</option>@foreach($modelos as $modelo)		<option value='{{$modelo->id}}' onclick='setpreco("+qnt+",{{$modelo->id}})' >	{{$modelo->nome}} - {{$modelo->marca}}		</option>		@endforeach	</select>	<input type='text' name='preco[]' class='preco"+qnt+"' disabled hidden> <input type='text' name='custo[]' class='custo"+qnt+"' disabled hidden> <span class='btn btn-danger' onclick='removeitem("+qnt+"); calcula()'>x</span></label>");

			$(".parcelas").fadeOut();
		})





	});
	</script>


	<h2 class='card-title'>Cadastrar Venda</h2>
	
	<form class="vendaform" style='margin:auto; font-size:12pt;'action='cadastrandovenda'  method="post">
		{{ csrf_field() }}
		@if(count($clientes)==0 || count($modelos)==0)
		<?php die('<h1>Ação impossível</h1> é necessario ao menos 1 cliente e 1 modelo cadastrados <a href="dashboard">voltar</a>') ?>
		@endif

		<label>
			Cliente
		<select name='cliente' required>
			<option value='' selected>selecione</option>
			@foreach($clientes as $cliente)
				<option value='{{$cliente->id}}'>{{ucfirst($cliente->nome)}}</option>
			@endforeach
		</select>
		</label>
		<br>

		<fieldset class='card produtos'>
			<label>
				Produto
				<select name='modelo[]'	class='modelo' onchange='calcula()'>
					<option value='' selected>selecione</option>
					@foreach($modelos as $modelo)
					<option value='{{$modelo->id}}'	onclick='setpreco(0,{{$modelo->id}})'>
						{{$modelo->nome}} - {{$modelo->marca}}
					</option>
					@endforeach
				</select>
				<input type="text" name="preco[]" class='preco0' hidden disabled>
				<input type="text" name="custo[]" class='custo0' disabled hidden>
			</label>
		<br>

		</fieldset>
		
		<span class="btn btn-primary createModel">	Add produto 
		</span>

		<input type="hidden" name="_method" value='post'>

		@if($errors->any())
			@foreach($erros->all() as $error)
				<div class='alert alert-danger'>{{$error}}</div>
			@endforeach
		@endif

		<fieldset class='parcelas card' style='display:none;'>

		Total R$<input 
		type='text'	
		name='precofinal' 
		id='precofinal'	
		class='alert alert-primary'
		style='text-align:center;'>

		<input type='text' 
		name='custofinal' 
		id='custofinal' 
		hidden>
		
		<label>
			Forma de pagamento
			<select name='pagamento'>
					<option selected>Dinheiro</option>
					<option>Cheque</option>
					<option value='Crédito'>Cartão de Crédito</option>
					<option value='Débito'>Cartão de Débito</option>
			</select>
		</label>

			<label>
				Parcelas
				<select name='parcelas'>
					<option value='1' selected>1x</option>
					<option value='2'>2x</option>
					<option value='3'>3x</option>
					<option value='4'>4x</option>
					<option value='5'>5x</option>
					<option value='6'>6x</option>
				</select>
			</label>
			<input type="submit" class='btn btn-success' value='enviar'>
		</fieldset>	
	</form>
<script type="text/javascript">
		var setpreco = function(x,id){
			var get = "{{ url('getmodelo') }}";
			$.ajax({
				url:get+"/"+id,
				success:function(data){
					console.log('.preco'+data.id);
					$('.preco'+x).val("R$"+data.preco);
					$('.custo'+x).val("R$"+data.custo);
				}
			});
		}

		var calcula = function(){
			event.preventDefault();
			var dados=$('.vendaform').serialize();
			var calculo = "{{url('calculo')}}";
			$.ajax({
				url:calculo,
				method:'post',
				data:dados,
				success:function(data){
					
					$("#precofinal").val(data.precoTot);
					$("#custofinal").val(data.custoTot);

					$('.parcelas').fadeIn();
				}
			});
		}

		var removeitem = function(x){
			$('.prod'+x).remove();
		}


</script>
@endsection