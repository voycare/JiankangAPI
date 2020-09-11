<?php

namespace App\Http\Controllers\Admin;

use App\Consts;
use App\Http\Requests\AdminPaymentStoreRequest;
use App\Http\Requests\PaymentRemoveItemRequest;
use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    use ApiResponser;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $sortDate = isset($request->sort_created) ? $request->sort_created : 'desc';
        $query = Payment::query();
        if ($request->get('type') == 'clinic' && $request->get('id')) {
            $query = $query->where('clinic_id', $request->get('id'));
        }
        if ($request->get('type') == 'client' && $request->get('id')) {
            $query = $query->where('client_id', $request->get('id'));
        }
        if ($request->get('from')) {
            $from = Carbon::createFromTimestamp($request->get('from'));
            $query = $query->where('created_at', '>=', $from);
        }
        if ($request->get('to')) {
            $to = Carbon::createFromTimestamp($request->get('to'));
            $query = $query->where('created_at', '<=', $to);
        }
        if ($sortDate) {
            $query = $query->orderBy('created_at', $sortDate);
        }
        $payments = $query->paginate($limit);

        return $this->successResponse(new PaymentCollection($payments));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $payment = Payment::find($id);

        return $this->successResponse(PaymentResource::make($payment));
    }

    /**
     * @param Request $request
     * @return PaymentController
     */
    public function store(AdminPaymentStoreRequest $request)
    {
        if ($request->get('id')) {
            $payment = Payment::find($request->get('id'));
        } else {
            $payment = new Payment();
        }

        $data = $request->only(['client_id', 'clinic_id', 'name', 'email', 'consulation_type', 'payment_type', 'paid_date', 'paid_amount', 'status']);
        $data['paid_date'] = isset($data['paid_date']) ? Carbon::createFromTimestamp($data['paid_date']) : null;
        $payment->fill($data);
        $payment->save();

        PaymentItem::where('payment_id', $payment->id)->delete();
        $items = $request->get('items');
        if (count($items)) {
            foreach ($items as $item) {
                PaymentItem::create([
                    'name' => $item['name'],
                    'clinic_id' => $item['clinic_id'],
                    'payment_id' => $payment->id,
                    'price' => floatval($item['price']),
                    'quantity' => intval($item['quantity']),
                    'total' => floatval($item['price']) * intval($item['quantity']),
                ]);
            }
        }

        return $this->successResponseMessage(PaymentResource::make($payment), 200, 'Update Payment Successfully!');
    }

    /**
     * @param $id
     * @param Request $request
     * @return PaymentController|\Illuminate\Http\JsonResponse
     */
    public function removeItem($id, PaymentRemoveItemRequest $request)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return $this->errorMessage('Payment Not Found!', 404);
        }
        $item = PaymentItem::where('id', $request->get('item_id'))->where('payment_id', $payment->id)->first();
        if (!$item) {
            return $this->errorMessage('Payment Item Not Found!', 404);
        }
        $item->delete();
        // Refresh.
        $payment = Payment::find($id);

        return $this->successResponseMessage(PaymentResource::make($payment), 200, 'Remove Payment Item Successfully!');
    }
}
