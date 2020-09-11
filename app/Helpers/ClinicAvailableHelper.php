<?php
/**
 * Created by PhpStorm.
 * User: dinhln
 * Date: 8/8/20
 * Time: 09:23
 */

namespace App\Helpers;


use App\Consts;
use App\Http\Requests\ClinicAvaiableStoreRequest;
use App\Http\Requests\ClinicServiceRequest;
use App\Http\Requests\ClinicStoreRequest;
use App\Models\Clinic;
use App\Models\ClinicAvailable;
use App\Models\ClinicCertificate;
use App\Models\ClinicService;
use App\Models\ClinicTreatment;
use App\Models\UserAddress;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Psy\Util\Str;

class ClinicAvailableHelper
{
    /**
     * @param ClinicAvaiableStoreRequest $request
     * @return mixed
     */
    public static function store(ClinicAvaiableStoreRequest $request) {
        $clinic_available = $request->get('clinic_available');
        $record = ClinicAvailable::where('clinic_id', $clinic_available['clinic_id'])->find($clinic_available['id']);
        if ($record) {
            $record->type = $clinic_available['type'];
            $record->date = Carbon::createFromTimestamp($clinic_available['date']);
            $record->save();
        } else {
            $record = ClinicAvailable::create([
                'clinic_id' => $clinic_available['clinic_id'],
                'type' => $clinic_available['type'],
                'date' => Carbon::createFromTimestamp($clinic_available['date'])
            ]);
        }

        return $record;
    }
}