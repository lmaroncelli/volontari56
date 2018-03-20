<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssociazione extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblAssociazioni', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome')->default('');
            $table->integer('user_id')->unsigned()->nullable()->default(null);
            $table->timestamps();
        });

        /*
         * Lego la migration con il suo seed eseguendolo da dentro la migration
         * http://stackoverflow.com/questions/12736120/populating-a-database-in-a-laravel-migration-file
         */
        Artisan::call( 'db:seed', [
            '--class' => 'AssociazioniSeeder',
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
        Schema::dropIfExists('tblAssociazioni');
    }
}
