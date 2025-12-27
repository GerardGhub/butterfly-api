<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    // Add this line to allow all columns to be saved:
    protected $guarded = []; 

    public function records()
    {
        return $this->hasMany(Record::class);
    }
}