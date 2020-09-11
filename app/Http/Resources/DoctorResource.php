<?php


namespace App\Http\Resources;


use App\Models\Clinic;
use App\Models\ClinicProfile;
use App\Models\Doctor;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['clinic'] = ClinicResource::make($this->clinic);

        return $data;
    }
}
