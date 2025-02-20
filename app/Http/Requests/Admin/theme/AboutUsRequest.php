<?php

namespace App\Http\Requests\Admin\theme;

use Illuminate\Foundation\Http\FormRequest;

class AboutUsRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'details' => 'required',
            'image' => is_null($this->id) ? 'required|image|mimes:jpeg,png,jpg,svg,webp' : 'nullable|image|mimes:jpeg,png,jpg,svg,webp',
            'banner_image' => is_null($this->id) ? 'required|image|mimes:jpeg,png,jpg,svg,webp' : 'nullable|image|mimes:jpeg,png,jpg,svg,webp',
            'our_vision.title' => 'required',
            'our_vision.details' => 'required',
            'our_vision' => 'required',
            'our_mission.*' => 'required',
        ];

        if ($this->has('team_member_name')) {
            foreach ($this->input('team_member_name') as $key => $name) {
                $rules['team_member_name.' . $key] = 'required|string|max:255';
                $rules['team_member_designation.' . $key] = 'required';

                if ($this->has('id') && isset($this->input('old_team_member_image')[$key]) && $this->input('old_team_member_image')[$key]) {
                    $rules['team_member_image.' . $key] = 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048';
                } else {
                    $rules['team_member_image.' . $key] = 'required|image|mimes:jpeg,png,jpg,svg,webp|max:2048';
                }
            }
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'team_member_name.*.required' => __('Team member name is required.'),
            'team_member_designation.*.required' => __('Team member designation is required.'),
            'team_member_image.*.required' => __('Image is required.'),
        ];
    }

}
