<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Endereco;
use App\Compra;

class ClientController extends Controller
{

 
    public function cadastrarCliente(Request $request){
        $request->validate([
            'nome'=>'required|min:4|max:40',
            'telefone'=>'required|min:8|max:16',
        ]);

        $cliente = new Cliente();
        $cliente->nome=         $request->input('nome');
        $cliente->nascimento=   $request->input('nascimento');
        
        $cliente->nd_consta=    $request->input('nd_consta');
        
        $cliente->tso=    $request->input('tso');
        $cliente->tso_date=    $request->input('tso_date');
        
        $cliente->telefone=    $request->input('telefone');

        $cliente->rg=    $request->input('rg');
        $cliente->orgao=    $request->input('orgao');
        $cliente->cpf=    $request->input('cpf');
        
        $cliente->telefone=    $request->input('telefone');
        
        $cliente->telefone1=    $request->input('telefone1');
        $cliente->contato1=    $request->input('parente');
       
        $cliente->observacoes=    $request->input('observacoes');

        
        $cliente->miop=$request->input('miope')."/".$request->input('miopd');

        $cliente->asti=$request->input('astie')."/".$request->input('astid');

        $cliente->hipe=$request->input('hipee')."/".$request->input('hiped');

        $cliente->pres=$request->input('prese')."/".$request->input("presd");

        $cliente->save();

        $endereco = new Endereco();

        $endereco->user_id=$cliente->id;

        if($request->input('cep')!=null && $request->input('cep')) {
            $endereco->cep=$request->input('cep');
            $endereco->uf=$request->input('uf');
            $endereco->cidade=$request->input('cidade');
            $endereco->bairro=$request->input('bairro');
            $endereco->rua=$request->input('rua');
            $endereco->numero=$request->input('numero');
        }
        else{
            $endereco->cep='0';
            $endereco->uf='0';
            $endereco->cidade='0';
            $endereco->bairro='0';
            $endereco->rua='0';
            $endereco->numero='0';
        }
        
        $endereco->save();

        return redirect('/clientes');
    }



    public function editarCliente($id){
        $cliente=Cliente::where('id',$id)->first();
        $endereco=Endereco::where('user_id',$id)->first();
        
        return view('cadastrocliente',compact('cliente','endereco'));
    }

    public function editandoCliente(Request $request){

        $cliente=Cliente::find($request->input('id'));
        $request->validate([
            'nome'=>'required|min:4|max:40',
            'telefone'=>'required|min:8|max:16',
        ]);

        $cliente->nome=     $request->input('nome');
        $cliente->nascimento=    $request->input('nascimento');

        $cliente->nd_consta=    $request->input('nd_consta');

        $cliente->tso=    $request->input('tso');
        $cliente->tso_date=    $request->input('tso_date');

        $cliente->telefone=    $request->input('telefone');

        $cliente->rg=    $request->input('rg');
        $cliente->orgao=    $request->input('orgao');
        $cliente->cpf=    $request->input('cpf');
        
        $cliente->telefone=    $request->input('telefone');
        
        $cliente->telefone1=    $request->input('telefone1');
        $cliente->contato1=    $request->input('parente');

        $cliente->observacoes=    $request->input('observacoes');

        
        $cliente->miop=$request->input('miope')."/".$request->input('miopd');

        $cliente->asti=$request->input('astie')."/".$request->input('astid');

        $cliente->hipe=$request->input('hipee')."/".$request->input('hiped');

        $cliente->pres=$request->input('prese')."/".$request->input("presd");

        $cliente->save();

        $endereco = Endereco::where('user_id',$request->input('id'))->first();
 
        $endereco->cep=$request->input('cep');
        $endereco->uf=$request->input('uf');
        $endereco->cidade=$request->input('cidade');
        $endereco->bairro=$request->input('bairro');
        $endereco->rua=$request->input('rua');
        $endereco->numero=$request->input('numero');

        
        $endereco->save();

        return redirect('/clientes');
    }


        public function getClientes(){
	    	$clientes=Cliente::All();
	    	return view('/clientes',compact('clientes'));
    	}
   		
   		public function verCliente($id){
      	  	$cli=Cliente::find($id);
        	return $cli;
   		}

   		public function deleteCliente($id){
   			if($cliente=Cliente::find($id)){
				$compras=Compra::where('cliente_id',$id)->get();
				$endereco=Endereco::where('user_id',$id)->get()->first();
				
				$endereco->delete();
    			
    			if(count($compras)>0){	
    				$compras->each->delete();
    			}

    			$cliente->delete();
                return response('ok',202);


    		}
   		}
}
