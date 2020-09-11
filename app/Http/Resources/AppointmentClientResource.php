<?php


namespace App\Http\Resources;


use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Doctor;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentClientResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'date' => strtotime($this->date),
            'mode' => $this->mode,
            'status' => $this->status,
            'type_id' => $this->type_id,
            'created' => strtotime($this->created_at),
            'specialty_id' => $this->specialty_id,
            'treatment_id' => $this->treatment_id,
            'doctor' => DoctorResource::make($this->doctor),
            'clinic' => ClinicResource::make($this->clinic)
        ];

        if ($this->status == Appointment::RESCHEDULED) {
            $schedule_times = $this->schedule_times()->get();
            $data['schedule_times'] = $schedule_times ? AppointmentScheduleResource::collection($schedule_times) : [];
        } else {
            $data['schedule_times'] = [];
        }

        return $data;
    }
}
