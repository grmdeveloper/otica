@extends('dashboard',['titulo'=>'Modelos','active'=>'modelos'])

@section('dashboard')
<h2>Modelos</h2>
	<div class='card'>
			<span class='badge'>?</span> 
			cadastre os modelos de armações com as seguintes informações:

		<ul style='list-style:none;'>
			<li><b>Custo</b>: quantia em R$ de quanto custa o material para você</li>
			<li><b>Preço</b>: quantia em R$ do valor final para consumidor</li>
		</ul>
	</div>
	<br>

<div style='padding:20px'>
	
	<table  id='table' class='table table-striped'>	
		<thead>	
			<tr>
				<th>Index</th>
				<th>Nome</th>
				<th>Marca</th>
				<th>Custo</th>
				<th>Preço</th>
				<th>Estoque</th>
				<th>Opções</th>
			</tr>
		</thead>
	<tbody>
		
	@foreach($modelos as $modelo)

		<tr>
			<td>{{$modelo->id}}</td>
			<td>{{ucFirst($modelo->nome)}}</td>
			<td>{{$modelo->marca}}</td>
			<td>R${{$modelo->custo}}</td>
			<td>R${{$modelo->preco}}</td>
			
			<td width='50'>
			<form class='forme' method='post' action='addestoque'>
					{{$modelo->estoque}} 
					{{ csrf_field() }}
					<input type="number" name="estoque" class='form-control' min='1' size='2' maxlength='3' unsigned>
					<input type="hidden" name="id" 	value="{{$modelo->id}}">
					<label>
					<input type="radio" name="rm" style='display:none;'>
					<input type='submit' name='opt' value="+" class='btn btn-success btn-sm'>
					</label>

					<label>
					<input type="radio" name="add" style='display:none;'>
					<input type='submit' name='opt' value="-" class='btn btn-danger btn-sm'>
					</label>

			</form>
			</td>

			<td>
			<button class='btn btn-primary btn-sm' onclick='edit({{$modelo->id}})'>	
					<img src="{{asset('images/svg/pencil.svg')}}">
			</button>
		
			<button class='btn btn-danger btn-sm' onclick='remove({{$modelo->id}})'>	
					<img src="images/svg/trashcan.svg">
			</button>			
			</td>
		</tr>
	@endForeach
	</tbody>
	</table>
</div>
	<br>
	<br>
	
	<a class='btn btn-success' href="{{route('cad.modelo')}}" style='font-size:12pt;'>
		Cadastrar novo modelo
	</a>
	
	@if(count($modelos) > 0)
		<a class='btn btn-primary' style='font-size:12pt; color:white;' onclick='salvaPlanilha()'>
			Salvar Planilha
		</a>
	@endif

	<span class="confirmRequest card shadow-sm" style='display:none; position:absolute; top:35vh; left:30vw; padding:50px;'>
		Deseja apagar este modelo? Vendas já cadastradas não serão afetadas 
		<a href='#' onclick='remove("id")' class='btn btn-sm btn-success'> confirmar </a> 
		<a href='#' onclick='location.reload()' class='btn btn-sm btn-danger'>cancelar</a>
	</span>


<link href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>


<script type="text/javascript">

	$.ajaxSetup({
		headers: {
   	 		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var edit= 	function(id){
		location.href='editarmodelo/'+id;
	}

	var remove= function(id){
		if(confirm('Deseja apagar este modelo? vendas ja cadastradas não serão afetadas.')){
				$.ajax({
					url:'excluirmodelo/'+id,
					type:'delete',
		   			context:this,
					data: {
		          		"_token" : $('meta[name="csrf-token"]').attr('content')
		   			},
					success:function(response){
						var modelos = $('#table>tbody>tr');
						e= modelos.filter(function(i,event){
							return event.cells[0].textContent ==id;
						});
						e.remove();
					},
					error:function(data){
						console.log(data);
					},
				});
		}
	}


	$('.list-group-item').hover(function(){
		$(this).addClass('active');
	},function(){
		$(this).removeClass('active');
	});


  $(document).ready(function(){
      $('#table').DataTable({
          "language": {
                "lengthMenu": "Mostrando _MENU_ registros por página",
                "zeroRecords": "Nada encontrado",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(filtrado de _MAX_ registros no total)"
            }
        });


  });

  function salvaPlanilha() {
    var htmlPlanilha = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>PlanilhaModelos</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>' + document.getElementById("table").innerHTML + '</table></body></html>';
 
    var htmlBase64 = btoa(htmlPlanilha);
    var link = "data:application/vnd.ms-excel;base64," + htmlBase64;
 
    var hyperlink = document.createElement("a");
    hyperlink.download = "PlanilhaModelos";
    hyperlink.href = link;
    hyperlink.style.display = 'none';
 
    document.body.appendChild(hyperlink);
    hyperlink.click();
    document.body.removeChild(hyperlink);
}

</script>
@endsection