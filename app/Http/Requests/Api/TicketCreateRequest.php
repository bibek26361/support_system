<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class TicketCreateRequest extends FormRequest
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
            'organization_id' => 'required|integer',
            'product_id' => 'required|integer',
            'problem_type_id' => 'required|integer',
            'priority' => 'required|integer',
            'support_type' => 'required|string'
        ];
    }
}
