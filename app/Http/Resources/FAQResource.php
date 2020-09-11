<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class FAQResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'question' => $this->question,
            'answer' => $this->answer,
            'created' => strtotime($this->created_at)
        ];
    }
}
