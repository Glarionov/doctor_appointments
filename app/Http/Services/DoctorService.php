<?php

namespace App\Http\Services;

use App\Http\Repositories\DoctorRepository;
use App\Models\Doctor;

class DoctorService
{
    protected $repository;

    public function __construct(DoctorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $requestData
     * @return Doctor
     */
    public function store(array $requestData)
    {
        foreach (['start_work', 'finish_work'] as $param) {
            if ($requestData[$param . '_hour'] < 10) {
                $requestData[$param . '_hour'] = '0' . $requestData[$param . '_hour'];
            }

            if ($requestData[$param . '_minute'] < 10) {
                $requestData[$param . '_minute'] = '0' . $requestData[$param . '_minute'];
            }

            $requestData[$param] = $requestData[$param . '_hour'] . ':' . $requestData[$param . '_minute'];
        }

        return $this->repository->store($requestData);
    }
}
