<?php


use Tests\TestCase;
use Faker\Factory as Faker;

class AppointmentTest extends TestCase
{

    /**
     * @var array
     */
    protected $doctors = [];

    /**
     * @var array
     */
    protected $patients = [];

    /**
     * Создаёт врачей
     * @return void
     */
    private function createDoctors()
    {
        $faker = Faker::create();

        for ($i = 1; $i < 6; $i++) {
            $data = [
                'last_name' => 'doclas_' . $i,
                'first_name' => 'docfir_' . $i
            ];
            if ($i == 5) {
                $data['patronymic'] = 'docpat';
            }

            $data['start_work_hour'] = $i + 4;
            $data['finish_work_hour'] = $i + 12;

            $data['start_work_minute'] = 0;
            $data['finish_work_minute'] = 30;

            $data['phone'] = $faker->numberBetween(9999999999, 99999999999);

            $response = $this->post('/api/doctors', $data);
            $response->assertStatus(201);
            $response->assertJson(['last_name' => $data['last_name']]);
            $doctorData = $response->getOriginalContent()->toArray();
            $this->doctors[$i] = $doctorData;
        }
    }

    /**
     * Создаёт пациентов
     * @return void
     */
    private function createPatients()
    {
        $faker = Faker::create();

        for ($i = 1; $i < 6; $i++) {
            $data = [
                'last_name' => 'patlas_' . $i,
                'first_name' => 'patfir_' . $i
            ];
            if ($i == 5) {
                $data['patronymic'] = 'patpat';
            }

            $data['snils'] = $faker->numberBetween(10000000000, 99999999999);

            $response = $this->post('/api/patients', $data);
            $response->assertStatus(201);
            $response->assertJson(['first_name' => $data['first_name']]);
            $patientData = $response->getOriginalContent()->toArray();
            $this->patients[$i] = $patientData;
        }
    }

    /**
     * Создаёт записи
     * @return void
     */
    private function createAppointments()
    {
        foreach ($this->doctors as $doctor) {

            $doctorId = $doctor['id'];
            $data = [
                'doctor_id' => $doctorId,
                'patient_id' => $this->patients[1]['id'],
                'visit_date' => '2011-11-11 01:00'
            ];

            $data['visit_date'] = '2011-11-11 11:00';
            $response = $this->post('/api/appointments', $data);
            $response->assertStatus(201);

            $data['visit_date'] = '2011-11-11 11:29';
            $response = $this->post('/api/appointments', $data);
            $response->assertStatus(302);

            $data['visit_date'] = '2011-11-11 11:30';
            $response = $this->post('/api/appointments', $data);
            $response->assertStatus(302);

            $data['visit_date'] = '2011-11-11 11:31';
            $response = $this->post('/api/appointments', $data);
            $response->assertStatus(201);

            $data['visit_date'] = '2011-12-11 11:31';
            $response = $this->post('/api/appointments', $data);
            $response->assertStatus(201);

            $data['visit_date'] = '1970-01-01 10:00';
            $response = $this->post('/api/appointments', $data);
            $response->assertStatus(201);

            $data['visit_date'] = '1970-01-01 10:31';
            $response = $this->post('/api/appointments', $data);
            $response->assertStatus(201);
        }
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_appointments()
    {

        $response = $this->get('/');

        $response->assertStatus(200);

        $this->createDoctors();
        $this->createPatients();
        $this->createAppointments();

    }
}
