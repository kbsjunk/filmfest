<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('descr');
            $table->text('long_descr');
            $table->string('year', 4);
			$table->integer('minutes')->default(60);
			$table->boolean('is_short')->default(false);
            $table->integer('festival_year_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['festival_year_id', 'slug']);
            $table->foreign('festival_year_id')->references('id')->on('festival_years')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('films');
    }
}
