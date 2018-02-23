<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberFormRequest extends FormRequest
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
			'name' => 'required|min:4',
			'mobile'=> 'digits:10|nullable',
			'majlis'=> 'required',
			'address1'=> 'required',
			'rms'=> 'nullable',
			'email'=> 'email|nullable',
        ];
    }
}