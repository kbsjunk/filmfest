<?php

use Illuminate\Database\Seeder;

use FilmFest\Festival;

abstract class MqffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected function getData()
    {
        return json_decode(file_get_contents(__DIR__.'/data/mqff-2016.json'));		
    }
	
	protected function getFestival()
	{
		return Festival::where('slug', 'mqff')->first();
	}
	
	protected function getFestivalYear()
	{
		return $this->getFestival()->years()->where('slug', '2016')->first();
	}
}
