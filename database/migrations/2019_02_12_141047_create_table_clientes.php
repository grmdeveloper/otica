<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('nd_consta')->nullable();

            $table->string('tso')->nullable();
            $table->date('tso_date')->nullable();

            $table->string('rg')->nullable();
            $table->string('orgao')->nullable();
            $table->date('nascimento')->nullable();

            $table->string('cpf')->nullable();

            $table->string('telefone');
            
            $table->string('telefone1')->nullable();
            $table->string('contato1')->nullable();

            $table->string('miop');
            $table->string('asti');
            $table->string('hipe');
            $table->string('pres');
            
            $table->string('observacoes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
