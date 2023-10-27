<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MailCobranca extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mail_cobrancas')) {
            Schema::create('mail_cobrancas', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('idCobranca')->comment('Chave primaria tabela cobrancas');
                $table->foreign('idCobranca')->references('id')->on('cobrancas');
                $table->string('assunto')->comment('Assunto que estava cadastrado no dia do envio');
                $table->text('corpo')->comment('Corpo do e-mail');
                $table->date('dataEnvio')->comment('Data em que foi enviado o e-mail');
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
