<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveUserIdToVolontari extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /* Schema::table('tblAssociazioni', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('tblVolontari', function (Blueprint $table) {
            $table->integer('user_id')->after('associazione_id')->unsigned()->nullable()->default(null);
        });*/


        // loop sui volontari e creazione per ognuno di un record nella tabella users

        Artisan::call( 'db:seed', [
            '--class' => 'VolontariToUserSeeder',
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
        Schema::table('tblAssociazioni', function (Blueprint $table) {
            $table->integer('user_id')->after('nome')->unsigned()->nullable()->default(null);
        });

        Schema::table('tblVolontari', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
