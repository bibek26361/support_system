<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $guarded = [];
    public function product()
    {
        return $this->hasOne(Product::class);
    }
    public function filterDataApi()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description ?? 'N/A',
        ];
    }
}
