<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAssociazioniPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblAssociazioniPosts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('associazione_id')->unsigned();
            $table->integer('post_id')->unsigned();
            $table->index('associazione_id');
            $table->index('post_id');
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
        Schema::dropIfExists('tblAssociazioniPosts');
    }
}
