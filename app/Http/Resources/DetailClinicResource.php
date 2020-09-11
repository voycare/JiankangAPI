<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class DetailClinicResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->first_name,
            'email' => $this->email,
            'address' => $this->address,
            'avatar' => ($this->avatar != null) ? $this->avatar : '',
            'phone' => ($this->phone != null) ? $this->phone : '',
            'rate' => $this->rate,
            'description' => ($this->description != null) ? $this->description : '',
            'total_review' => ($this->summaryReview) ? ($this->summaryReview->star_1 + $this->summaryReview->star_2 + $this->summaryReview->star_3 + $this->summaryReview->star_4 + $this->summaryReview->star_5) : 0,
            'doctors' => DoctorResource::collection($this->doctors()->limit(3)->get()),
            'certificates' => $this->certificates()->select('id', 'name', 'description', 'certificate')->get(),
            'clinic_profile' => $this->clinic_profile
        ];
    }
}
