<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('reconciled_data_id')->nullable();
            $table->string('ld');
            $table->string('full_name');
            $table->string('branch_code');
            $table->string('product');
            $table->date('date');
            $table->bigInteger('plafond');
            $table->string('atr');
            $table->bigInteger('outstanding');
            $table->integer('owner')->comment('1 = bsi, 2 = eka');
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
        Schema::dropIfExists('data');
    }
}
