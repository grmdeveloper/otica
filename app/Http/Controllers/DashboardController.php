<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelo;
use App\Compra;
use App\Cliente;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
   public function dashboardView(){
    	$compras=Compra::all();
    	$modelos=Modelo::all();
    	$clientes=Cliente::all();

    	return view('visaogeral',compact('compras','modelos','clientes'));
    }

    public function dashboardWithTime(Request $request){
        $date   =  $request->input('data')." 00:00:01";
        $date1  =  $request->input('data1')." 23:59:59";

        $compras=DB::table('compras')
        ->whereBetween('created_at',[$date,$date1])
            ->get();

        $clientes=DB::table('clientes')
            ->whereBetween('created_at',[$date,$date1])
                ->get();

        $modelos=Modelo::all();

        return view('visaogeral',compact('compras','modelos','clientes'));
    }

    public function getVendas(){
        $compras=Compra::all();
        return view('/vendas',compact('compras'));
    }

    public function getModelos(){
        $modelos=Modelo::All();
        return view('/modelos',compact('modelos'));
    }

    public function getClientes(){
        $clientes=Cliente::All();
        return view('/clientes',compact('clientes'));
    }
}
