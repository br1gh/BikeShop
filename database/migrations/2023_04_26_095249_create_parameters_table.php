<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->string("type");
            $table->string("name");
            $table->string("unit")->nullable();
            $table->float("step", 15, 5)->default('1')->nullable();
            $table->float('min', 15, 5)->default('0')->nullable();
            $table->float('max', 15, 5)->default('100')->nullable();
            $table->tinyInteger('for_bikes')->default(0);
            $table->tinyInteger('for_parts')->default(0);
            $table->tinyInteger('for_accessories')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parameters');
    }
}
