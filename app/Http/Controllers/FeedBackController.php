<?php


namespace App\Http\Controllers;


use App\Http\Requests\FeedbackStoreRequest;
use App\Models\FeedBack;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class FeedBackController extends Controller
{
    use ApiResponser;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(FeedbackStoreRequest $request)
    {
        $feedback = FeedBack::create($request->all());
        return $this->successResponseMessage(new \stdClass(), 200, 'Create feedback success');
    }
}
