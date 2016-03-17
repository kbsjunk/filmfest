<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageFilmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_film', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('package_id')->unsigned();
			$table->integer('film_id')->unsigned();
			$table->integer('order');
            $table->timestamps();
			
			$table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
			$table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('package_film');
    }
}
