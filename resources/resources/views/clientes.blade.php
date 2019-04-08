@extends('dashboard', ['titulo'=>'clientes','active'=>'clientes'])
@section('dashboard')
	<h2>Clientes</h2>
	<br>
	<div class="card">
		<span class="badge rounded">?</span> 
		Cadastre seus clientes e suas informações ficarão disponiveis nesta sessão. É necessario cadastra-los antes de computar vendas.
	</div>
	<br>

<div style='padding:20px'>
	<table class='table table-striped' id="table"> 
		<thead>
			<tr>
				<th>Nome</th>
				<th>Idade</th>
				<th>Telefone</th>
				<th>Miopia e/d</th>
				<th>Astigmatismo e/d</th>
				<th>Hipermetropia e/d</th>
				<th>Presbiopia e/d</th>
				<th>opções</th>
			</tr>
		</thead>
	@foreach($clientes as $cliente)
			<tr>
				<td><b>{{ucfirst($cliente->nome)}}</b></td>
				<td>{{$cliente->idade}}</td>
				<td>{{$cliente->telefone}}</td>
				<td>{{$cliente->miop}}</td>
				<td>{{$cliente->asti}}</td>
				<td>{{$cliente->hipe}}</td>
				<td>{{$cliente->pres}}</td>

			<td>	
				<button class='btn btn-primary btn-sm' onclick='edit({{$cliente->id}})'>	
					<span class='glyphicon glyphicon-pencil'></span>
				</button>
				<button class='btn btn-danger btn-sm' onclick='confirmRemove({{$cliente->id}})'>
					<span class='glyphicon glyphicon-remove'></span>
				</button>			
			</td>	
			</tr>
	@endforeach
	</table>

</div>

	<span style='padding:20px'>
		<a href="cadastrarcliente" class='btn btn-primary'style='font-size:12pt;'>Cadastrar novo cliente</a>
	</span>
	<span style='padding:20px' onclick='salvaPlanilha()'>
		<a class='btn btn-success'style='font-size:12pt; color:white;'>Salvar Planilha</a>
	</span>

	<span class="confirmRequest card shadow-sm" style='display:none; position:absolute; top:35vh; left:27vw; padding:50px;'>
		
	</span>


<link href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
	var confirmRemove= function($id){
		$('.confirmRequest').html("Todas as vendas feitas a esse cliente serão excluidas, deseja prosseguir? <a href='#' onclick='remove("+$id+")' class='btn btn-sm btn-success'> confirmar </a> <a href='#' onclick='location.reload()' class='btn btn-sm btn-danger'>cancelar</a>").css('display','block');
	}
	var edit= 		function($id){
		location.href='editarcliente/'+$id;
	}
	var remove= 	function($id){
		location.href='excluircliente/'+$id;
	}


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
    var htmlPlanilha = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>PlanilhaClientes</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>' + document.getElementById("table").innerHTML + '</table></body></html>';
 
    var htmlBase64 = btoa(htmlPlanilha);
    var link = "data:application/vnd.ms-excel;base64," + htmlBase64;
 
    var hyperlink = document.createElement("a");
    hyperlink.download = "PlanilhaClientes";
    hyperlink.href = link;
    hyperlink.style.display = 'none';
 
    document.body.appendChild(hyperlink);
    hyperlink.click();
    document.body.removeChild(hyperlink);
}
</script>
@endsection
