<?php

namespace FilmFest;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use SoftDeletes;
	
    public function festivalYear()
    {
        return $this->belongsTo(FestivalYear::class);
    }
	
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
	
	public function schedulable()
	{
		return $this->morphTo();
	}
	
	public function getNameAttribute()
	{
		return $this->getAttributeFromArray('name') ?: $this->schedulable->name;
	}
	
	public function getSlugAttribute()
	{
		return $this->getAttributeFromArray('slug') ?: $this->schedulable->slug;
	}
	
	public function getMinutesAttribute()
	{
		return $this->getAttributeFromArray('minutes') ?: $this->scheduleable->minutes;
	}
	
	public function films()
	{
		if ($this->schedulable_type == 'FilmFest\Package') {
			return $this->schedulable->films();
		}
		elseif ($this->schedulable_type == 'FilmFest\Film') {
			return $this->scheduleable();
		}
	}
}
