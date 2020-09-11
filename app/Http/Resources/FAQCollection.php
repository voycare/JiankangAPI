<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;

class FAQCollection extends ResourceCollection
{
    public function toArray($request)
    {

        return [
            'datas' => FAQResource::collection($this->collection),
        ];
    }

}
