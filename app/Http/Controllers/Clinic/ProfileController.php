<?php

namespace App\Http\Controllers\Clinic;

use App\Consts;
use App\Helpers\ClinicHelper;
use App\Http\Requests\ClinicServiceRequest;
use App\Http\Requests\ClinicStoreRequest;
use App\Http\Resources\ClinicResource;
use App\Models\Clinic;
use App\Models\ClinicLanguage;
use App\Models\Doctor;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use ApiResponser;

    /**
     * @return ProfileController|\Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $clinic = Clinic::where('role', User::ROLE_CLINIC)->find(Auth::id());
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        return $this->successResponse(ClinicResource::make($clinic));
    }

    /**
     * @param ClinicStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ClinicStoreRequest $request)
    {
        $clinic = Clinic::where('role', User::ROLE_CLINIC)->find(Auth::id());
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        $clinic = ClinicHelper::store($clinic, $request);

        return $this->successResponseMessage(ClinicResource::make($clinic), 200, 'Clinic Update Successfull!');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeLanguage($id)
    {
        $clinic_languge = ClinicLanguage::find($id);
        if (!$clinic_languge) {
            return $this->errorMessage('Clinic Language Not Found!', 404);
        }

        $clinic_languge->delete();

        return $this->successResponseMessage([], 200, 'Clinic language delete successfully!');
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLanguage(Request $request)
    {
        $clinic = Clinic::find(Auth::id());
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        $clinic_language = ClinicLanguage::updateOrCreate([
            'clinic_id' => $clinic->id,
            'language' => $request->language
        ]);

        return $this->successResponseMessage($clinic_language, 200, 'Clinic language delete successfully!');
    }

    /**
     * @return ProfileController|\Illuminate\Http\JsonResponse
     */
    public function doctors()
    {
        $clinic = Clinic::find(Auth::id());
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        $doctors = $clinic->doctors;
        $data = $doctors ? $doctors->toArray() : [];

        return $this->successResponse($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDoctors(Request $request)
    {
        $clinic = Clinic::find(Auth::id());
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        $doctors = $request->doctors;
        Doctor::where('clinic_id', $clinic->id)->delete();
        if (count($doctors)) {
            foreach ($doctors as $item) {
                $doctor = Doctor::create([
                    'clinic_id' => $clinic->id,
                    'name' => $item['name'],
                    'title' => $item['title'],
                    'bio' => $item['bio']
                ]);
                if (isset($item['avatar']) && $item['avatar'] !== null) {
                    if (Str::startsWith($item['avatar'], 'data:image')) {
                        $avatar = $this->upload(Consts::DOCTOR, $item['avatar'], $doctor->id);
                        $doctor->avatar = $avatar;
                        $doctor->save();
                    }
                }
            }
        }

        return $this->successResponseMessage([], 200, 'Update Doctors Successfully!');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeDoctor(Request $request)
    {
        $clinic = Clinic::find(Auth::id());
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        Doctor::where('clinic_id', $clinic->id)->where('id', $request->doctor_id)->delete();

        return $this->successResponseMessage([], 200, 'Delete Doctor Successfully!');
    }

    /**
     * @return ProfileController|\Illuminate\Http\JsonResponse
     */
    public function services() {
        $clinic = Clinic::find(Auth::id());
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        return $this->successResponse(ClinicResource::make($clinic));
    }

    /**
     * @param ClinicServiceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateServices(ClinicServiceRequest $request) {
        $clinic = Clinic::find(Auth::id());
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        $clinic = ClinicHelper::updateServices($clinic->id, $request);

        return $this->successResponseMessage(ClinicResource::make($clinic), 200, 'Update Clinic Service Successfully!');
    }
}
