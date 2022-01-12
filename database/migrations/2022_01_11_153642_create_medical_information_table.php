<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->boolean('special_disease');
            $table->boolean('diabetes');
            $table->boolean('blood_pressure');
            $table->boolean('kidney_failure');
            $table->boolean('heart_problem');
            $table->text('special_disease_list')->nullable();
            $table->text('doctor_list')->nullable();
            $table->string('heart_doctor')->nullable();
            $table->string('kidney_doctor')->nullable();
            $table->string('women_doctor')->nullable();
            $table->string('interior_doctor')->nullable();
            $table->text('medicine_list')->nullable();
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
        Schema::dropIfExists('medical_information');
    }
}
