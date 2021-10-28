<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiberDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    // protected $fillable = [
    //     'name',
    //     'introduction',
    //     'location',
    //     'cost'
    // ];
        Schema::create('siber_data', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('introduction');
            $table->string('location');
            $table->integer('cost');
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
        Schema::dropIfExists('siber_data');
    }
}
