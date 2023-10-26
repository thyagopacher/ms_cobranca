<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Importacaos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('importacaos')) {
            Schema::create('importacaos', function (Blueprint $table) {
                $table->id();
                $table->string('arquivo');
                $table->string('nomeOriginal');
                $table->integer('totalLinhas');
                $table->integer('totalImportado');
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
