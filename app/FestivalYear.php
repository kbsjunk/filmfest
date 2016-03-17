<?php

namespace FilmFest;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FestivalYear extends Model
{
    use SoftDeletes;
	
	protected $fillable = ['name', 'slug', 'tagline', 'date_from', 'date_to', 'released_at'];
	
	protected $casts = [
		'date_from'   => 'date',	
		'date_to'     => 'date',	
		'released_at' => 'datetime',	
	];
	
    public function festival()
    {
        return $this->belongsTo(Festival::class);
    }
	
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
	
    public function films()
    {
        return $this->hasMany(Film::class);
    }
	
    public function packages()
    {
        return $this->hasMany(Package::class);
    }
	
    public function events()
    {
        return $this->hasMany(Event::class);
    }
	
    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
	
    public function venues()
    {
// 		$parentVenues = $this->sessions()->distinct()->pluck('venue_id')->toArray();
		
//         return $this->festival->venues()->whereIn('id', $parentVenues);
        
		return $this->festival->venues()->forFestivalYear($this);
    }
	
	public function attributes()
	{
		return $this->festival->attributes()->forFestivalYear($this);
	}
	
	public function attributeGroups()
	{
		return $this->festival->attributeGroups()->forFestivalYear($this);
	}
}
