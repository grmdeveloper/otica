<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compra;
use App\Modelo;
use App\Cliente;

class SalesController extends Controller
{
    public function cadastrarCompra(Request $request){
        $id_modelos=$request->input('modelo');
        $mod_qnt = $this->verificaEstoque($id_modelos);

        if(!is_null($mod_qnt)){
            $this->removeEstoque($mod_qnt);
            $this->executaCompra($mod_qnt,$request);
        }
        else{
            //!!RETORNAR PAGINA COM MSG DE ERRO!!
            die("modelo(s) indisponivei(s) no estoque");
        }

        return redirect("/vendas");        
    }


    //RETORNA ARRAY COM [COLLECTOR DO MODELO, QUANTIDADE COMPRADA] por modelo
    private function verificaEstoque($id_modelos){
        $verified_ids = [];
        
        //SETA ARRAY COM INDEX=ID VALUE=QNT_REQUERIDA
        foreach($id_modelos as $id){
            
            if(!isset($verified_ids[$id])){
                $verified_ids[$id]=0;
            }
            $verified_ids[$id] +=1;
        }

        foreach($verified_ids as $id => $qnt){
            $modelo=Modelo::where('id',$id)->first();
            $estoque = $modelo->estoque;

            //SE HOUVER ESTOQUE SUFICIENTE CONTINUAR SENÃO RETORNAR NULO
            if($modelo->estoque < $qnt){
                $mod_qnt = null;
                break;
            }else{
                $mod_qnt[]=['modelo'=>$modelo,'qnt'=>$qnt];
            }
        }

        return $mod_qnt;
    }

    private function removeEstoque($mod_qnt){
        foreach($mod_qnt as $modelo){
            $modelo['modelo']->estoque-=$modelo['qnt'];
            $modelo['modelo']->save();
        }
    }
 
    //CALCULA O CUSTO, PREÇO DE VENDA, LUCRO E RETORNA EM ARRAY.
    private function calculaValores($mod_qnt,$desconto){
        $preco_final=0; $custo_final=0; $lucro=0;

        foreach($mod_qnt as $modelo){
            for($x=0; $x < $modelo['qnt']; $x++){
                $preco_final += $modelo['modelo']->preco;
                $custo_final += $modelo['modelo']->custo;
            }
        }

        $preco_final = $preco_final-$desconto;
        $lucro = $preco_final - $custo_final;

        return ['custo'=>$custo_final,'preco'=> $preco_final,'lucro'=> $lucro];
    }

    private function executaCompra($mod_qnt, $request){
    
        $cliente_id=$request->input('cliente');
        $cliente= Cliente::find($cliente_id);

        $compra=                new Compra();
        $valores=               $this->calculaValores($mod_qnt,$request->desconto);
        $compra->cliente=       $cliente->nome;
        $compra->preco=         $valores['preco'];
        $compra->custo=         $valores['custo'];
        $compra->pagamento=     $request->input('pagamento');
        $compra->parcelas=      $request->input('parcelas');
        $compra->lucro=         $valores['lucro'];
        $compra->cliente_id=    $cliente->id;
        $compra->save();

    }


    public function getVendas(){
    	$compras=Compra::all();
    	return view('/vendas',compact('compras'));
    }

    public function formVenda(){
        $clientes=Cliente::orderBy('nome')->get();
        $modelos=Modelo::all();

        return view('cadastrovenda',compact('clientes','modelos'));
    }

    public function calculo(Request $request){
        $precoTot=0;
        $custoTot=0;
        foreach($request->input('modelo') as $id){
            $modelo=    Modelo::find($id);
            $preco=     $modelo->preco;
            $precoTot+= $preco;
            $custo=     $modelo->custo;
            $custoTot+= $custo;
        }

        $dados = ['precoTot'=>$precoTot,'custoTot'=>$custoTot];
        return $dados;
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


}
