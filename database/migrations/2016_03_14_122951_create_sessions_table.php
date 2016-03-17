<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->morphs('schedulable'); //Film, Package, Event
            $table->integer('festival_year_id')->unsigned();
            $table->integer('venue_id')->unsigned();
			$table->integer('minutes')->default(60);
			$table->dateTime('start_at');
			$table->dateTime('end_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('festival_year_id')->references('id')->on('festival_years')->onDelete('cascade');
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sessions');
    }
}
