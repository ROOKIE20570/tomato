<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddTaskRequest extends BaseRequest
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
            'name' => 'string|required',
            'price' => 'integer|required',
            'type' => Rule::in(0, 1, 2).'|required',
            'duration'=>'integer|required_if:type:1',
            'remind_time'=>'required_if:type,2'
            //
        ];
    }
}
