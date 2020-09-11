<?php


namespace App\Http\Controllers;


use App\Consts;
use App\Http\Resources\NewsCollection;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    use ApiResponser;

    /**
     * @param Request $request
     * @return NewsController
     */
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $news = News::where('status', News::PUBLISHED)->orderBy('created_at', 'DESC')->paginate($limit);

        return $this->successResponse(new NewsCollection($news));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $news = News::where('slug', $request->slug)->firstOrFail();

        return $this->successResponseMessage(new NewsResource($news), 200, 'Get news detail success');
    }
}
