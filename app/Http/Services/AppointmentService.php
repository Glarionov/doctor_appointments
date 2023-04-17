<?php

namespace App\Http\Services;

use App\Http\Repositories\AppointmentRepository;
use App\Models\Appointment;

class AppointmentService
{
    protected $repository;

    public function __construct(AppointmentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $requestData
     * @return Appointment
     */
    public function store(array $requestData)
    {
        return $this->repository->store($requestData);
    }

    /**
     * @param array $requestData
     * @return Appointment
     */
    public function getList(array $requestData)
    {
        return $this->repository->getList($requestData);
    }
}
