<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Requests\ClinicRemovePhotoRequest;
use App\Http\Requests\ClinicUploadRequest;
use App\Models\Clinic;
use App\Models\ClinicPhoto;
use App\Traits\ApiResponser;
use App\Traits\MediaClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClinicPhotoController extends Controller
{
    use ApiResponser, MediaClass;

    /**
     * @return ClinicPhotoController|\Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $clinic = Clinic::find(Auth::id());
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        $photos = ClinicPhoto::where('clinic_id', Auth::id())->get();

        return $this->successResponse($photos->toArray());
    }

    /**
     * @param $id
     * @param ClinicUploadRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadPhoto($id, ClinicUploadRequest $request)
    {
        $id = Auth::id();
        $clinic = Clinic::find($id);
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        $result = ClinicHelper::uploadPhoto($clinic->id, $request);

        return $this->successResponseMessage($result, 200, 'Clinic Photo Upload Successfully!');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(ClinicRemovePhotoRequest $request)
    {
        $id = Auth::id();
        $clinic = Clinic::find($id);
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        $photo = ClinicPhoto::where('clinic_id', $id)->where('id', $request->photo_id)->first();
        if ($photo) {
            @unlink(public_path('clinics') . DIRECTORY_SEPARATOR . $photo->path);
            $photo->delete();
        }

        return $this->successResponseMessage([], 200, 'Delte Clinic Photo Successfully!');
    }
}
