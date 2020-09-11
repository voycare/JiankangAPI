<?php

namespace App\Http\Controllers\Clinic;

use App\Consts;
use App\Helpers\MessageHelper;
use App\Http\Requests\MessageMarkAsRequest;
use App\Http\Resources\MessageCollection;
use App\Models\Message;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    use ApiResponser;

    /**
     * @param Request $request
     * @return MessageController
     */
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $id = Auth::id();
        $query = Message::query();
        $type = $request->get('type');
        $query = $query->whereRaw('to_id = ?', [$id]);
        $query = MessageHelper::index($query, $type);
        $items = $query->paginate($limit);

        return $this->successResponse(new MessageCollection($items));
    }

    /**
     * @param MessageMarkAsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(MessageMarkAsRequest $request)
    {
        $now = Carbon::now();
        Message::whereIn('id', $request->get('message_ids'))->update(['read_at' => $now]);

        return $this->successResponseMessage([], 200, 'Mark As Read Successfully!');
    }

    /**
     * @param MessageMarkAsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsUnread(MessageMarkAsRequest $request)
    {
        Message::whereIn('id', $request->get('message_ids'))->update(['read_at' => null]);

        return $this->successResponseMessage([], 200, 'Mark As Read Successfully!');
    }
}
