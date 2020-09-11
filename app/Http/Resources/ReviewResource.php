<?php


namespace App\Http\Resources;


use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['appointment'] = AppointmentResource::make($this->appointment);
        $data['client'] = ClientResource::make($this->client);
        $data['clinic'] = ClinicResource::make($this->clinic);
        $data['treatment'] = $this->treatment;
        return $data;
    }
}
