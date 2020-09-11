<?php

namespace App\Http\Controllers\Admin;

use App\Consts;
use App\Helpers\MessageHelper;
use App\Http\Requests\MessagesDeleteMultipleRequest;
use App\Http\Requests\MessageStoreRequest;
use App\Http\Resources\CommonCollection;
use App\Http\Resources\MessageCollection;
use App\Models\Message;
use App\Models\MessageState;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    use ApiResponser;

    /**
     * @param Request $request
     * @return CommonCollection
     */
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $admin_id = Auth::id();
        $query = Message::query();
        $type = $request->get('type');
        $query = $query->whereRaw('from_id = ? OR to_id = ?', [$admin_id, $admin_id]);
        $query = MessageHelper::index($query, $type);
        $items = $query->paginate($limit);

        return $this->successResponse(new MessageCollection($items));
    }

    /**
     * @param Request $request
     */
    public function save(MessageStoreRequest $request)
    {
        $admin_id = Auth::id();
        $id = $request->get('id');
        $message = null;
        if ($id) {
            $message = Message::find($id);
        }
        if (!$message) {
            $message = new Message();
            $message->subject = $request->get('subject');
            $message->from_id = $admin_id;
            $message->to_id = $request->get('to_id');
            $message->content = $request->get('content');
            $message->save();
        }

        if ($request->get('is_draft')) {
            MessageState::updateOrCreate([
                'message_id' => $message->id,
                'user_id' => $admin_id
            ], [
                'state' => MessageState::STATE_DRAFT
            ]);
        }

        return $this->successResponseMessage($message, 200, 'Add Message Successfully!');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletes(MessagesDeleteMultipleRequest $request)
    {
        $ids = $request->get('ids');

        $messages = Message::whereIn('id', $ids)->get();
        if (count($messages)) {
            foreach ($messages as $message) {
                $message->delete();
            }
        }

        return $this->successResponseMessage([], 200, 'Delete Messages Successfully!');
    }

    /**
     * @param $id
     * @return MessageController
     */
    public function delete($id)
    {
        $admin_id = Auth::id();
        $message = Message::find($id);
        if (!$message) {
            return $this->errorMessage('Message Not Found!', 404);
        }

        MessageState::updateOrCreate([
            'message_id' => $id,
            'user_id' => $admin_id
        ], [
            'state' => MessageState::STATE_TRASH
        ]);

        return $this->successResponseMessage([], 200, 'Delete Message Successfully!');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAll()
    {
        $admin_id = Auth::id();
        $msg_ids = MessageState::where('user_id', $admin_id)->where('state', MessageState::STATE_TRASH)->get()->pluck('message_id');
        if (count($msg_ids)) {
            Message::whereIn('message_id', $msg_ids)->delete();
        }

        return $this->successResponseMessage([], 200, 'Delete Message Successfully!');
    }
}
