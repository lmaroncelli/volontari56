<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('ruolo', ['admin', 'associazione'])->default('associazione');
            $table->string('name');
            $table->string('email')->default('');
            $table->string('username')->unique();
            //$table->string('username');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });


        /*
         * Lego la migration con il suo seed eseguendolo da dentro la migration
         * http://stackoverflow.com/questions/12736120/populating-a-database-in-a-laravel-migration-file
         */
        
        ///////////////////////////////////////////////
        // inserisco gli utenti dopo le associazioni //
        ///////////////////////////////////////////////

        /*Artisan::call( 'db:seed', [
            '--class' => 'UserSeeder',
            '--force' => true
        ]);*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
