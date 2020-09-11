<?php

namespace App\Http\Controllers;

use App\Consts;
use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $query = Payment::query()->where('client_id', Auth::id());
        if ($sortDate) {
            $query = $query->orderBy('created_at', $sortDate);
        }
        $payments = $query->paginate($limit);

        return $this->successResponseMessage(new PaymentCollection($payments));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id, Request $request)
    {
        $payment = Payment::where('client_id', Auth::id())->find($id);

        return $this->successResponse(PaymentResource::make($payment));
    }
}
