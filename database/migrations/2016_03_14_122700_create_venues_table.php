<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('festival_id')->unsigned();
			$table->integer('parent_venue_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['festival_id', 'slug']);
            $table->foreign('festival_id')->references('id')->on('festivals')->onDelete('cascade');
			$table->foreign('parent_venue_id')->references('id')->on('venues')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('venues');
    }
}
