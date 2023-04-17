<?php

namespace App\Http\Requests\Appointment;

use App\Rules\ProperVisitDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetAppointmentListRequest extends FormRequest
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
            'date_sort' => [Rule::in(['asc', 'desc'])],
            'min_date' => ['date'],
            'max_date' => ['date'],
            'doctor_full_name' => ['max:303'],
            'patient_last_name' => ['max:100'],
            'patient_first_name' => ['max:100'],
            'patient_patronymic' => ['max:100'],
        ];
    }
}
