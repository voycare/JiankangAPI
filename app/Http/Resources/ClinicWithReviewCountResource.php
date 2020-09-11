<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClinicWithReviewCountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $fields = ClinicResource::fields($this);
        $fields['reviews_count'] = $this->reviews_count;

        return $fields;
    }
}
