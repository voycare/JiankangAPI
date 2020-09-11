<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['from'] = UserResource::make($this->from);
        $data['to'] = UserResource::make($this->to);
        $data['states'] = $this->states;
        return $data;
    }
}
