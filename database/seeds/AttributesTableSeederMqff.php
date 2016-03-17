<?php

use Illuminate\Database\Seeder;

use FilmFest\AttributeGroup;
use FilmFest\Attribute;

class AttributesTableSeederMqff extends MqffSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->getData()->AttributeGroups;
		$festival = $this->getFestival();
		
		$festival->attributeGroups()->withTrashed()->forceDelete();
		
		foreach ($data as $groupRow)
		{
			$group = [
				'name' => $groupRow->Name,
				'slug' => str_slug($groupRow->Name),
			];
			
			$group = $festival->attributeGroups()->create($group);
			
			foreach ($groupRow->Attributes as $attributeRow)
			{
				$attribute = [
					'name' => $attributeRow->Value,
					'slug' => str_slug($attributeRow->Value),
				];

				$group->attributes()->create($attribute);
				
			}
			
		}
			
		foreach ($this->getData()->Sessions as $sessionRow)
		{
			$newAttributes = array_combine(explode(',', $sessionRow->AttributeIDs), explode(',', $sessionRow->AttributeString));

			foreach ($newAttributes as $key => $newAttribute)
			{
				list($groupId, $attributeId) = explode('|', $key);

				$attribute = Attribute::where('slug', str_slug($newAttribute))->first();

				if (!$attribute)
				{

					$group = $festival->attributeGroups()->firstOrCreate([
						'name' => $groupId,
						'slug' => $groupId,
					]);

					$attribute = $group->attributes()->create([
						'name' => $newAttribute,
						'slug' => str_slug($newAttribute),
					]);
				}
			}
		}
    }
}
