<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('status');
            $table->string('role');
            $table->string('profile_pic');
            $table->rememberToken();
            $table->timestamps();
        });

        /* INSERT A TRABLA KIND */
        DB::table('users')->insert([
            [
                'name'        => 'Angel Paredes Torres',
                'username'    => 'angel',
                'email'       => 'admin@gmail.com',
                'password'    => '$2y$10$g07CP2.YhICtBSRlJFkPRO1H23.BRbVCO1KUSuXD97q1Rd/6nXRea',
                'status'      => 'activo',
                'role'        => 'admin',
                'profile_pic' => 'userdefault.png'
            ]
        ]);
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
