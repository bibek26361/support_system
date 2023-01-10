<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizationProduct extends Model
{
    protected $guarded = [];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function filterDataApi()
    {
        if ($this->product) {
            return [
                'product_id' => $this->product_id,
                'product_name' => $this->product->name
            ];
        } else {
            return [
                'product_id' => '',
                'product_name' => ''
            ];
        }
    }
}
