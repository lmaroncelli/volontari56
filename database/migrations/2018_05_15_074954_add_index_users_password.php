<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexUsersPassword extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->unique('username');
        });

        Schema::table('password_resets', function($table)
        {
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    Schema::table('password_resets', function($table)
        {
        $table->dropIndex('password_resets_email_index');
        });
    
    Schema::table('users', function($table)
        {
        $table->dropUnique('users_username_unique');
        });
    }
}
