<?php

namespace FilmFest;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeGroup extends Model
{
    use SoftDeletes;
	
	protected $visible = ['id', 'name', 'slug', 'attributes'];
	
    public function festival()
    {
        return $this->belongsTo(Festival::class);
    }
	
	public function attributes()
	{
		return $this->hasMany(Attribute::class);
	}
	
	public function scopeForFestivalYear($query, FestivalYear $festivalYear)
	{
		$film = new Film;
		$package = new Package;
		$event = new Event;
		$attribute = new Attribute;
		
		return $query->distinct()
			->select($this->getTable().'.*')
			->join($attribute->getTable(), $this->getQualifiedKeyName(), '=', $this->attributes()->getForeignKey())
			->join($attribute->films()->getTable(), $attribute->getQualifiedKeyName(), '=', $attribute->films()->getForeignKey())
			->leftJoin($film->getTable(), function($join) use($festivalYear, $film) {	
				$join->on($film->getQualifiedKeyName(), '=', $film->attributes()->getForeignKey())
					->where($film->attributes()->getMorphType(), '=', $film->getMorphClass())
					->where($film->festivalYear()->getQualifiedForeignKey(), '=', $festivalYear->id);
			})->leftJoin($event->getTable(), function($join) use($festivalYear, $event) {	
				$join->on($event->getQualifiedKeyName(), '=', $event->attributes()->getForeignKey())
					->where($event->attributes()->getMorphType(), '=', $event->getMorphClass())
					->where($event->festivalYear()->getQualifiedForeignKey(), '=', $festivalYear->id);
			})->leftJoin($package->getTable(), function($join) use($festivalYear, $package) {	
				$join->on($package->getQualifiedKeyName(), '=', $package->attributes()->getForeignKey())
					->where($package->attributes()->getMorphType(), '=', $package->getMorphClass())
					->where($package->festivalYear()->getQualifiedForeignKey(), '=', $festivalYear->id);
			})->where(function($query) use ($film, $event, $package) {
				$query->whereNotNull($film->getQualifiedKeyName())
					->orWhereNotNull($event->getQualifiedKeyName())
					->orWhereNotNull($package->getQualifiedKeyName());
			});
	}
}
