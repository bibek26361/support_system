<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'organization_type_id' => 'required|integer',
            'organization_name' => 'required|string',
            'address' => 'required|string',
            'mobile_no' => 'required|min:10|max:10',
            'pan_vat_no' => 'required|min:9|max:9',
            'representative_name' => 'required|string',
            'used_products' => 'required|array',
            'latitude' => 'required|string',
            'longitude' => 'required|string'
        ];
    }
}
