<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'mobile_no' => 'required|string|min:10|max:10|unique:users,contact',
            'password' => 'required|string|min:8',
        ];
    }
}
