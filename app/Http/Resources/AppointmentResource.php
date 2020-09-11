<?php


namespace App\Http\Resources;


use App\Models\Appointment;
use App\Models\AppointmentDocument;
use App\Models\Doctor;
use App\Models\Interpreter;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray($request)
    {
        if (!$this) {
            return [];
        }
        $client = User::find($this->client_id);
        $doctor = Doctor::find($this->doctor_id);
        $interpreter = Interpreter::find($this->interpreter_id);
        $schedule_times = [];
        foreach ($this->schedule_times as $schedule_time) {
            $schedule_times[] = AppointmentScheduleResource::make($schedule_time);
        }
        $data = [
            'id' => $this->id,
            'date' => strtotime($this->date),
            'time' => $this->time,
            'mode' => $this->mode,
            'status' => $this->status,
            'state' => $this->state,
            'type_id' => $this->type_id,
            'created' => strtotime($this->created_at),
            'client' => ClientResource::make($client),
            'clinic' => ClinicResource::make($this->clinic),
            'doctor' => DoctorResource::make($doctor),
            'interpreter' => InterpreterResource::make($interpreter),
            'admin_notify_ids' => $this->admin_notify_ids,
            'specialty_id' => $this->specialty_id,
            'treatment_id' => $this->treatment_id,
            'treatment' => $this->treatment,
            'note' => $this->note,
            'documents_count' => $this->documents()->count(),
            'schedule_times' => $schedule_times
        ];

        return $data;
    }
}
