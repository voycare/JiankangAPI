<?php

namespace App\Http\Controllers\Admin;

use App\Consts;
use App\Http\Requests\TranslatorStoreRequest;
use App\Http\Resources\CommonCollection;
use App\Http\Resources\TranslatorResource;
use App\Models\Translator;
use App\Models\TranslatorLanguage;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TranslatorController extends Controller
{
    use ApiResponser;

    /**
     * @return TranslatorController
     */
    public function languages()
    {
        $data = [];
        $data[] = [
            'id' => 1,
            'name' => 'English'
        ];
        $data[] = [
            'id' => 2,
            'name' => 'Mandarin'
        ];
        $data[] = [
            'id' => 3,
            'name' => 'Cantonese'
        ];
        $data[] = [
            'id' => 4,
            'name' => 'Ukrainian'
        ];
        $data[] = [
            'id' => 5,
            'name' => 'Russian'
        ];
        $data[] = [
            'id' => 6,
            'name' => 'Korean'
        ];
        $data[] = [
            'id' => 7,
            'name' => 'Thai'
        ];
        $data[] = [
            'id' => 8,
            'name' => 'Spanish'
        ];

        return $this->successResponse($data);
    }

    /**
     * @param $id
     * @return TranslatorController
     */
    public function show($id)
    {
        $translator = Translator::find($id);
        if (!$translator) {
            return $this->errorMessage('Translator not found', 404);
        }

        return $this->successResponse(TranslatorResource::make($translator));
    }

    /**
     * @return TranslatorController
     */
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $translators = Translator::paginate($limit);

        return $this->successResponse(new CommonCollection($translators));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(TranslatorStoreRequest $request)
    {
        $translator = Translator::updateOrCreate([
            'id' => $request->get('id')
        ], [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'wechat' => $request->get('wechat'),
            'phone' => $request->get('phone'),
            'current_location' => $request->get('current_location'),
            'nationality' => $request->get('nationality'),
            'national_id' => $request->get('national_id')
        ]);
        if ($translator) {
            if ($request->front_id) {
                $front_path = $translator->id . DIRECTORY_SEPARATOR . time() . '_front.' . $request->front_id->extension();
                if (!is_dir(public_path('translators'))) {
                    mkdir(public_path('translators'));
                }
                $request->front_id->move(public_path('translators'), $front_path);
                $result = null;
                if ($front_path) {
                    $translator->front_id_path = $front_path;
                }
            }

            if ($request->back_id) {
                $back_path = $translator->id . DIRECTORY_SEPARATOR . time() . '_back.' . $request->back_id->extension();
                if (!is_dir(public_path('translators'))) {
                    mkdir(public_path('translators'));
                }
                $request->back_id->move(public_path('translators'), $back_path);
                $result = null;
                if ($back_path) {
                    $translator->back_id_path = $back_path;
                }
            }

            $translator->save();
        }

        $languages = $request->get('languages');
        if ($languages && count($languages)) {
            TranslatorLanguage::where('translator_id', $translator->id)->delete();
            foreach ($languages as $language) {
                $language_id = isset($language['id']) ? $language['id'] : $language['language_id'];
                TranslatorLanguage::create([
                    'translator_id' => $translator->id,
                    'language_id' => $language_id
                ]);
            }
        }

        return $this->successResponseMessage(TranslatorResource::make($translator), 200, 'Add Translator successfully!');
    }

    /**
     * @param $id
     * @return DoctorController|\Illuminate\Http\JsonResponse
     */
    public function remove($id)
    {
        $result = Translator::find($id);
        if (!$result) {
            return $this->errorMessage('Translator not found!', 404);
        }
        $result->delete();

        return $this->successResponseMessage([], 200, 'Translator delete successfull!');
    }
}
