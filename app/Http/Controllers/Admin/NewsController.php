<?php

namespace App\Http\Controllers\Admin;

use App\Consts;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\NewsStoreRequest;
use App\Http\Resources\CommonCollection;
use App\Http\Resources\NewsCollection;
use App\Http\Resources\NewsResource;
use App\Models\NewCategory;
use App\Models\NewsCategory;
use App\Models\News;
use App\Traits\ApiResponser;
use App\Traits\MediaClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    use ApiResponser;
    use MediaClass;

    /**
     * @param Request $request
     * @return NewsController
     */
    public function index(Request $request)
    {
        $query = News::query();
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $news = $query->orderBy('created_at', 'DESC')->paginate($limit);

        return $this->successResponse(new NewsCollection($news));
    }

    /**
     * @param Request $request
     * @return NewsController
     */
    public function categories(Request $request)
    {
        $categories = NewsCategory::get();

        return $this->successResponse($categories->toArray());
    }

    /**
     * @param Request $request
     * @return NewsController
     */
    public function storeCategory(CategoryStoreRequest $request)
    {
        $category = NewsCategory::updateOrCreate([
            'name' => $request->get('name')
        ]);

        return $this->successResponse($category);
    }

    /**
     * @param $id
     * @return NewsController
     */
    public function show($id)
    {
        $new = News::find($id);
        if (!$new) {
            return $this->errorMessage('News Not Found!', 404);
        }

        return $this->successResponse(NewsResource::make($new));
    }

    /**
     * @param Request $request
     * @return NewsController
     */
    public function store(NewsStoreRequest $request)
    {
        $id = $request->has('id') ? $request->get('id') : null;
        $data = [
            'title' => $request->get('title'),
            'publish_date' => Carbon::createFromTimestamp($request->get('publish_date')),
            'content' => $request->get('content'),
            'source' => $request->get('source'),
            'status' => $request->get('status'),
            'author_id' => Auth::id()
        ];
        if (!$id) {
            $news = News::create($data);
        } else {
            $news = News::find($id);
            $news->fill($data);
        }

        if (!$news) {
            return $this->errorMessage('News Not Found!', 404);
        }

        if ($request->has('category_ids')) {
            NewCategory::where('news_id', $news->id)->delete();
            $category_ids = $request->get('category_ids');
            if (count($category_ids)) {
                foreach ($category_ids as $category_id) {
                    if (intval($category_id)) {
                        NewCategory::create([
                            'news_id' => $news->id,
                            'category_id' => $category_id
                        ]);
                    }
                }
            }
        }

        if ($request->has('tags')) {
            $news->tags = $request->get('tags');
        }

        if ($news && $request->has('main_image')) {
            $image_name = $news->id . DIRECTORY_SEPARATOR . time() . '.' . $request->image->extension();
            if (!is_dir(public_path('news'))) {
                mkdir(public_path('news'));
            }
            $image_path = 'news' . DIRECTORY_SEPARATOR . $news->id;
            if (!is_dir(public_path($image_path))) {
                mkdir(public_path($image_path));
            }
            $request->main_image->move(public_path($image_path), $image_name);
            $news->thumbnail = 'news' . DIRECTORY_SEPARATOR . $image_name;
        }

        $news->save();

        return $this->successResponseMessage(NewsResource::make($news), 200, 'Update News Successfully!');
    }

    /**
     * @param $id
     * @return NewsController
     */
    public function delete($id)
    {
        $new = News::find($id);
        if (!$new) {
            return $this->errorMessage('News Not Found!', 404);
        }
        $new->delete();

        $this->successResponseMessage([], 200, 'Delete News Successfully!');
    }
}
