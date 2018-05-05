<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreventivi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblPreventivi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('associazione_id')->unsigned()->default(0);
            $table->dateTime('dalle')->nullable()->default(null);
            $table->dateTime('alle')->nullable()->default(null);
            $table->text('localita')->nullable()->default(null);
            $table->text('motivazioni')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });

        /*
         * Lego la migration con il suo seed eseguendolo da dentro la migration
         * http://stackoverflow.com/questions/12736120/populating-a-database-in-a-laravel-migration-file
         */
        Artisan::call( 'db:seed', [
            '--class' => 'PreventiviSeeder',
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
        Schema::dropIfExists('tblPreventivi');
    }
}
