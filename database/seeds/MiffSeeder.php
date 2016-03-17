<?php

use Illuminate\Database\Seeder;

use FilmFest\Festival;

abstract class MiffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected function getData()
    {
        return json_decode(file_get_contents(__DIR__.'/data/miff-2015.json'));		
    }
	
	protected function getFestival()
	{
		return Festival::where('slug', 'miff')->first();
	}
	
	protected function getFestivalYear()
	{
		return $this->getFestival()->years()->where('slug', '2015')->first();
	}
}
