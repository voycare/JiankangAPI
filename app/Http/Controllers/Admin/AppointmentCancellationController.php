<?php

namespace App\Http\Controllers\Admin;

use App\Consts;
use App\Http\Requests\CRStoreRequest;
use App\Http\Requests\StoreRefundRequest;
use App\Http\Resources\AppointmentCancellationCollection;
use App\Http\Resources\AppointmentCancellationResource;
use App\Models\AppointmentCancellation;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentCancellationController extends Controller
{
    use ApiResponser;

    /**
     * @param Request $request
     * @return AppointmentCancellationController
     */
    public function index(Request $request)
    {
        $limit = $request->has('limit') ? $request->get('limit') : Consts::LIMIT_ITEM_PAGE;
        $sortDate = $request->has('sort_created') ? $request->get('sort_created') : 'desc';
        $country = $request->has('country') ? $request->get('country') : '';
        $query = AppointmentCancellation::query();
        if ($country) {
            $query = $query->whereHas('client', function ($q) use ($country) {
                return $q->where('country', $country);
            });
        }
        $query = $query->orderBy('created_at', $sortDate);
        $items = $query->paginate($limit);

        return $this->successResponse(new AppointmentCancellationCollection($items));
    }

    /**
     * @param $id
     * @return AppointmentCancellationController
     */
    public function show($id)
    {
        $item = AppointmentCancellation::find($id);
        if (!$item) {
            return $this->errorMessage('Item Not Found!', 404);
        }

        return $this->successResponse(AppointmentCancellationResource::make($item));
    }

    /**
     * @param $id
     * @param StoreRefundRequest $request
     * @return AppointmentCancellationController
     */
    public function storeRefund($id, StoreRefundRequest $request)
    {
        $item = AppointmentCancellation::find($id);
        if (!$item) {
            return $this->errorMessage('Item Not Found!', 404);
        }
        $item->status = $request->get('status');
        $item->citcon_no = $request->get('citcon_no');
        $item->save();

        return $this->successResponseMessage(AppointmentCancellationResource::make($item), 200, 'Update Refund Status Successfully!');
    }

    /**
     * @param $id
     * @param CRStoreRequest $request
     * @return AppointmentCancellationController|\Illuminate\Http\JsonResponse
     */
    public function store($id, CRStoreRequest $request)
    {
        $item = AppointmentCancellation::find($id);
        if (!$item) {
            return $this->errorMessage('Item Not Found!', 404);
        }
        $item->admin_note = $request->get('admin_note');
        $item->save();

        return $this->successResponseMessage(AppointmentCancellationResource::make($item), 200, 'Update Successfully!');
    }
}
