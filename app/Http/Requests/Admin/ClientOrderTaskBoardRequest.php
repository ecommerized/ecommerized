<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClientOrderTaskBoardRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'task_name' => 'bail|required',
            'attachments.*' => 'bail|nullable|mimes:csv,odt,doc,docx,htm,html,pdf,ppt,pptx,txt,xls,xlsx,jpg,jpeg,png,gif,webp,svg,ai,mp4,mp3,wav,zip,rar',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'task_name.required' => __('The name field is required.'),
            'attachments.*.mimes' => __('The file must be a valid format, check the (i) icon.')
        ];
    }

}
