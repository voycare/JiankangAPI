<?php

namespace App\Http\Controllers;

use App\Helpers\ClinicHelper;
use App\Http\Requests\ClinicCreateRequest;
use App\Http\Resources\ClinicCollection;
use App\Models\Clinic;
use App\Models\ClinicLanguage;
use App\Models\ClinicProfile;
use App\Models\UserAddress;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    use ApiResponser;

    /**
     * @param Request $request
     * @return ClinicController
     */
    public function index(Request $request)
    {
        $query = Clinic::query();
        $clinics = ClinicHelper::getClinicsApproved($query, $request);

        return $this->successResponse(new ClinicCollection($clinics));
    }

    /**
     * @param ClinicCreateRequest $request
     */
    public function store(ClinicCreateRequest $request)
    {
        $data = $request->except(['country', 'city', 'language_spokens']);
        $data['first_name'] = $data['name'];
        $data['last_name'] = '';
        $clinic = Clinic::create($data);
        if ($clinic) {
            ClinicProfile::create([
                'clinic_id' => $clinic->id,
                'title' => $data['title'],
                'type_clinic' => $data['type_clinic'],
                'contact_person' => $data['contact_person'],
                'website' => $data['website'],
                'year_in_business' => $data['year_in_business']
            ]);

            UserAddress::create([
                'user_id' => $clinic->id,
                'country' => $request->get('country'),
                'city' => $request->get('city')
            ]);

            foreach ($request->get('language_spokens') as $language_spoken) {
                ClinicLanguage::create([
                    'clinic_id' => $clinic->id,
                    'language' => $language_spoken
                ]);
            }
        }

        return $this->successResponseMessage($clinic ? $clinic : [], 200, 'Create Clinic Successfully!');
    }
}
