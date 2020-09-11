<?php

namespace App\Http\Resources;

use App\Models\Payment;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
        $data['consulation_type_name'] = isset($data['consulation_type']) ? Payment::getCTypeName($data['consulation_type']) : '';
        $data['payment_type_name'] = isset($data['payment_type']) ? Payment::getPTypeName($data['payment_type']) : '';
        $data['paid_date'] = isset($data['paid_date']) ? strtotime($data['paid_date']) : '';
        $data['clinic'] = ClientResource::make($this->clinic);
        $items = $this->items;
        $data['items'] = $items;
        $data['client'] = ClientResource::make($this->client);
        $total = 0;
        if (count($items)) {
            foreach ($items as $item) {
                $total += $item->total;
            }
        }
        $data['total'] = $total;

        return $data;
    }
}
