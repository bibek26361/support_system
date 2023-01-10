<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function ProductType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function organizations()
    {
        return $this->hasManyThrough(Organization::class, OrganizationProduct::class);
    }

    public function filterDataApi()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'product_type' => $this->productType ? $this->productType->name : 'N/A',
            'description' => $this->description,
            'image' => $this->getImage(),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }

    public function filterOrganizationProductDataApi()
    {
        return [
            'product_id' => $this->id,
            'product_name' => $this->name,
            'product_type' => $this->productType ? $this->productType->name : 'N/A',
            'product_description' => $this->description,
            'product_image' => $this->getImage()
        ];
    }

    public function getStatusText()
    {
        switch ($this->is_active) {
            case 1:
                return 'Active';
                break;
            case 0:
                return 'Inactive';
                break;
        }
    }

    public function getImage()
    {
        if (empty($this->image)) {
            return asset('public/images/logo.png');
        } elseif (file_exists('public/' . $this->image)) {
            return asset('public/' . $this->image);
        } else {
            return asset('public/images/logo.png');
        }
    }
}
