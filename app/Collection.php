<?php

namespace FilmFest;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use SoftDeletes;
	
    public function festivalYear()
    {
        return $this->belongsTo(FestivalYear::class);
    }
}
