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
        Schema::create('sortition', function (Blueprint $table) {
            $table->id();
            $table->string('drawn_number')->nullable();
            $table->unsignedBigInteger('situation_id');
            $table->timestamps();

            $table->foreign('situation_id')->references('id')->on('situation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sortition');
    }
};
