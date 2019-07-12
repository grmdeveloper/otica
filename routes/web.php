<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/ 

use Illuminate\Support\Facades\DB;
use App\Modelo;
use App\Compra;
use App\Cliente;
use App\Endereco;

Route::get('/', function(){
	return redirect('/dashboard');
});

Route::get('/dashboard','ControleEstoque@dashboardView')->name('pagina.geral');
Route::post('/dashboard','ControleEstoque@dashboardWithTime')->name('pagina.geral.set');

Route::get('/vendas','ControleEstoque@getVendas')->name('pagina.vendas');
Route::get('/modelos','ControleEstoque@getModelos')->name('pagina.modelos');
Route::get('/clientes','ControleEstoque@getClientes')->name('pagina.clientes');


Route::get('/cadastrarmodelo',function(){
	return view('cadastromodelo');
})->name('cad.modelo');
Route::get('/cadastrarcliente',function(){
	return view('cadastrocliente');
})->name('cad.cliente');
Route::get('/cadastrarvenda',function(){
	$clientes=Cliente::orderBy('nome')->get();
	$modelos=Modelo::all();

	return view('cadastrovenda',compact('clientes','modelos'));
})->name('cad.venda');


Route::post("/cadastrandocliente",'ControleEstoque@cadastrarCliente')->name('cadastrandocliente');
Route::post("/cadastrandovenda" ,'ControleEstoque@cadastrarCompra');
Route::post('/cadastrandomodelo'  ,'ControleEstoque@cadastrarModelo');

Route::get('/editarcliente/{id}','ControleEstoque@editarCliente');
Route::get('/editarvenda/{id}','ControleEstoque@editarCompra');
Route::get('/editarmodelo/{id}','ControleEstoque@editarModelo');

Route::post('/editandocliente/','ControleEstoque@editandoCliente')->name('editandocliente');
Route::post('/editandovenda/' ,'ControleEstoque@editandoCompra');
Route::post('/editandomodelo/' ,'ControleEstoque@editandoModelo');
Route::post('/addestoque', 'ControleEstoque@addEstoque');
Route::post('/rmestoque', 'ControleEstoque@rmEstoque');

Route::get('/excluircliente/{id}',function($id){
	if($cliente=Cliente::find($id)){
		$compras=Compra::where('cliente_id',$id)->get();
		$endereco=Endereco::where('user_id',$id)->get()->first();
		
		$endereco->delete();
		if(count($compras)>0)	$compras->each->delete();
		$cliente->delete();

	}
	return redirect('/clientes');
});

Route::get('/excluirvenda/{id}',function($id){
	$compra=Compra::find($id);
	$compra->delete();

	return redirect('/vendas');
});

Route::get('/vercliente/{id}','ControleEstoque@verCliente');

Route::get('/getmodelo/{id}',function($id){
	$modelo = Modelo::where('id',$id)->get()->first();
	$preco=$modelo->preco;
	$custo=$modelo->custo;

	$dados=['id'=>$id,'preco'=>$preco,'custo'=>$custo];

	return $dados;
})->name('getmodelo');

Route::post('/calculo','ControleEstoque@calculo')->name('calculo');


Route::get('/teste', function(){
	$get=Cliente::all();

	foreach($get as $cliente){
		echo $cliente->endereco;
	}

	return $get->toJson();
});