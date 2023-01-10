<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizationType extends Model
{
    protected $guarded = [];

    public function filterDataApi()
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
