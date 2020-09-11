<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ClinicResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param int $total
     * @return array
     */
    public function toArray($request)
    {
        return self::fields($this);
    }

    /**
     * @param $_this
     * @return array
     */
    public static function fields($_this)
    {
        return [
            'id' => $_this->id,
            'name' => $_this->name,
            'email' => $_this->email,
            'address' => $_this->address,
            'avatar' => ($_this->avatar != null) ? $_this->avatar : '',
            'phone' => ($_this->phone != null) ? $_this->phone : '',
            'verify' => $_this->verify,
            'rate' => floatval($_this->rate),
            'created' => strtotime($_this->created_at),
            'profile' => $_this->profile,
            'languages' => $_this->languages,
            'certificates' => $_this->certificates,
            'treatments' => $_this->treatments,
            'services' => $_this->services,
            'total_reviews' => $_this->total_reviews,
            'total' => isset($_this->total) ? number_format($_this->total) : 0
        ];
    }
}
