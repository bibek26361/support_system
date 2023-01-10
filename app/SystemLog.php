<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function filterDataApi()
    {
        return [
            'user' => $this->user ? $this->user->name : 'N/A',
            'operation' => $this->operation,
            'description' => $this->description ?? '-',
            'operation_at' => $this->created_at->diffForHumans(),
            'operation_date_time' => $this->created_at->format('Y-m-d h:i:s A')
        ];
    }
}
