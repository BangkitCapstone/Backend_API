<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class History extends Model
{
    protected $table = "uploda_histories";


    public function user():BelongsTo{
        return $this->belongsTo(User::class,"users_id");
    }

    public function disease():BelongsTo{
        return $this->belongsTo(disease::class,"disease_id");
    }
}
