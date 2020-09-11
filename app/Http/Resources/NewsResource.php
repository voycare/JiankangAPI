<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['created'] = strtotime($this->created_at);
        $data['publish_date'] = strtotime($this->publish_date);
//        $data['category'] = $this->category;
        $data['author'] = UserResource::make($this->author);
        $data['categories'] = $this->categories;
        return $data;
    }

}
