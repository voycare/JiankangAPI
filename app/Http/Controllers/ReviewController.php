<?php


namespace App\Http\Controllers;


use App\Consts;
use App\Http\Resources\ReviewCollection;
use App\Http\Resources\ReviewResource;
use App\Jobs\UpdateStarReview;
use App\Models\Review;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
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
        $query = Review::query()->where('client_id', Auth::id());
        if ($sortDate) {
            $query = $query->orderBy('created_at', $sortDate);
        }
        $reviews = $query->paginate($limit);

        return $this->successResponseMessage(new ReviewCollection($reviews));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createReview(Request $request)
    {
        $this->validate($request, [
            'star' => 'required',
            'title' => 'required',
            'content' => 'required',
            'clinic_id' => 'required'
        ]);
        $request->request->set('client_id', Auth::id());
        $review = Review::create($request->all());
        $this->dispatch(new UpdateStarReview($request->clinic_id, $request->star));
        return $this->successResponseMessage(new ReviewResource($review), 200, 'Create review success');
    }

    /**
     * @param $id
     * @param Request $request
     * @return ReviewController
     */
    public function show($id, Request $request)
    {
        $review = Review::where('client_id', Auth::id())->find($id);

        return $this->successResponse(new ReviewResource($review));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getReviews(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $this->validate($request, [
            'clinic_id' => 'required'
        ]);
        $reviews = Review::where('clinic_id', $request->clinic_id)->orderBy('created_at', 'DESC')->paginate($limit);

        return $this->successResponseMessage(new ReviewCollection($reviews), 200, 'Get reviews success');
    }
}
