<?php

use Illuminate\Database\Seeder;

use FilmFest\Venue;

class VenuesTableSeederMiff extends MiffSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->getData()->sessions;
		$festival = $this->getFestival();
		
		$festival->venues()->withTrashed()->forceDelete();
		
		$venues = [];
		
		foreach ($data as $row) {
			$venues[] = $row->VenueName;
			
			foreach ($row->sessions as $sessionRow) {
				$venues[] = $sessionRow->VenueName;
			}
			
		}
		
		$parents = ['ACMI', 'Hoyts Melbourne Central', 'Kino Cinemas'];
		
		$venues = array_unique(array_merge($parents, $venues));
		
		foreach ($venues as $venue) {
			$venue = [
				'name' => $venue,
				'slug' => str_slug($venue),
			];
			
			$venue = $festival->venues()->create($venue);
			
			foreach ($parents as $parent) {
				if (str_contains($venue->name, head(explode(' ', $parent))) && $venue->name != $parent) {
					$parent = Venue::where('slug', str_slug($parent))->first();
					$venue->parentVenue()->associate($parent)->save();
				}
			}
		}
		
    }
}
