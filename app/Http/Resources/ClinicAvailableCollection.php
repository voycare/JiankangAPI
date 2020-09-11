<?php

namespace App\Http\Resources;

use App\Models\ClinicAvailable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClinicAvailableCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $online_consulations = $this->collection->filter(function ($item) {
            return $item->type == ClinicAvailable::ONLINE_CONSULATION;
        });

        $site_visits = $this->collection->filter(function ($item) {
            return $item->type == ClinicAvailable::SITE_VISIT;
        });

        return [
            'online_consulations' => ClinicAvailableResource::collection($online_consulations),
            'site_visits' => ClinicAvailableResource::collection($site_visits)
        ];
    }
}
