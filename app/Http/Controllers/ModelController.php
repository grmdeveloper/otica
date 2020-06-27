<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelo;

class ModelController extends Controller
{
 
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

    public function editarModelo($id){
        $modelo=Modelo::find($id);
        return view('cadastromodelo',compact('modelo'));
    }

    public function editandoModelo(Request $request){
        $modelo =			Modelo::find($request->input('id'));
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

    public function getModelos(){
    	$modelos=Modelo::All();
    	return view('/modelos',compact('modelos'));
    }

    public function getModelo($id){
    	$modelo = Modelo::where('id',$id)->get()->first();
		$preco=$modelo->preco;
		$custo=$modelo->custo;

		$dados=['id'=>$id,'preco'=>$preco,'custo'=>$custo];

		return $dados;
    }


    public function excluirModelo($id) {
        $mod=Modelo::find($id);
        if($mod){
            $mod->delete();
            return response('OK',202);
        }    	
        else return response('erro',404);
    }

}
