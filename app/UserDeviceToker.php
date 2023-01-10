<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDeviceToker extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
