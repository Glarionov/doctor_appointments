<?php

namespace App\Http\Repositories;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;

class AppointmentRepository
{
    /**
     * Применяет в query-builder фильтр по id докторов, с необходимым id, если в запросе есть такой фильтр
     * @param $requestData
     * @param $builder
     * @throws \Exception
     */
    private function applyDoctorNameFilter($requestData, &$builder): void
    {
        if (!empty($requestData['doctor_full_name'])) {
            $doctorQuery = Doctor::query();

            $doctorNameParts = explode(' ', $requestData['doctor_full_name']);

            $amountOfDoctorNameParts = count($doctorNameParts);
            if ($amountOfDoctorNameParts < 2 || count($doctorNameParts) > 3) {
                throw new \Exception('Improper doctor name');
            }

            $doctorQuery->where('last_name', $doctorNameParts[0])->where('first_name', $doctorNameParts[1]);

            if ($amountOfDoctorNameParts  == 3) {
                $doctorQuery->where('patronymic', $doctorNameParts[2]);
            }

            $doctorIds = $doctorQuery->get()->pluck('id');

            $builder->whereIn('doctor_id', $doctorIds);
        }
    }

    /**
     * Применяет в query-builder фильтр по id пациентов, с необходимым id, если в запросе есть такой фильтр
     * @param $requestData
     * @param $builder
     * @return bool|void
     */
    private function applyPatientNameFilter($requestData, &$builder)
    {
        $hasFilter = false;
        $patientQuery = Patient::query();
        foreach (['last_name', 'first_name', 'patronymic'] as $param) {
            if (!empty($requestData['patient_' . $param])) {
                $hasFilter = true;
                $patientQuery->where($param, $requestData['patient_' . $param]);
            }
        }

        if (!$hasFilter) {
            return true;
        }

        $ids = $patientQuery->get()->pluck('id');
        $builder->whereIn('patient_id', $ids);
    }

    /**
     * Применяет в query-builder фильтр по дате приёма
     * @param $requestData
     * @param $builder
     * @return bool|void
     */
    private function applyDateFilter($requestData, &$builder)
    {
        if (!empty($requestData['min_date'])) {
            $builder->where('visit_date', '>', $requestData['min_date']);
        }

        if (!empty($requestData['max_date'])) {
            $builder->where('visit_date', '<', $requestData['max_date']);
        }
    }

    /**
     * Применяет в query-builder сортировку по дате приёма
     * @param $requestData
     * @param $builder
     * @return bool|void
     */
    private function applyDateSort($requestData, &$builder)
    {
        if (!empty($requestData['date_sort'])) {
            $builder->orderBy('visit_date', $requestData['date_sort']);
        }
    }

    /**
     * @param array $requestData
     * @return Appointment
     */
    public function store(array $requestData)
    {
        $appointment = new Appointment();
        $appointment->fill($requestData);
        $appointment->save();

        return $appointment;
    }

    /**
     * @param array $requestData
     * @return Appointment
     */
    public function getList(array $requestData)
    {
        $builder = Appointment::query();
        $this->applyDoctorNameFilter($requestData, $builder);
        $this->applyPatientNameFilter($requestData, $builder);
        $this->applyDateFilter($requestData, $builder);
        $this->applyDateSort($requestData, $builder);

        return $builder->paginate(10);
    }
}
