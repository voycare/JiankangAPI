<?php

namespace App\Http\Controllers\Admin;

use App\Consts;
use App\Http\Resources\CommonCollection;
use App\Models\FeedBack;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
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
        $query = FeedBack::query();
        if ($sortDate) {
            $query = $query->orderBy('created_at', $sortDate);
        }
        $items = $query->paginate($limit);

        return $this->successResponseMessage(new CommonCollection($items));
    }
}
