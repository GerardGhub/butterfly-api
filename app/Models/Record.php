<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = ['species_id', 'year','sighting_date', 'count', 'latitude', 'longitude', 'grid_ref', 'observer', 'notes'];
    public function species()
{
    return $this->belongsTo(Species::class);
}
}
