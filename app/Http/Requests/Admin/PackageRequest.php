<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{
    public function rules()
    {
        $rule = [
            'name' => ['required', 'max:255'], // Validate package name
            'details' => ['required'], // Validate package details
            'quantity' => ['required', 'array'], // Validate as array
            'quantity.*' => ['required', 'integer'], // Each quantity must be an integer
            'quantity_type' => ['required', 'array'], // Validate quantity_type as array
            'quantity_type.*' => ['required', 'in:1,2'], // Each type must be 1 (Limited) or 2 (Unlimited)
            'other_name.*' => 'required|string', // Each feature name must be a string
            "monthly_price" => ['required', 'numeric'], // Validate monthly price
            "yearly_price" => ['required', 'numeric'], // Validate yearly price
            'icon' => $this->id ? 'nullable|mimes:jpeg,png,jpg' : 'required|mimes:jpeg,png,jpg', // Validate image
        ];

        // Ensure service_id.* is required and validated
        foreach ($this->input('quantity_type') as $index => $quantityType) {
            $rule['service_id.' . $index] = 'bail|required|exists:services,id';
        }

        return $rule;
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $serviceIds = $this->input('service_id', []);
            $quantities = $this->input('quantity', []);
            $quantityTypes = $this->input('quantity_type', []);

            foreach ($serviceIds as $index => $serviceId) {
                // Ensure a service ID is selected
                if (empty($serviceId)) {
                    $validator->errors()->add("service_id.$index", __('A service must be selected.'));
                }

                // Check for quantity validation
                $quantity = $quantities[$index] ?? null;
                $quantityType = $quantityTypes[$index] ?? null;

                // Validation for Limited Type
                if ($quantityType == 1 && ($quantity === null || $quantity < 1)) {
                    $validator->errors()->add("quantity.$index", __('Quantity must be greater than 0 for Limited type.'));
                }

                // Validation for Unlimited Type
                if ($quantityType == 2 && $quantity != -1) {
                    $validator->errors()->add("quantity.$index", __('Quantity must be -1 for Unlimited type.'));
                }
            }
        });
    }

    public function messages()
    {
        return [
            'name.required' => __('Package name is required.'),
            'details.required' => __('Package details are required.'),
            'service_id.*.required' => __('Service is required.'),
            'service_id.*.exists' => __('The selected service ID is invalid.'),
            'quantity.*.required' => __('Quantity is required.'),
            'quantity.*.integer' => __('Quantity must be an integer.'),
            'quantity_type.*.required' => __('Quantity type is required.'),
            'quantity_type.*.in' => __('Quantity type must be Limited or Unlimited.'),
            'other_name.*.required' => __('Feature is required.'),
            'monthly_price.required' => __('Monthly price is required.'),
            'monthly_price.numeric' => __('Monthly price must be a valid number.'),
            'yearly_price.required' => __('Yearly price is required.'),
            'yearly_price.numeric' => __('Yearly price must be a valid number.'),
            'icon.required' => __('Icon is required for a new package.'),
            'icon.mimes' => __('Icon must be a file of type: jpeg, png, jpg.'),
        ];
    }
}
