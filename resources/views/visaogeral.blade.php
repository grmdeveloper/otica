@extends('dashboard',['titulo'=>'Dashboard','active'=>'visaoGeral'])

	@section('dashboard')
	<h2>Dashboard</h2>
	<div class='alert alert-primary'>Bem vindo de volta</div>


	<div class='w-50 card' style='margin:auto;'>
			@if(count($modelos)>0)
			<span class="card">Produtos em estoque
				<b class="badge badge-warning">
					@foreach($modelos as $md)
					<?php 
						if(!isset($estoque)) $estoque=0;
						$estoque+=$md->estoque;
					?>
					@endforeach
					{{$estoque}}
				</b>
			</span>
			<span class="card">Faturamento esperado
				<b class="badge badge-warning">
					@foreach($modelos as $md)
					<?php 
						if(!isset($ft0)) $ft0=0;
						$ft0+=($md->preco)*$md->estoque;
					?>
					@endforeach
					R${{$ft0}}
				</b>
			</span>		
			<span class="card">Lucro esperado
				<b class="badge badge-warning">
					@foreach($modelos as $md)
					<?php 
						if(!isset($lc0)) $lc0=0;
						$lc0+=($md->preco-$md->custo)*$md->estoque;
					?>
					@endforeach
					R${{$lc0}}
				</b>
			</span>
		@endif
	</div>

		<hr>
		
	<div class='w-50' style='margin:auto; text-align:center;'>	

	<form action='{{route("pagina.geral.set")}}' method='post'>
			<legend class='badge badge-secundary'>Resultado por periodo</legend>
			{{ csrf_field() }}
			<label>
				inicio
				<input type="date" name="data" class='form-control'>
			</label>

			<label>
				fim
				<input type="date" name="data1" class='form-control'>
			</label>

			<input type="hidden" name="_method" value="post">
			<input type="submit" name="" value='mostrar'>
		</form>


	@if(count($compras)==0 && count($modelos)==0 && count($clientes)==0)
	<h2>Nenhum dado disponivel</h2>


			<span class="badge">?</span> primeiros passos <br>
			<ol style='list-style:upper-roman;'>
				<li>Cadastre os modelos de armações na sessão <a href="/modelos">Modelos</a></li>
				<li>Cadastre seus clientes na sessão <a href="/clientes">Clientes</a></li>
				<li>Compute as vendas na sessão <a href="/vendas">Vendas</a></li>
			</ol>
	@else

		@if(count($clientes)>0)
			<hr>
		
			<span class='card'>Clientes cadastrados			<b class='badge badge-primary'>{{count($clientes)}}</b></span>
		@endif

		@if(count($compras)>0)
			<span class='card'>Vendas realizadas			<b class='badge badge-primary'>{{count($compras)}}</b></span>

			<span class='card'>Faturamento					<b class='badge badge-primary'>
				@foreach($compras as $compra)
					<?php 
						if(!isset($faturamento)) $faturamento=0;
						$faturamento+=$compra->preco; 
					?>
				@endforeach
				R${{$faturamento}}
			</b></span> <br>	

			<span class='card'>Lucro Gerado					<b class='badge badge-success'>
				@foreach($compras as $compra)
					<?php 
						if(!isset($lucro)) $lucro=0;
						$lucro+=$compra->preco-$compra->custo;
					?>
				@endforeach
				R${{$lucro}}
			</b></span>


			<span class='card'>Retorno sobre investimento	<b class='badge badge-success'>
				@foreach($compras as $compra)
					<?php 
						if(!isset($custo)) $custo=0;
						$custo+=$compra->custo;
					?>
				@endforeach
					{{ number_format( ($faturamento-$custo)/$custo*100 ) }}%
			</b></span><br>
		@endif

			
	@endif


	</div>

	<br>
	<a href="{{route('cad.modelo')}}" class='btn btn-primary'>Cadastrar Modelo</a>
	
	<a href="{{route('cad.cliente')}}" class='btn btn-primary'>Cadastrar Cliente</a>

	<a href="{{route('cad.venda')}}" class='btn btn-primary'
	@if(count($clientes)==0 || count($modelos)==0) 	disabled	@endif
	>Cadastrar Venda</a>

	<br><br><br>

	<style type="text/css">
		.card{
			font-size:12pt;
		}
		.badge{
			font-size:12pt;
		}
	</style>
	@endSection
