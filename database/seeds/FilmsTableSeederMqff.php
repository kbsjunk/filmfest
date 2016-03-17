<?php

use Illuminate\Database\Seeder;

use FilmFest\Film;
use FilmFest\Package;
use FilmFest\Event;
use FilmFest\Session;
use FilmFest\Venue;
use FilmFest\Attribute;
use FilmFest\AttributeGroup;

class FilmsTableSeederMqff extends MqffSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->getData()->Sessions;
		$festival = $this->getFestival();
		$festivalYear = $this->getFestivalYear();
				
		$festivalYear->films()->withTrashed()->forceDelete();
		$festivalYear->packages()->withTrashed()->forceDelete();
		$festivalYear->events()->withTrashed()->forceDelete();
		$festivalYear->sessions()->withTrashed()->forceDelete();
		
		$attributes = [];
		
		foreach ($this->getData()->AttributeGroups as $group)
		{
			foreach ($group->Attributes as $attributeRow)
			{
				$attributes[$attributeRow->AttributeID] = $attributeRow->Value;
			}
		}
		
		$attributes = collect($attributes);
		
		foreach ($data as $sessionRow)
		{
			$filmRow = [
				'name'    => $sessionRow->Name,
				'slug'    => str_slug($sessionRow->Name),
				'descr'   => $sessionRow->DescriptionBrief,
				'minutes' => $sessionRow->Runtime,
			];
			
			if (str_contains($filmRow['slug'], 'shorts') || str_contains($filmRow['descr'], 'compilation')) {
				$record = $festivalYear->packages()->firstOrNew(array_only($filmRow, 'slug'));
			}
			elseif (str_contains($filmRow['descr'], 'workshop') 
					|| str_contains($filmRow['descr'], 'panel') 
					|| str_contains($filmRow['descr'], 'party') 
					|| str_contains($filmRow['descr'], 'masterclass')
					|| str_contains($filmRow['descr'], 'screening')
					|| str_contains($filmRow['descr'], 'event')
				   ) {
				$record = $festivalYear->events()->firstOrNew(array_only($filmRow, 'slug'));
			}
			elseif (str_contains($filmRow['slug'], 'workshop') 
					|| str_contains($filmRow['slug'], 'panel') 
					|| str_contains($filmRow['slug'], 'masterclass')
					|| str_contains($filmRow['slug'], 'screening')
					|| str_contains($filmRow['slug'], 'matchmaking')
					|| str_contains($filmRow['slug'], 'event')
				   ) {
				$record = $festivalYear->events()->firstOrNew(array_only($filmRow, 'slug'));
			}
			elseif (str_contains($filmRow['slug'], 'opening-night')	|| str_contains($filmRow['slug'], 'closing-night')
				   ) {
// 				$event = $festival->events()->firstOrNew(array_only($filmRow, 'slug'));
				
// 				if (!$event->exists)
// 				{
// 					$event->fill($filmRow);
// 					$event->save();
// 				}		
				
				$filmRow['name'] = trim(str_replace(['(Opening Night)', '(Closing Night)'], '', $filmRow['name']));
				$filmRow['slug']  = str_slug($filmRow['name']);
				
				$record = $festivalYear->films()->firstOrNew(array_only($filmRow, 'slug'));
			}
			else {
				$record = $festivalYear->films()->firstOrNew(array_only($filmRow, 'slug'));
			}
		
			if (!$record->exists)
			{
				$record->fill($filmRow);
				$record->save();
			}
			
			foreach ($this->getData()->Venues as $venueRow)
			{
				if ($venueRow->VenueID == $sessionRow->VenueID) {
					$venue = Venue::where('slug', str_slug($venueRow->Name))->first();
				}
			}
			
			$sessionData = [
				'start_at' => $sessionRow->DateTime,
				'minutes'  => 0,
			];
			
			$session = new Session($sessionData);
			$session->schedulable()->associate($record);
			
			if ($venue) {
				$session->venue()->associate($venue);
			}
			
			$session = $festivalYear->sessions()->save($session);
			
			$filmAttributes = explode(',', $sessionRow->AttributeIDs);
			$newAttributes = collect(array_combine(explode(',', $sessionRow->AttributeIDs), explode(',', $sessionRow->AttributeString)));
			
			foreach ($filmAttributes as &$filmAttribute)
			{	
				list($group, $attribute) = explode('|', $filmAttribute);
				
				$attribute = $attributes->get($attribute);
				$attribute = Attribute::where('slug', str_slug($attribute))->first();
				
				if ($attribute) {
					$filmAttribute = $attribute->id;
				}
				else {
					$attribute = $newAttributes->get($filmAttribute);
					
					$attribute = Attribute::where('slug', str_slug($attribute))->first();
				
					if ($attribute) {
						$filmAttribute = $attribute->id;
					}
					else {
						dd($filmAttribute);
					}
				}
			}
			
			unset($filmAttribute);
			
			$filmAttributes = array_filter($filmAttributes);
			
			$record->attributes()->sync($filmAttributes);
			
		}
    }
}
