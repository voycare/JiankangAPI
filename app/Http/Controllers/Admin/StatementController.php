<?php

namespace App\Http\Controllers\Admin;

use App\Consts;
use App\Http\Requests\StatementStoreRequest;
use App\Http\Resources\StatementCollection;
use App\Http\Resources\StatementResource;
use App\Models\Statement;
use App\Models\StatementItem;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatementController extends Controller
{
    use ApiResponser;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = $request->has('limit') ? $request->get('limit') : Consts::LIMIT_ITEM_PAGE;
        $sortDate = isset($request->sort_created) ? $request->sort_created : 'desc';
        $query = Statement::query();
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

        return $this->successResponse(new StatementCollection($payments));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $payment = Statement::find($id);

        return $this->successResponse(StatementResource::make($payment));
    }

    /**
     * @param Request $request
     * @return PaymentController
     */
    public function store(StatementStoreRequest $request)
    {
        if ($request->get('id')) {
            $statement = Statement::find($request->get('id'));
        } else {
            $statement = new Statement();
        }

        $data = $request->only(['statement_no', 'from_id', 'to_id', 'sale_period', 'payment_date', 'gross', 'refund', 'net', 'status']);
        $data['sale_period'] = Carbon::createFromTimestamp($data['sale_period']);
        $data['payment_date'] = Carbon::createFromTimestamp($data['payment_date']);
        $statement->fill($data);
        $statement->save();

        StatementItem::where('statement_id', $statement->id)->delete();
        $items = $request->get('items');
        if (count($items)) {
            foreach ($items as $item) {
                $item_date = Carbon::createFromTimestamp($item['item_date']);
                StatementItem::create([
                    'statement_id' => $statement->id,
                    'item_name' => $item['item_name'],
                    'item_date' => $item_date,
                    'appointment_no' => $item['appointment_no'],
                    'amount' => floatval($item['amount'])
                ]);
            }
        }

        return $this->successResponseMessage(PaymentResource::make($statement), 200, 'Update Payment Successfully!');
    }

    /**
     * @param $id
     * @param Request $request
     * @return PaymentController|\Illuminate\Http\JsonResponse
     */
    public function removeItem($id, Request $request)
    {
        $statement = Statement::find($id);
        if (!$statement) {
            return $this->errorMessage('Statement Not Found!', 404);
        }
        $item = StatementItem::where('id', $request->get('item_id'))->where('statement_id', $statement->id)->first();
        if (!$item) {
            return $this->errorMessage('Statement Item Not Found!', 404);
        }
        $item->delete();
        // Refresh.
        $statement = Statement::find($id);

        return $this->successResponseMessage(StatementResource::make($statement), 200, 'Remove Payment Item Successfully!');
    }
}
