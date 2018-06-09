<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberSubscriptionFormRequest extends FormRequest
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
			'member' => 'required',
			'jamath_id'=> 'required',
			'start_year'=> 'required',
			'start_month'=> 'required',
        ];
    }
}