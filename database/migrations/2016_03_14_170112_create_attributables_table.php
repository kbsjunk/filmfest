<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attribute_id')->unsigned();
			$table->morphs('attributable'); //Film, Event, Package
            $table->timestamps();
			
			$table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attributables');
    }
}
