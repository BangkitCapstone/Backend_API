<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Disease extends Model
{
    protected $table = "tomato_leave_status";

    public function histories():HasMany{
        return $this->hasMany(History::class,"status_id");
    }
}
