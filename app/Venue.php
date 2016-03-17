<?php

namespace FilmFest;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venue extends Model
{
    use SoftDeletes;
	
	protected $visible = ['id', 'name', 'slug'];
	
    public function festival()
    {
        return $this->belongsTo(Festival::class);
    }
	
	public function scopeForFestivalYear($query, FestivalYear $festivalYear)
	{
		$festivalVenues = $festivalYear->sessions()->distinct()->pluck('venue_id')->toArray();
		$parentVenues = Venue::whereIn('id', $festivalVenues)->distinct()->whereNotNull('parent_venue_id')->pluck('parent_venue_id');

		return $festivalYear->festival->venues()->whereIn('id', $parentVenues->merge($festivalVenues));
	}
	
	public function parentVenue()
	{
		return $this->belongsTo(Venue::class, 'parent_venue_id');
	}
	
	public function childVenues()
	{
		return $this->hasMany(Venue::class, 'parent_venue_id');
	}
}
