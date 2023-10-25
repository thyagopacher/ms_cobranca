<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cobrancas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cobrancas')) {
            Schema::create('cobrancas', function (Blueprint $table) {
                $table->id()->comment('Chave primária');
                $table->string('name')->comment('Nome');
                $table->integer('governmentId')->comment('Número do documento');
                $table->string('email')->comment('E-mail do sacado');
                $table->float('debtAmount')->comment('valor');
                $table->date('debtDueDate')->comment('Data para ser paga');
                $table->timestamps();
            }); 
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
