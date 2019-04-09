@extends('dashboard', ['titulo'=>'clientes','active'=>'clientes'])
@section('dashboard')
<?php 
class idade{
	public $nascimento;

	function __construct($nascimento){
		$this->nascimento=$nascimento;
	}

	public function calculo_idade() {
	    //Data atual
	    $dia = date('dd');
	    $mes = date('mm');
	    $ano = date('Y');
	    //Data do aniversário
	    $nascimento = explode('-', $this->nascimento);
		
		$anonasc = ($nascimento[0]);
	    $dianasc = ($nascimento[1]);
	    $mesnasc = ($nascimento[2]);
		
	    //Calculando sua idade
	    $idade = $ano - $anonasc; // simples, ano -  nascimento!
	    if ($mes < $mesnasc) // se o mes é menor, só subtrair da idade
	    {
	        $idade--;
	        return $idade;
	    }
	    elseif ($mes == $mesnasc && $dia <= $dianasc) // se esta no mes do aniversario mas não passou ou chegou a data, subtrai da idade
	    {
	        $idade--;
	        return $idade;
	    }
	    else // ja fez aniversario no ano, tudo certo!
	    {
	        return $idade;
	    }
	}
}
?>


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
				<?php $nascimento = new idade($cliente->nascimento); ?>
				<td><b>{{ucfirst($cliente->nome)}}</b></td>
				<td>{{$nascimento->calculo_idade()}}</td>
				<td>{{$cliente->telefone}}</td>
				<td>{{$cliente->miop}}</td>
				<td>{{$cliente->asti}}</td>
				<td>{{$cliente->hipe}}</td>
				<td>{{$cliente->pres}}</td>

			<td>	
				<button class='btn btn-primary btn-sm' onclick='edit({{$cliente->id}})'>	
					<img src="{{asset('images/svg/pencil.svg')}}">
				</button>
				<button class='btn btn-danger btn-sm' onclick='confirmRemove({{$cliente->id}})'>
					<img src="images/svg/trashcan.svg">
				</button>			
			</td>	
			</tr>
	@endforeach
	</table>

</div>

	<span style='padding:20px'>
		<a href="{{route('cad.cliente')}}" class='btn btn-success'style='font-size:12pt;'>Cadastrar novo cliente</a>
	</span>
	<span style='padding:20px' onclick='salvaPlanilha()'>
		<a class='btn btn-primary'style='font-size:12pt; color:white;'>Salvar Planilha</a>
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
