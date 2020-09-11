<?php


namespace App\Http\Resources;


use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => ($this->last_name != null) ? $this->last_name : '',
            'email' => $this->email,
            'address' => $this->address,
            'avatar' => ($this->avatar != null) ? $this->avatar : '',
            'phone' => ($this->phone != null) ? $this->phone : '',
            'birthday' => $this->birthday,
            'gender' => $this->gender,
            'age' => $this->age
        ];

        $data['name'] = $data['first_name'] . ' ' . $data['last_name'];
        $data['address'] = $this->address;
        $data['created'] = strtotime($this->created_at);

        return $data;
    }
}
