<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProblemCategory extends Model
{
    protected $guarded = [];

    public function problemType()
    {
        return $this->belongsTo(ProblemType::class);
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class);
    }
}
