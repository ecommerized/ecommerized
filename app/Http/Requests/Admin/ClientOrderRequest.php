<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClientOrderRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'client_id' => 'bail|required',
            'package_id' => 'bail|required',
            'plan_duration' => 'bail|required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'client_id.required' => __('The client field is required.'),
            'package_id.required' => __('The plan field is required.'),
            'plan_duration.required' => __('The plan duration field is required.'),
            'gateway.integer' => __('The gateway is required.'),
            'gateway_currency.required' => __('The currency field is required.'),
        ];
    }

}
