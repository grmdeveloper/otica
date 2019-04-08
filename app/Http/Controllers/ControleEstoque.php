<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compra;
use App\Modelo;
use App\Cliente;
use App\Endereco;

class ControleEstoque extends Controller
{
    public function dashboardView(){
    	$compras=Compra::all();
    	$modelos=Modelo::all();
    	$clientes=Cliente::all();

    	return view('visaogeral',compact('compras','modelos','clientes'));

    }

    public function cadastrarCliente(Request $request){
        $request->validate([
            'nome'=>'required|min:4|max:40',
            'telefone'=>'required|min:8|max:16',
        ]);

        $cliente = new Cliente();
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

        $endereco = new Endereco();


        $endereco->user_id=$cliente->id;

        $endereco->cep=$request->input('cep');
        $endereco->uf=$request->input('uf');
        $endereco->cidade=$request->input('cidade');
        $endereco->bairro=$request->input('bairro');
        $endereco->rua=$request->input('rua');
        $endereco->numero=$request->input('numero');

        
        $endereco->save();

        return redirect('/clientes');
    }

    public function cadastrarModelo(Request $request){
        $request->validate([
            'nome'=>'required',
            'custo'=>'required',
            'preco'=>'required',
        ]);

        $modelo = new Modelo();
        $modelo->nome=      ucfirst( $request->input('nome') );
        $modelo->marca=     ucfirst( $request->input('marca') );
        $modelo->custo=     $request->input('custo');
        $modelo->preco=     $request->input('preco');
        $modelo->estoque=   $request->input('estoque');
        $modelo->save();

        return redirect("/modelos");
    }

    public function cadastrarCompra(Request $request){

        $cliente_id=    $request->input('cliente');
        $modelo_id=     $request->input('modelo');

    	$cliente=  Cliente::where('id',$cliente_id)->get()->first();
		$modelo=   Modelo::where('id',$modelo_id)->get()->first();

        if($modelo->estoque==0) {
            $message="O modelo esta indisponível no estoque";
            $compras=Compra::all();
            return view('/vendas',compact('compras','message'));
        }
		$compra= new Compra();

        $lentes=$request->input('preco');

		$compra->cliente=		$cliente->nome;
		$compra->preco=			$modelo->preco;
		$compra->custo= 		$modelo->custo;
		$compra->lucro=			($modelo->preco-$modelo->custo);
		$compra->cliente_id=	$cliente->id;
		$compra->save();

        $modelo->estoque--;
        $modelo->save();

        return redirect("/vendas");
    }



    public function editarCliente($id){
        $cliente=Cliente::where('id',$id)->get()->first();
        $endereco=Endereco::where('user_id',$id)->get()->first();
        
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

        $endereco = Endereco::where('user_id',$request->input('id'))->get()->first();


        $endereco->cep=$request->input('cep');
        $endereco->uf=$request->input('uf');
        $endereco->cidade=$request->input('cidade');
        $endereco->bairro=$request->input('bairro');
        $endereco->rua=$request->input('rua');
        $endereco->numero=$request->input('numero');

        
        $endereco->save();

        return redirect('/clientes');
    }



    public function editarModelo($id){
        $modelo=Modelo::find($id);
        return view('cadastromodelo',compact('modelo'));
    }
    public function editandoModelo(Request $request){
        $modelo =Modelo::find($request->input('id'));
        $modelo->nome=      ucfirst( $request->input('nome') );
        $modelo->marca=     ucfirst( $request->input('marca') );
        $modelo->custo=     $request->input('custo');
        $modelo->preco=     $request->input('preco');
        $modelo->estoque=   $request->input('estoque');
        $modelo->save();

        return redirect("/modelos");
    }


    public function addEstoque(Request $request){
        $modelo =Modelo::find($request->input('id'));
        $opt=$request->input('opt');
       
        if($opt=='-'){
            $modelo->estoque-=$request->input('estoque');
            if($modelo->estoque<0) $modelo->estoque=0;
        }

        elseif($opt=='+')
        $modelo->estoque+=$request->input('estoque');

        $modelo->save();

        return redirect('/modelos');
    }

    public function excluirModelo($id) {
        $mod=Modelo::find($id);
        if($mod){
            $mod->delete();
            return response('OK',202);
        }    	
        else return response('erro',404);
    }

    public function excluirVenda($id){
        $venda=Compra::find($id);
        if($venda) :
            $venda->delete();
            return response('OK',202);
        else:
            return response('erro',404);
        endif;
    }

    public function getVendas(){
    	$compras=Compra::all();
    	return view('/vendas',compact('compras'));
    }

    public function getClientes(){
    	$clientes=Cliente::All();
    	return view('/clientes',compact('clientes'));
    }

    public function getModelos(){
    	$modelos=Modelo::All();
    	return view('/modelos',compact('modelos'));
    }
}
