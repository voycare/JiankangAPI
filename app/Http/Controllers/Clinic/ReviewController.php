<?php

namespace App\Http\Controllers\Clinic;

use App\Consts;
use App\Http\Resources\ReviewCollection;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
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
        $query = Review::query();
        $query = $query->where('clinic_id', Auth::id());
        if ($sortDate) {
            $query = $query->orderBy('created_at', $sortDate);
        }
        $reviews = $query->paginate($limit);

        return $this->successResponseMessage(new ReviewCollection($reviews));
    }

    /**
     * @param $id
     * @return ReviewController|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $review = Review::where('clinic_id', Auth::id())->find($id);
        if (!$review) {
            return $this->errorMessage('Review Not Found!', 404);
        }

        return $this->successResponse(ReviewResource::make($review));
    }
}
