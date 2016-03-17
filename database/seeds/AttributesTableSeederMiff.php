<?php

use Illuminate\Database\Seeder;

use FilmFest\AttributeGroup;
use FilmFest\Attribute;

class AttributesTableSeederMiff extends MiffSeeder
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
		
		$festival->attributeGroups()->withTrashed()->forceDelete();
		
		$accessibility = [
			'1'  => 'Assisted Listening',
			'2'  => 'Audio Description',
			'3'  => 'Auslan Interpreted',
			'5'  => 'Open Captioned',
			'6'  => 'Wheelchair Access',
			'7'  => '100% Subtitles',
			'10' => 'Subtitles',
			'11' => 'Rear Window Captioning',
		];
		
		$group = new AttributeGroup([
			'name' => 'Accessibility',
			'slug' => 'accessibility',
		]);
		
		$group->festival()->associate($festival)->save();
		
		foreach ($accessibility as $attribute) {
			$attribute = new Attribute([
				'name' => $attribute,
				'slug' => str_slug($attribute),
			]);

			$group->attributes()->save($attribute);
		}
		
		$groups = [];
		$fields = ['Category', 'Classification', 'Country', 'Language', 'Tags', 'Guest In Attendance', 'Type', 'Director'];

		foreach ($data as $sessionRow) {
			foreach ($fields as $field) {
				$sessionRow = json_decode(json_encode($sessionRow), true);
				$groups[$field] = array_filter(array_unique(array_merge(@$groups[$field] ?: [], explode(',', @$sessionRow[$field]))));
			}
		}
		
		foreach ($groups as $group => $attributes) {
		
			$group = new AttributeGroup([
				'name' => $group,
				'slug' => str_slug($group),
			]);

			$group->festival()->associate($festival)->save();

			foreach ($attributes as $attribute) {
				$attribute = new Attribute([
					'name' => $attribute,
					'slug' => str_slug($attribute),
				]);

				$group->attributes()->save($attribute);
			}
			
		}
    }
}
