<?php

namespace App\Http\Requests\Admin\theme;

use Illuminate\Foundation\Http\FormRequest;

class OurServiceRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required',
            'icon' => is_null($this->id) ? 'required|image|mimes:jpeg,png,jpg,svg,webp' : 'nullable|image|mimes:jpeg,png,jpg,svg,webp',
            'banner_image' => is_null($this->id) ? 'required|image|mimes:jpeg,png,jpg,svg,webp' : 'nullable|image|mimes:jpeg,png,jpg,svg,webp',
            'benefit_name.*' => 'required|string|max:255',
            'benefit_value.*' => 'required|string|max:255',
        ];

        if ($this->has('our_touch_point_title')) {
            foreach ($this->input('our_touch_point_title') as $key => $name) {
                $rules['our_touch_point_title.' . $key] = 'required|string|max:255';
                $rules['our_touch_point_details.' . $key] = 'required';

                if ($this->has('id') && isset($this->input('old_our_touch_point_icon')[$key]) && $this->input('old_our_touch_point_icon')[$key]) {
                    $rules['our_touch_point_icon.' . $key] = 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048';
                } else {
                    $rules['our_touch_point_icon.' . $key] = 'required|image|mimes:jpeg,png,jpg,svg,webp|max:2048';
                }
            }
        }
        if ($this->has('our_approach_title')) {
            foreach ($this->input('our_approach_title') as $key => $name) {
                $rules['our_approach_title.' . $key] = 'required|string|max:255';
                $rules['our_approach_details.' . $key] = 'required';
                $rules['our_approach_date.' . $key] = 'required';

                if ($this->has('id') && isset($this->input('old_our_approach_icon')[$key]) && $this->input('old_our_approach_icon')[$key]) {
                    $rules['our_approach_icon.' . $key] = 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048';
                } else {
                    $rules['our_approach_icon.' . $key] = 'required|image|mimes:jpeg,png,jpg,svg,webp|max:2048';
                }
            }
        }

        return $rules;
    }
    public function messages()
    {
        return [
            'our_touch_point_title.*.required' => __('Touch point title is required.'),
            'our_touch_point_details.*.required' => __('Touch point details is required.'),
            'our_touch_point_icon.*.required' => __('Icon is required.'),

            'our_approach_title.*.required' => __('Our approach title is required.'),
            'our_approach_details.*.required' => __('Our approach details is required.'),
            'our_approach_date.*.required' => __('Our approach date is required.'),
            'our_approach_icon.*.required' => __('Icon is required.'),
        ];
    }

}
