@extends('dashboard',['titulo'=>'vendas','active'=>'vendas'])

@section('dashboard')

@if(isset($message))
	<div class='alert alert-warning'>{{$message}}</div>
@endif	


		<h2>Vendas</h2>
	
	<div style='padding:0 30px'>
		
		<table id='table' class='table table-striped'>	
			<thead>
				<tr>
					<th>Index</th>
					<th>Comprador</th>
					<th>Preço</th>
					<th>Pagamento</th>
					<th>Parcelas</th>
					<th>Data</th>
					<th>Excluir</th>
				</tr>
			</thead>
		

		<tbody>	
	    @foreach($compras as $compra)
	    <tr>		
	    	<td>{{$compra->id}}</td>
	    	<td><b>{{ucfirst($compra->cliente)}}<b></td>			
	    	<td >R${{$compra->preco}}</td>		
	    	<td >{{$compra->pagamento}}</td>		
	    	<td >{{$compra->parcelas}}</td>		
	    <td><span>{{ date('d/m/Y',strtotime($compra->created_at)) }} </span></td>
				<td>
				<button class='btn btn-danger btn-sm' onclick='remove({{$compra->id}})'>	
					<img src="images/svg/trashcan.svg">
					</span>
				</button>
				</td>
			</button>			
	    </tr>
		@endforeach
			</tbody>
		</table>
		<br><br>
		
		<span>
			<a href="{{route('cad.venda')}}" class='btn btn-success btn-group' style='font-size:12pt;'>Cadastrar nova venda</a>
		</span>
		
		@if(count($compras) > 0)
		<span class='btn btn-primary btn-group' onclick='salvaPlanilha()'>
			Salvar Planilha
		</span>
		@endif

		<!-- HIDDEN CONFIRM CARD-->
		<span class="confirmRequest card shadow-sm" style='display:none; position:absolute; top:35vh; left:30vw; padding:50px;'>
			
		</span>
	</div>


<script type="text/javascript">

	var edit= 		function($id){
		location.href='editarvenda/'+$id;
	}

	var remove= 	function($id){
		if(confirm("Deseja apagar dados desta venda?")){
			$.ajax({
				url:'api/excluirvenda/'+$id,
				type:'delete',
				data:{
					'_token' : $('meta[name="csrf-token"]').attr('content')
				},
				context:this,
				success:function(response){
					var item=$('#table>tbody>tr');
					e=item.filter(function(i,object){
						return object.cells[0].textContent==$id;
					});
					e.remove();
				}
			});
		}
	}

  $(document).ready(function(){
      $('.table').DataTable({
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
    var htmlPlanilha = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>PlanilhaVendas</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>' + document.getElementById("table").innerHTML + '</table></body></html>';
 
    var htmlBase64 = btoa(htmlPlanilha);
    var link = "data:application/vnd.ms-excel;base64," + htmlBase64;
 
    var hyperlink = document.createElement("a");
    hyperlink.download = "PlanilhaVendas";
    hyperlink.href = link;
    hyperlink.style.display = 'none';
 
    document.body.appendChild(hyperlink);
    hyperlink.click();
    document.body.removeChild(hyperlink);
}
</script>
@endsection