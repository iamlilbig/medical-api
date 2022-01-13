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
            $table->string('username')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('password');
            $table->string('phone')->unique();
            $table->date('birthday_date')->nullable();
            $table->enum('gender',['MALE','FEMALE'])->nullable();
            $table->enum('profile_case',['NORMAL','PERIOD','PREGNANCY'])->nullable();
            $table->integer('height')->nullable();
            $table->dateTime('phone_verified_at')->nullable();
            $table->dateTime('banned_to')->nullable();
            $table->integer('warning')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
