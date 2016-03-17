<?php

use Illuminate\Database\Seeder;

use FilmFest\Venue;

class VenuesTableSeederMqff extends MqffSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->getData()->Venues;
		$festival = $this->getFestival();
		
		$festival->venues()->withTrashed()->forceDelete();
		
		foreach ($data as $row) {
			$venue = [
				'name' => $row->Name,
				'slug' => str_slug($row->Name),
			];
			
			if ($row->ParentVenueID) {
				foreach ($data as $parentRow) {
					if ($parentRow->VenueID == $row->ParentVenueID) {
						$venue['parent_venue_id'] = $festival->venues()->firstOrCreate([
							'name' => $parentRow->Name,
							'slug' => str_slug($parentRow->Name),
						])->id;
					}
				}
			}
			
			$festival->venues()->create($venue);
			
		}
		
    }
}
