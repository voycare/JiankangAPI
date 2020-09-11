<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatementResource extends JsonResource
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
        $data['to'] = ClinicResource::make($this->to);
        $data['sale_period'] = strtotime($data['sale_period']);
        $data['payment_date'] = strtotime($data['payment_date']);
        $data['items'] = $this->items;

        return $data;
    }
}
