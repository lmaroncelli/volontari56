<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRelazioniVolontari extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblRelazioniVolontari', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('relazione_id')->unsigned();
            $table->integer('volontario_id')->unsigned();
            $table->index('relazione_id');
            $table->index('volontario_id');
            $table->timestamps();
        });

        /*
         * Lego la migration con il suo seed eseguendolo da dentro la migration
         * http://stackoverflow.com/questions/12736120/populating-a-database-in-a-laravel-migration-file
         */
        Artisan::call( 'db:seed', [
            '--class' => 'RelazioniVolontariSeeder',
            '--force' => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblRelazioniVolontari');
    }
}
