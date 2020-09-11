<?php

namespace App\Http\Controllers;

use App\Consts;
use App\Http\Requests\PostMarkReadsRequest;
use App\Http\Resources\MessageCollection;
use App\Models\Message;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    use ApiResponser;

    /**
     * @return MessageController
     */
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $sortDate = isset($request->sort_created) ? $request->sort_created : 'desc';
        $key = isset($request->key) ? $request->key : '';
        $id = Auth::id();
        $query = Message::query();
        $query = $query->orderBy('created_at', $sortDate);
        if ($key) {
            $query = $query->where('content', 'LIKE', '%' . $key . '%');
        }
        $messages = $query->where('to_id', $id)->paginate($limit);

        return $this->successResponseMessage(new MessageCollection($messages));
    }

    /**
     * @param PostMarkReadsRequest $postMarkReadsRequest
     */
    public function markReads(PostMarkReadsRequest $postMarkReadsRequest)
    {
        $message_ids = $postMarkReadsRequest->message_ids;
        $id = Auth::id();
        $messages = Message::where('to_id', $id)->whereIn('id', $message_ids)->get();

        if (count($messages)) {
            foreach ($messages as $message) {
                $message->read_at = Carbon::now();
                $message->save();
            }
        }

        return $this->successResponseMessage([], 200, 'Mark as read successfully!');
    }

    /**
     * @param PostMarkReadsRequest $postMarkReadsRequest
     */
    public function markUnreads(PostMarkReadsRequest $postMarkReadsRequest)
    {
        $message_ids = $postMarkReadsRequest->message_ids;
        $id = Auth::id();
        $messages = Message::where('to_id', $id)->whereIn('id', $message_ids)->get();

        if (count($messages)) {
            foreach ($messages as $message) {
                $message->read_at = null;
                $message->save();
            }
        }

        return $this->successResponseMessage([], 200, 'Mark as unread successfully!');
    }

    /**
     * @param PostMarkReadsRequest $postMarkReadsRequest
     */
    public function deletes(PostMarkReadsRequest $postMarkReadsRequest)
    {
        $message_ids = $postMarkReadsRequest->message_ids;
        $id = Auth::id();
        $messages = Message::where('to_id', $id)->whereIn('id', $message_ids)->get();

        if (count($messages)) {
            foreach ($messages as $message) {
                $message->delete();
            }
        }

        return $this->successResponseMessage([], 200, 'Delete successfully!');
    }
}
