<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApertoToPreventivo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblPreventivi', function (Blueprint $table) {
            $table->date('aperto')->after('motivazioni')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblPreventivi', function (Blueprint $table) {
            $table->dropColumn('aperto');
        });
    }
}
