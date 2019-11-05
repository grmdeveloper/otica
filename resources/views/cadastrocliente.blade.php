@extends('dashboard',['titulo'=>'Cliente','active'=>'clientes'])

@section('formulario')
	   <!-- Adicionando Javascript -->
    <script type="text/javascript" >
    
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {
 
                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

    </script>


	<h2>Cadastrar Cliente</h2>




	<form class="card clienteform" method='POST' @if(isset($cliente)) action="{{route('editandocliente')}}" @else action="{{route('cadastrandocliente')}}" @endif>

		@if(isset($cliente))
			<input type="hidden" name="id" value='{{$cliente->id}}'>
		@endif
		<br><br>

	<div class="form-group">
	@if($errors->any())
		@foreach($errors->all() as $error)
			<div class='alert alert-danger'>{{$error}}</div>
		@endforeach
	@endif
		<fieldset>
			<legend>informações pessoais</legend>
			
			<label>	
				nome
				<input type="text" name="nome" @if(isset($cliente)) value='{{$cliente->nome}}' @endif
				@if($errors->has('nome')) class='is-invalid' @endif>
			</label>	


			<label>
				Nascimento
				<input type="date" name="nascimento" @if(isset($cliente)) value='{{$cliente->nascimento}}' @endif> 
			</label>



		</fieldset>



		<fieldset>
			<label>
				Nada Consta
				<input type="text" name="nd_consta" @if(isset($cliente)) value='{{$cliente->nd_consta}}' @endif>
			</label>
			<br> <br>
			<label>
				TSO
				<input type="text" name="tso" @if(isset($cliente)) value='{{$cliente->tso}}' @endif>
			</label>
			<label>
				data
				<input type="date" name="tso_date" @if(isset($cliente)) value='{{$cliente->tso_date}}' @endif>
			</label>

		</fieldset>


		<fieldset>
			<legend>Documentos</legend>
			<label>
				RG
				<input type="text" name="rg" @if(isset($cliente)) value='{{$cliente->rg}}' @endif>
			</label>

			<label>
				Orgão emissor
				<input type="text" name="orgao" @if(isset($cliente)) value='{{$cliente->orgao}}' @endif>
			</label>

			<br>
			<label>
				CPF
				<input type="text" name="cpf" @if(isset($cliente)) value='{{$cliente->cpf}}' @endif>
			</label>

		</fieldset>

		<fieldset>
			
			<legend>Contato</legend>

			<label>	
				Telefone
				<input type="text" name="telefone" @if(isset($cliente)) value='{{$cliente->telefone}}'  @else value='(21) ' @endif required>
			</label>	
			
			<br>
				<legend>Telefone parente</legend>
				<label>
					Telefone
					<input type="text" name="telefone1" @if(isset($cliente)) value='{{$cliente->telefone1}}' @else value='(21) ' @endif>
				</label>

				<label>
					nome
					<input type="text" name="parente" @if(isset($cliente)) value='{{$cliente->contato1}}' @endif>
				</label>

		</fieldset>
	</div>

	<div class="form-group">
		<legend>Endereço</legend>

		<fieldset>
	  		<label>Cep
	        	<input name="cep" type="text" id="cep" maxlength="9"
	               onchange="pesquisacep(this.value)" @if(isset($cliente)) value='{{$endereco->cep}}' @endif>
	        </label>
		</fieldset>

		<label>
			UF
			<input type="text" name="uf" id='uf' @if(isset($cliente)) value='{{$endereco->uf}}' @endif>
		</label>
		<label>
			Cidade
			<input type="text" name="cidade" id="cidade" @if(isset($cliente)) value='{{$endereco->cidade}}' @endif>
		</label>

		<label>
			Bairro
			<input type="text" name="bairro" id="bairro" @if(isset($cliente)) value='{{$endereco->bairro}}' @endif>
		</label>
		<br>
		<label>
			Rua
			<input type="text" name="rua" id="rua" @if(isset($cliente)) value='{{$endereco->rua}}' @endif>
		</label>

		<label>
			Número
			<input type="text" name="numero" id="numero" @if(isset($cliente)) value='{{$endereco->numero}}' @endif>
			<input type="hidden" name="ibge">
		</label>

	</div>

	<div class="form-group">
		<fieldset class='graus'>
		<legend>Graus°</legend>
		<blockquote style='display:inline-block; font-size:10pt; margin-top:50px;'>esquerdo <br> <br> direito</blockquote>
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

		<label>
			Observações
			<input type='text' name='observacoes' @if(isset($cliente)) value='{{$cliente->observacoes}}' @endif size=80>
		</label>
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

  <!-- Adicionando Javascript -->
 
 <style type="text/css">
 	fieldset{
 		padding:15px;
 		margin:20px;

 		border:1px solid lightgray;
 	}
 	label{
 		vertical-align:top;
 	}
 	legend{
 		margin-top:15px;
 		font-family:verdana;
 		font-size:14pt;
 		font-style:italic;
 	}



 	.graus legend{
 		font-size:12pt;
 	}
 	.graus input{
 		width:155px;
 	}
 </style>
@endsection

