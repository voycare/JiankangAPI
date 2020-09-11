<?php
/**
 * Created by PhpStorm.
 * User: dinhln
 * Date: 8/8/20
 * Time: 09:23
 */

namespace App\Helpers;


use App\Consts;
use App\Http\Requests\ClinicServiceRequest;
use App\Http\Requests\ClinicStoreRequest;
use App\Http\Requests\ClinicUploadRequest;
use App\Models\Clinic;
use App\Models\ClinicCertificate;
use App\Models\ClinicPhoto;
use App\Models\ClinicService;
use App\Models\ClinicTreatment;
use App\Models\UserAddress;
use App\User;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Psy\Util\Str;

class ClinicHelper
{
    /**
     * @param $data
     */
    public static function processMedia($data)
    {
        if (!is_dir(storage_path($data->action))) {
            mkdir(storage_path($data->action));
        }
        Storage::disk($data->action)->put($data->path, base64_decode($data->base64));
    }

    /**
     * @param $type
     * @param $image_base64
     * @param $id
     * @return string
     */
    public static function upload($type, $image_base64, $id)
    {
        // type: 0: avatar
        $path = $id;
        switch ($type) {
            case Consts::CERTIFICATE:
                $type_action = 'certificates';
                break;
            case Consts::DOCUMENTS;
                $type_action = 'documents';
                break;
            case Consts::AVATAR:
                $type_action = 'avatars';
                break;
            case Consts::DOCTOR:
                $type_action = 'doctors';
                break;
            case Consts::NEWS:
                $type_action = 'news';
                break;
            case Consts::CLINICS:
                $type_action = 'clinics';
                break;
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
            self::processMedia($data);
            $link = DIRECTORY_SEPARATOR . $type_action . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $file_name;
        }
        return $link;
    }

    /**
     * @param Clinic $clinic
     * @param ClinicStoreRequest $request
     * @return Clinic
     */
    public static function store(Clinic $clinic, ClinicStoreRequest $request)
    {
        $specialty_id = isset($request->specialty_id) ? $request->specialty_id : '';
        if ($specialty_id) {
            ClinicProfile::updateOrCreate([
                'clinic_id' => $clinic->id
            ], [
                'specialty_id' => $specialty_id
            ]);
        }
        $street_line_1 = $request->street_line_1;
        $street_line_2 = $request->street_line_2;
        $city = $request->city;
        $state = $request->state;

        UserAddress::updateOrCreate([
            'user_id' => $clinic->id,
        ], compact('street_line_1', 'street_line_2', 'city', 'state'));

//        $languages = $clinic_data->languages;
//        if(count($languages)) {
//            ClinicLanguage::where('clinic_id', $clinic->id)->delete();
//
//            foreach ($languages as $language) {
//                ClinicLanguage::updateOrCreate([
//                    'clinic_id' => $clinic->id,
//                    'language' => $language['language']
//                ]);
//            }
//        }

        $certificates = $request->certificates;
        if (count($certificates)) {
            foreach ($certificates as $certificate) {
                $path = isset($certificate['path']) ? $certificate['path'] : '';
                if ($path) {
                    if (!$certificate->id) {
                        $full_path = '';
                        if ($path) {
                            $full_path = self::upload(Consts::CERTIFICATE, $certificate['path'], 0);
                        }
                        ClinicCertificate::create([
                            'clinic_id' => $clinic->id,
                            'name' => $certificate->name,
                            'description' => $certificate->description,
                            'path' => $full_path
                        ]);
                    } else {
                        if (strpos($path, 'data:image') === 0) {
                            $full_path = self::upload(Consts::CERTIFICATE, $certificate['path'], $certificate->id);

                            ClinicCertificate::updateOrCreate([
                                'id' => $certificate->id
                            ], [
                                'name' => $certificate->name,
                                'description' => $certificate->description,
                                'path' => $full_path
                            ]);
                        }
                    }
                }
            }
        }

        return $clinic;
    }

    /**
     * @param $id
     * @param ClinicServiceRequest $request
     * @return mixed
     */
    public static function updateServices($id, ClinicServiceRequest $request)
    {
        $data = $request->all();
        if (count($data['services'])) {
            ClinicService::where('clinic_id', $id)->delete();

            foreach ($data['services'] as $service) {
                ClinicService::updateOrCreate([
                    'clinic_id' => $id,
                    'type' => $service['type']
                ], [
                    'duration' => $service['duration'],
                    'price' => $service['price']
                ]);
            }
        }
        if (count($data['treatments'])) {
            ClinicTreatment::where('clinic_id', $id)->delete();

            foreach ($data['treatments'] as $treatment) {
                ClinicTreatment::create([
                    'clinic_id' => $id,
                    'type' => $treatment['type'],
                    'from' => $treatment['from'],
                    'description' => $treatment['description']
                ]);
            }
        }

        $clinic = Clinic::find($id);

        return $clinic;
    }

    /**
     * @param $id
     * @param ClinicUploadRequest $request
     * @return null
     */
    public static function uploadPhoto($id, ClinicUploadRequest $request)
    {
        $image_name = $id . DIRECTORY_SEPARATOR . time() . '.' . $request->image->extension();
        if (!is_dir(public_path('clinics'))) {
            mkdir(public_path('clinics'));
        }
        $image_path = 'clinics' . DIRECTORY_SEPARATOR . $id;
        if (!is_dir(public_path($image_path))) {
            mkdir(public_path($image_path));
        }
        $request->image->move(public_path($image_path), $image_name);
        $result = null;
        if ($image_name) {
            $result = ClinicPhoto::create([
                'clinic_id' => $id,
                'path' => 'clinics' . DIRECTORY_SEPARATOR . $image_name
            ]);
        }

        return $result;
    }

    /**
     * @param $query
     * @param Request $request
     * @return mixed
     */
    public static function getClinicsApproved($query, Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $query = $query->where('role', Clinic::ROLE_CLINIC);
        if ($request->has('search')) {
            if (intval($request->get('search'))) {
                $query = $query->where('id', $request->get('search'));
            } else {
                $query = $query->where('email', 'LIKE', '%' . $request->get('search') . '%');
            }
        }
        if ($request->has('type_id')) {
            $query = $query->whereHas('services', function ($q) use ($request) {
                return $q->where('id', $request->get('type_id'));
            });
        }
        if ($request->has('country')) {
            $query = $query->whereHas('address', function ($q) use ($request) {
                return $q->where('country', $request->get('country'));
            });
        }
        return $query->where('verify', User::VERIFY_APPROVED)->paginate($limit);
    }
}