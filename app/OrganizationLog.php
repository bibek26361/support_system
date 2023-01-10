<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizationLog extends Model
{
    protected $guarded = [];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function filterDataApi()
    {
        return [
            'organization' => $this->organization ? $this->organization->organizationname : 'N/A',
            'operation' => $this->operation,
            'description' => $this->description ? strip_tags($this->description) : '-',
            'operation_at' => $this->created_at->diffForHumans(),
            'operation_date_time' => $this->created_at->format('Y-m-d h:i:s A')
        ];
    }
}
