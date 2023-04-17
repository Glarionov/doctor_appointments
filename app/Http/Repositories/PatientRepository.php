<?php

namespace App\Http\Repositories;

use App\Models\Patient;

class PatientRepository
{
    /**
     * @param array $requestData
     * @return Patient
     */
    public function store(array $requestData)
    {
        $patient = new Patient();
        $patient->fill($requestData);
        $patient->save();

        return $patient;
    }
}
