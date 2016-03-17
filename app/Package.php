<?php

namespace FilmFest;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;
	
    public function festivalYear()
    {
        return $this->belongsTo(FestivalYear::class);
    }
	
	public function sessions()
	{
		return $this->morphMany(Session::class, 'schedulable');
	}
	
	public function films()
	{
		return $this->belongsToMany(Film::class, 'package_film')->withPivot(['order'])->withTimestamps();
	}
	
	public function getMinutesAttribute()
	{
		$minutes = 0;
			
		foreach ($this->films as $film) {
			$minutes += $film->minutes;
		}
			
		return $minutes;
	}
	
	public function attributes()
    {
        return $this->morphToMany(Attribute::class, 'attributable');
    }
	
	public function getAllAttributesAttribute()
    {
		$filmAttributes = collect([]);
		
		foreach ($this->films as $film)
		{
			$filmAttributes = $filmAttributes->merge($film->attributes);
		}
		
        return $this->attributes->merge($filmAttributes)->unique('id');
    }
}
