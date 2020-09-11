<?php

namespace App\Http\Controllers\Admin;

use App\Consts;
use App\Http\Resources\ReviewCollection;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $review = Review::find($id);
        if (!$review) {
            return $this->errorMessage('Review Not Found!', 404);
        }

        return $this->successResponse(ReviewResource::make($review));
    }

    /**
     * @param $id
     * @return ReviewController|\Illuminate\Http\JsonResponse
     */
    public function approve($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return $this->errorMessage('Review Not Found!', 404);
        }
        $review->status = Review::APPROVE;
        $review->save();

        return $this->successResponseMessage(ReviewResource::make($review), 200, 'Approve Review Succesfully!');
    }

    /**
     * @param $id
     * @return ReviewController|\Illuminate\Http\JsonResponse
     */
    public function decline($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return $this->errorMessage('Review Not Found!', 404);
        }
        $review->status = Review::DECLINE;
        $review->save();

        return $this->successResponseMessage(ReviewResource::make($review), 200, 'Decline Review Succesfully!');
    }
}
