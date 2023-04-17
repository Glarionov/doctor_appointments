<?php

namespace App\Http\Repositories;

use App\Models\Doctor;

class DoctorRepository
{
    /**
     * @param array $requestData
     * @return Doctor
     */
    public function store(array $requestData)
    {
        $doctor = new Doctor();
        $doctor->fill($requestData);
        $doctor->save();

        return $doctor;
    }
}
