<?php

namespace FilmFest;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Film extends Model
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
	
	public function packages()
	{
		return $this->belongsToMany(Package::class, 'package_film')->withPivot(['order'])->withTimestamps();
	}
	
	public function attributes()
    {
        return $this->morphToMany(Attribute::class, 'attributable');
    }
}
