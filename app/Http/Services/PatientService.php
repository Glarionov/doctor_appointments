<?php

namespace App\Http\Services;

use App\Http\Repositories\DoctorRepository;
use App\Http\Repositories\PatientRepository;
use App\Models\Patient;

class PatientService
{
    protected $repository;

    public function __construct(PatientRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $requestData
     * @return Patient
     */
    public function store(array $requestData)
    {
        return $this->repository->store($requestData);
    }
}
