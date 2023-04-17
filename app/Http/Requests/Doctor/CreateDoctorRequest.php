<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class CreateDoctorRequest extends FormRequest
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
            'last_name' => ['required', 'max:100'],
            'first_name' => ['required', 'max:100'],
            'patronymic' => ['max:100'],
            'email' => ['email'],
            'phone' => ['required', 'max:13', 'regex:/^\+?\d{10,12}$/'],
            'start_work_hour' => ['required', 'numeric', 'max:23'],
            'start_work_minute' => ['required', 'numeric', 'max:59'],
            'finish_work_hour' => ['required', 'numeric', 'max:23'],
            'finish_work_minute' => ['required', 'numeric', 'max:59'],
        ];
    }
}
