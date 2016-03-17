<?php

use Illuminate\Database\Seeder;

use FilmFest\Festival;
use FilmFest\FestivalYear;

class FestivalYearsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('festival_years')->delete();
		
		$data = [
			[
				'festival'  => 'mqff',
				'name'      => '2016',
				'tagline'   => 'Proudly Different',
				'slug'      => '2016',
				'date_from' => '2016-03-31',
				'date_to'   => '2016-04-11',
			],
			[
				'festival'  => 'miff',
				'name'      => '2015',
				'slug'      => '2015',
				'date_from' => '2016-07-30',
				'date_to'   => '2016-08-15',
			],	
			[
				'festival'  => 'flare',
				'name'      => '2016',
				'slug'      => '2016',
				'date_from' => '2016-03-16',
				'date_to'   => '2016-03-27',
			],	
		];
		
		foreach ($data as $row)
		{
			$festival = Festival::where('slug', $row['festival'])->first();
			$festival->years()->create(array_except($row, 'festival'));
		}
    }
}
