<?php

namespace App\Http\Controllers;

use App\Consts;
use App\Http\Requests\SubscriberStoreRequest;
use App\Http\Resources\CommonCollection;
use App\Http\Resources\SubscribeCollection;
use App\Http\Resources\SubscribeResource;
use App\Mail\UserSubscribed;
use App\Models\Subscriber;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    use ApiResponser;

    /**
     * @param Request $request
     * @return SubscriberController
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit', Consts::LIMIT_ITEM_PAGE);

        $query = Subscriber::query();
        $items = $query->paginate($limit);

        return $this->successResponse(new SubscribeCollection($items));
    }

    /**
     * @param SubscriberStoreRequest $request
     * @return SubscriberController
     */
    public function store(SubscriberStoreRequest $request)
    {
        $item = Subscriber::where('email', $request->get('email'))->first();
        if (!$item) {
            $item = Subscriber::create($request->all());
        }
        Mail::to($item->email)->send(new UserSubscribed());

        return $this->successResponse(SubscribeResource::make($item));
    }
}
