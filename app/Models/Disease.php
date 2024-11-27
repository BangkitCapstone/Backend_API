<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Disease extends Model
{
    public function histories():HasMany{
        return $this->hasMany(Disease::class,"disease_id");
    }
}
