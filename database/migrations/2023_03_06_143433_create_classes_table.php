<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('class_name');
            $table->unsignedBigInteger('wali_1')->nullable();
            $table->unsignedBigInteger('wali_2')->nullable();
        });

        Schema::table('classes', function (Blueprint $table) {
            $table->foreign('wali_1')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('wali_2')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes');
    }
};
