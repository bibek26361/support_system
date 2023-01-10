<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProblemType extends Model
{
    protected $guarded=[];

    public function ticket()
    {
        return $this->hasMany(Ticket::class);
    }
}
