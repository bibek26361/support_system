<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $guarded = [];

    public function organizationType()
    {
        return $this->belongsTo(OrganizationType::class);
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class);
    }

    public function organizationProducts()
    {
        return $this->hasOne(OrganizationProduct::class);
    }

    public function filterDataApi()
    {
        $usedProducts = OrganizationProduct::where('organization_id', $this->id)->get();
        foreach ($usedProducts as $key => $usedProduct) {
            $usedProducts[$key] = $usedProduct->product->filterDataApi();
        }
        return [
            'id' => $this->id,
            'name' => $this->organizationname,
            'mobile_no' => $this->mobilenumber,
            'phone_no' => $this->phonenumber ?? '-',
            'type' => $this->organizationType->name,
            'address' => $this->address ?? '-',
            'pan_vat_no' => $this->pan_vat_number ?? '-',
            'representative_name' => $this->representativename ?? '-',
            'used_products' => $usedProducts,
            'latitude' => $this->latitude ?? '-',
            'longitude' => $this->longitude ?? '-',
            'email' => $this->email ?? '-',
            'system_base_url' => $this->system_base_url ?? '-',
            'security_key' => $this->security_key ?? '-',
            'api_key' => $this->api_key ?? '-',
            'anydesk_no' => $this->anydesk_no ?? '-',
        ];
    }
}
