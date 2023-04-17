<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class CreatePatientRequest extends FormRequest
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
            'last_name' => ['max:100', 'required_without_all:first_name,patronymic'],
            'first_name' => ['max:100', 'required_without_all:last_name,patronymic'],
            'patronymic' => ['max:100', 'required_without_all:first_name,last_name'],
            'snils' => ['required', 'numeric', 'min:10000000000', 'max:99999999999'],
            'birth_date' => ['date'],
            'birth_place' => ['max:400'],
        ];
    }
}
