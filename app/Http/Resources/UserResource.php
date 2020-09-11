<?php


namespace App\Http\Resources;

use App\Consts;
use App\Models\Care;
use App\Models\Notification;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'first_name' => ($this->first_name != null) ? $this->first_name : '',
            'last_name' => ($this->last_name != null) ? $this->last_name : '',
            'email' => $this->email,
            'address' => $this->address,
            'avatar' => ($this->avatar != null) ? $this->avatar : '',
            'phone' => ($this->phone != null) ? $this->phone : '',
            'gender' => (int)$this->gender,
            'birthday' => $this->birthday,
            'role' => $this->role,
            'setting' => $this->setting()->select('consultation', 'site_visit', 'second_option', 'chat', 'call', 'message', 'appointments')->first()
        ];
        $data['name'] = $data['first_name'] . ' ' . $data['last_name'];
        
        return $data;
    }
}
