<?php

namespace App\Http\Controllers\Clinic;

use App\Consts;
use App\Http\Resources\StatementCollection;
use App\Http\Resources\StatementResource;
use App\Models\Statement;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StatementController extends Controller
{
    use ApiResponser;

    /**
     * @param Request $request
     * @return StatementController
     */
    public function index(Request $request)
    {
        $query = Statement::query();
        $query = $query->where('to_id', Auth::id());
        $limit = $request->has('limit') ? $request->get('limit') : Consts::LIMIT_ITEM_PAGE;
        $items = $query->paginate($limit);

        return $this->successResponse(new StatementCollection($items));
    }

    /**
     * @param $id
     * @return StatementController
     */
    public function show($id)
    {
        $item = Statement::where('to_id', Auth::id())->find($id);
        if (!$item) {
            return $this->errorMessage('Statement Not Found!', 404);
        }

        return $this->successResponse(StatementResource::make($item));
    }
}
