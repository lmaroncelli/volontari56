<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAssociazioniDocumenti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblAssociazioniDocumenti', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('associazione_id')->unsigned();
            $table->integer('documento_id')->unsigned();
            $table->index('associazione_id');
            $table->index('documento_id');
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
        Schema::dropIfExists('tblAssociazioniDocumenti');
    }
}
