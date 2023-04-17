<?php

namespace App\Http\Controllers;

use App\Http\Requests\Appointment\CreateAppointmentRequest;
use App\Http\Requests\Appointment\GetAppointmentListRequest;
use App\Http\Services\AppointmentService;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{

    protected $service;

    public function __construct(AppointmentService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetAppointmentListRequest $request)
    {
        return $this->service->getList($request->validated());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Appointment
     */
    public function store(CreateAppointmentRequest $request)
    {
        return $this->service->store($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointments
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointments
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointments)
    {
        //
    }
}
