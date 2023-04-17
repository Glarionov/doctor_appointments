<?php

namespace App\Rules;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;

class ProperVisitDate implements Rule, DataAwareRule
{
    /**
     * Время визита в минутах
     */
    const VISIT_INTERVAL = 30;

    /**
     * Форматированное время визита
     */
    protected $formattedInterval;

    /**
     * @var
     */
    protected $messageText = 'Invalid visit date';

    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];


    /**
     * Set the data under validation.
     *
     * @param  array $data
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->formattedInterval = new \DateInterval('PT' . self::VISIT_INTERVAL. 'M');
        //
    }

    /**
     * Проверяет соответствие записи началу приёма доктора
     *
     * @param $visitDate
     * @param $visitDateTime
     * @param $doctor
     * @return bool
     * @throws \Exception
     */
    protected function checkStartWorkDate($visitDate, $visitDateTime, $doctor): bool
    {
        $doctorStartWorkTime = $doctor->start_work;

        $doctorStartWorkDateTime = new \DateTime($visitDate . $doctorStartWorkTime);

        if ($visitDateTime < $doctorStartWorkDateTime) {
            $this->messageText = "Visit date must be after doctor start working: $doctorStartWorkTime";
            return false;
        }

        return true;
    }

    /**
     * Проверяет соответствие записи концу приёма доктора
     *
     * @param $visitDate
     * @param $visitDateTime
     * @param $doctor
     * @return bool
     * @throws \Exception
     */
    protected function checkFinishWorkDate($visitDate, $visitDateTime, $doctor): bool
    {
        $doctorFinishWorkTime = $doctor->finish_work;

        $doctorFinishWorkDateTime = new \DateTime($visitDate . $doctorFinishWorkTime);

        $lastPossibleVisitDateTime = $doctorFinishWorkDateTime->sub($this->formattedInterval);
        if ($visitDateTime > $lastPossibleVisitDateTime) {
            $this->messageText = "Visit date must be at least 30 minutes before doctor\'s finish date: $doctorFinishWorkTime";
            return false;
        }

        return true;
    }

    /**
     * Проверяет пересечение записи с другими записями к этому доктору
     *
     * @param $visitDateTime
     * @return bool
     */
    protected function checkIntersections($visitDateTime): bool
    {
        $visitDateTimeBase = clone $visitDateTime;

        $checkStartTime = $visitDateTime->sub($this->formattedInterval);
        $checkFinishTime = $visitDateTimeBase->add($this->formattedInterval);

        $appointments = Appointment::query()->whereBetween('visit_date', [$checkStartTime, $checkFinishTime])
            ->where('doctor_id', $this->data['doctor_id'])->get();
        if ($appointments->count()) {
            $this->messageText = "There are already exist appointment for this time period";
            return false;
        }
        return true;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws \Exception
     */
    public function passes($attribute, $value)
    {
        $visitDateTime = new \DateTime($value);
        $visitDate = $visitDateTime->format('Y-m-d');

        $doctor = Doctor::find($this->data['doctor_id']);

        if (!$this->checkStartWorkDate($visitDate, $visitDateTime, $doctor)) {
            return false;
        }

        if (!$this->checkFinishWorkDate($visitDate, $visitDateTime, $doctor)) {
            return false;
        }

        if (!$this->checkIntersections($visitDateTime)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->messageText;
    }
}
