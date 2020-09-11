<?php

namespace App\Http\Controllers\Admin;

use App\Consts;
use App\Helpers\AppHelper;
use App\Helpers\ClinicHelper;
use App\Http\Requests\ClinicStoreRequest;
use App\Http\Resources\ClinicCollection;
use App\Http\Resources\ClinicResource;
use App\Http\Resources\CommonCollection;
use App\Models\Clinic;
use App\Models\ClinicCertificate;
use App\Models\ClinicLanguage;
use App\Models\ClinicProfile;
use App\Models\Doctor;
use App\Models\Payment;
use App\Models\Review;
use App\Models\UserAddress;
use App\Traits\ApiResponser;
use App\Traits\MediaClass;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClinicController extends Controller
{
    const RATING = 1;
    const REVENUE = 2;
    use MediaClass;
    use ApiResponser;

    /**
     * @param Request $request
     * @return ClinicController
     */
    public function applicants(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $clinics = Clinic::where('verify', '!=', User::VERIFY_APPROVED)->where('role', User::ROLE_CLINIC)->paginate($limit);

        return $this->successResponse(new ClinicCollection($clinics));
    }

    /**
     * @param Request $request
     * @return ClinicController
     */
    public function approved(Request $request)
    {
        $query = Clinic::query();
        $clinics = ClinicHelper::getClinicsApproved($query, $request);

        return $this->successResponse(new ClinicCollection($clinics));
    }

    /**
     * @param $id
     * @return ClinicController
     */
    public function show($id)
    {
        $clinic = Clinic::where('role', User::ROLE_CLINIC)->find($id);
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        return $this->successResponse(ClinicResource::make($clinic));
    }

    /**
     * @param $id
     * @param Request $request
     * @return ClinicController
     */
    public function update($id, ClinicStoreRequest $request)
    {
        $clinic = Clinic::where('role', User::ROLE_CLINIC)->find($id);
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        $clinic = ClinicHelper::store($clinic, $request);

        return $this->successResponseMessage(ClinicResource::make($clinic), 200, 'Clinic Update Successfull!');
    }

    /**
     * @param $type
     * @param $image_base64
     * @param $user_id
     * @return string
     */
    public function upload($type, $image_base64, $user_id)
    {
        // type: 0: avatar
        $path = $user_id;
        switch ($type) {
            case Consts::DOCUMENTS:
                $type_action = 'documents';
                break;
            case Consts::CERTIFICATE:
                $type_action = 'certificates';
                break;
            case Consts::AVATAR:
                $type_action = 'avatars';
                break;
            case Consts::DOCTOR:
                $type_action = 'doctors';
                break;
            default:
                $type_action = 'certificates';
        }
        @list(, $image_base64) = explode(',', $image_base64);
        $filename = Str::random(3);
        //generating unique file name;
        $file_name = 'image_' . $filename . '.jpeg';
        $link = '';
        if ($image_base64 != "") { // storing image in storage/app/public Folder
            $data = new \stdClass();
            $data->action = $type_action;
            $data->path = $path . '/' . $file_name;
            $data->base64 = ($image_base64);
            $this->processMedia($data);
            $link = '/' . $type_action . '/' . $path . '/' . $file_name;
        }
        return $link;
    }

    /**
     * @param $id
     * @return ClinicController
     */
    public function approve($id)
    {
        $clinic = User::where('role', User::ROLE_CLINIC)->where('verify', '!=', User::VERIFY_APPROVED)->find($id);
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        $clinic->verify = User::VERIFY_APPROVED;
        $clinic->save();

        return $this->successResponse(ClinicResource::make($clinic));
    }

    /**
     * @param $id
     * @return ClinicController
     */
    public function decline($id)
    {
        $clinic = User::where('role', User::ROLE_CLINIC)->where('verify', '!=', User::VERIFY_DECLINED)->find($id);
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        $clinic->verify = User::VERIFY_DECLINED;
        $clinic->save();

        return $this->successResponse(ClinicResource::make($clinic));
    }

    /**
     * @param $id
     * @return ClinicController|\Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $clinic = User::where('role', User::ROLE_CLINIC)->find($id);
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        $clinic->delete();

        return $this->successResponseMessage([], 200, 'Clinic delete successfully!');
    }

    /**
     * @param $id
     * @return ClinicController|\Illuminate\Http\JsonResponse
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
     * @return ClinicController
     */
    public function updateLanguage($id, Request $request)
    {
        $clinic = Clinic::find($id);
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
     * @param $id
     * @return ClinicController
     */
    public function doctors($id)
    {
        $clinic = Clinic::find($id);
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        $doctors = $clinic->doctors;
        $data = $doctors ? $doctors->toArray() : [];

        return $this->successResponse($data);
    }

    /**
     * @param $id
     * @param Request $request
     * @return ClinicController
     */
    public function updateDoctors($id, Request $request)
    {
        $clinic = Clinic::find($id);
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        $doctors = $request->doctors;
        Doctor::where('clinic_id', $id)->delete();
        if (count($doctors)) {
            foreach ($doctors as $item) {
                $doctor = Doctor::create([
                    'clinic_id' => $id,
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
     * @param $id
     * @param Request $request
     * @return ClinicController|\Illuminate\Http\JsonResponse
     */
    public function removeDoctor($id, Request $request)
    {
        $clinic = Clinic::find($id);
        if (!$clinic) {
            return $this->errorMessage('Clinic Not Found!', 404);
        }

        Doctor::where('clinic_id', $id)->where('id', $request->doctor_id)->delete();

        return $this->successResponseMessage([], 200, 'Delete Doctor Successfully!');
    }

    /**
     * @param Request $request
     * @return ClinicController
     */
    public function top(Request $request)
    {
        $items = [];
        switch ($request->get('type')) {
            case self::RATING:
                $query = Clinic::query();
                $query = $query->where('role', Clinic::ROLE_CLINIC);
                $query = $query->orderBy('total_reviews', 'DESC');
                $clinics = $query->limit(5)->get();
                if (count($clinics)) {
                    foreach ($clinics as $clinic) {
                        $items[] = ClinicResource::make($clinic);
                    }
                }
                break;
            case self::REVENUE:
                $query = Payment::query();
                $payments = $query->select(DB::raw('clinic_id, SUM(paid_amount) as total'))->groupBy('clinic_id')->orderBy('total', 'DESC')->limit(5)->get();
                if (count($payments)) {
                    foreach ($payments as $payment) {
                        $item = ClinicResource::make($payment->clinic);
                        $item->total = $payment->total;
                        $items[] = $item;
                    }
                }
                break;
        }

        return $this->successResponse($items);
    }
}
