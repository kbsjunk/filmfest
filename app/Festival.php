<?php

namespace FilmFest;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Festival extends Model
{
    use SoftDeletes;
	
	protected $fillable = ['name', 'slug'];
	
    public function years()
    {
        return $this->hasMany(FestivalYear::class);
    }
	
    public function venues()
    {
        return $this->hasMany(Venue::class);
    }
	
    public function attributeGroups()
    {
        return $this->hasMany(AttributeGroup::class);
    }
	
    public function attributes()
    {
        return $this->hasManyThrough(Attribute::class, AttributeGroup::class);
    }
	
    public function films()
    {
        return $this->hasManyThrough(Film::class, FestivalYear::class);
    }
	
    public function packages()
    {
        return $this->hasManyThrough(Package::class, FestivalYear::class);
    }
	
    public function events()
    {
        return $this->hasManyThrough(Event::class, FestivalYear::class);
    }
	
    public function collections()
    {
        return $this->hasManyThrough(Collection::class, FestivalYear::class);
    }
}
