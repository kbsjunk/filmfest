<?php

use Illuminate\Database\Seeder;

use FilmFest\Festival;

class FestivalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('festivals')->delete();
		
		$data = [
			[
				'name' => 'Melbourne Queer Film Festival',
				'slug' => 'mqff',
			],	
			[
				'name' => 'Melbourne International Film Festival',
				'slug' => 'miff',
			],	
			[
				'name' => 'BFI Flare: London LGBT Film Festival',
				'slug' => 'flare',
			],	
		];
		
		foreach ($data as $row)
		{
			Festival::create($row);
		}
		
    }
}
