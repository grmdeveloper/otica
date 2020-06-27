@extends('dashboard',['titulo'=>'cadastrar Cliente','active'=>'vendas'])

@section('formulario')

	<h2 class='card-title'>Cadastrar Venda</h2>
		@if( count($clientes)==0 || count($modelos)==0 )
			<span class="alert alert-danger">	
				é necessario ao menos 1 cliente e 1 modelo cadastrados 
			</span>	
		@endif

	<form class="vendaform" action='cadastrandovenda'  method="post">
		{{ csrf_field() }}

		<label>
			Cliente
		<select name='cliente' required>
			<option value='' selected>selecione</option>
			@foreach($clientes as $cliente)
				<option value='{{$cliente->id}}'>{{ucfirst($cliente->nome)}}</option>
			@endforeach
		</select>
		</label>

		<fieldset class='produtos'>
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
		
		<span class="btn btn-primary createModel">	
			Add produto 
		</span>

		<input type="hidden" name="_method" value='post'>

		@if($errors->any())
			@foreach($erros->all() as $error)
				<div class='alert alert-danger'>{{$error}}</div>
			@endforeach
		@endif

		<fieldset class='parcelas card mt-5 p-5' disabled>

		Total R$<input 
		type='text'	
		name='precofinal' 
		id='precofinal'	
		class='alert alert-primary'
		style='text-align:center;'
		disabled>
		
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

			<div id='calc-desconto' class='d-flex' style='justify-content: space-around; padding:0 20%;'>				
				<label>
					desconto %
					<input type="number" 
					name="desconto" 
					onchange='calcula_desconto()' 
					class='' value=0 min='0' max='15'>
				</label>

				<label>
					Valor com desconto
					<input type="text" name="preco_desconto" disabled>
				</label>
			</div>
			<input type="submit" class='mt-4 btn btn-success' value='salvar'>
		</fieldset>	
	</form>



<script type="text/javascript">

	$(function(){
		$("input").addClass("form-control");
		$('select')
			.addClass('form-control')
			.select2();

		$('.createModel').click(function(){
			var qnt=$(".produtos label").length;
			var prodqnt=$(".prod"+qnt).length;

			while(prodqnt>0){
				qnt++;
				prodqnt=$(".prod"+qnt).length;
			}

			$('.produtos').append("<label class='m-2 w-25 prod"+qnt+"'>Produto "+(qnt+1)+" <select class='form-control' onchange='calcula()' name='modelo[]'> <option value=''>selecione</option>@foreach($modelos as $modelo)		<option value='{{$modelo->id}}' onclick='setpreco("+qnt+",{{$modelo->id}})' >	{{$modelo->nome}} - {{$modelo->marca}}		</option>		@endforeach	</select>	<input type='text' name='preco[]' class='preco"+qnt+"' disabled hidden> <input type='text' name='custo[]' class='custo"+qnt+"' disabled hidden> <span class='btn btn-danger btn-block' onclick='removeitem("+qnt+"); calcula()'>remover</span></label>");

			$(".parcelas").attr('disabled',true);
		})
	});


	var setpreco = function(x,id){
		var get = "{{ url('getmodelo') }}";
		$.ajax({
			url:get+"/"+id,
			success:function(data){
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

				$(".parcelas")
					.attr('disabled',false);

				calcula_desconto();
			}
		});
	}

	var calcula_desconto = function(){
		let perc = $('input[name=desconto]').val();
		let preco = $('input[name=precofinal]').val();
		let precodesconto = preco - preco*(perc/100); 
		$('input[name=preco_desconto').val("R$ "+precodesconto);
	}

	var removeitem = function(x){
		$('.prod'+x).remove();
	}

</script>
@endsection