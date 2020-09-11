<?php

namespace App\Http\Controllers\Admin;

use App\Consts;
use App\Helpers\UserHelper;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\ClientResource;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponser;
use App\Traits\MediaClass;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    use ApiResponser;
    use MediaClass;

    /**
     * @return ClientController
     */
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $sortDate = isset($request->sort_created) ? $request->sort_created : 'desc';
        $country = isset($request->country) ? $request->country : '';
        $client_id = $request->has('client_id') ? intval($request->get('client_id')) : '';
        $query = User::query()->where('role', User::ROLE_CLIENT);
        if ($client_id) {
            $query = $query->where('id', $client_id);
        }
        if ($country) {
            $query = $query->whereHas('address', function ($q) use ($country) {
                return $q->where('country', $country);
            });
        }
        $query = $query->orderBy('created_at', $sortDate);
        $clients = $query->paginate(intval($limit));

        return $this->successResponse(new ClientCollection($clients));
    }

    /**
     * @param $id
     * @return ClientController
     */
    public function show($id)
    {
        $client = User::where('role', User::ROLE_CLIENT)->find($id);
        if (!$client) {
            return $this->errorMessage('Client Not Found', 404);
        }

        return $this->successResponse(ClientResource::make($client));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $client = User::where('role', User::ROLE_CLIENT)->find($id);
        if (!$client) {
            return $this->errorMessage('Client Not Found', 404);
        }

        $avatar = $client->avatar;
        if (isset($request->avatar) && $request->avatar != null) {
            $avatar = $this->upload(Consts::AVATAR, $request->avatar, $id);
        }
        $client->avatar = $avatar;
        $client = UserHelper::storeClient($client, $request);

        return $this->successResponseMessage(new ClientResource($client), 200, 'Edit profile success');
    }

    /**
     * @param $id
     * @return ClientController|\Illuminate\Http\JsonResponse
     */
    public function remove($id)
    {
        $client = User::where('role', User::ROLE_CLIENT)->find($id);
        if (!$client) {
            return $this->errorMessage('Client Not Found', 404);
        }
        $client->delete();

        return $this->successResponseMessage([], 200, 'Remove Client success.');
    }
}
