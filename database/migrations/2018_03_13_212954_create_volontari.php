<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolontari extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblVolontari', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('associazione_id')->unsigned()->default(0);
            $table->string('nome')->default('');
            $table->string('cognome')->default('');
            $table->text('nota')->nullable()->default(null);
            $table->string('registro')->nullable()->default(null);
            $table->date('data_nascita')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });

        /*
         * Lego la migration con il suo seed eseguendolo da dentro la migration
         * http://stackoverflow.com/questions/12736120/populating-a-database-in-a-laravel-migration-file
         */
        Artisan::call( 'db:seed', [
            '--class' => 'VolontariSeeder',
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
        Schema::dropIfExists('tblVolontari');
    }
}
