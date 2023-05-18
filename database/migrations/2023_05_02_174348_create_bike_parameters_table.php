<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBikeParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bike_parameters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bike_id');
            $table->unsignedBigInteger('parameter_id');
            $table->string("value_string")->nullable();
            $table->integer("value_integer")->nullable();
            $table->float("value_float", 15, 5)->nullable();
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
        Schema::dropIfExists('bike_parameters');
    }
}
