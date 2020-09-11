<?php

namespace App\Http\Controllers\Clinic;

use App\Consts;
use App\Helpers\AppointmentHelper;
use App\Http\Requests\AppointmentRescheduleRequest;
use App\Http\Requests\AppointmentSearchTotalRequest;
use App\Http\Requests\AppointmentUpdateStatusRequest;
use App\Http\Resources\AppointmentClientResource;
use App\Http\Resources\AppointmentCollection;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\AppointmentSchedule;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    use ApiResponser;

    /**
     * @param Request $request
     * @return AppointmentCancellationController
     */
    public function index(Request $request)
    {
        $limit = $request->has('limit') ? $request->get('limit') : Consts::LIMIT_ITEM_PAGE;
        $query = AppointmentHelper::index($request);
        $query = $query->where('clinic_id', Auth::id());
        $items = $query->paginate($limit);

        return $this->successResponse(new AppointmentCollection($items));
    }

    /**
     * @param Request $request
     * @return AppointmentController
     */
    public function totals(AppointmentSearchTotalRequest $request)
    {
        $total = AppointmentHelper::totals($request);

        return $this->successResponse(compact('total'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return AppointmentController
     */
    public function show($id)
    {
        $appt = Appointment::where('clinic_id', Auth::id())->find($id);
        if (!$appt) {
            return $this->errorMessage('Appointment Not Found!', 404);
        }

        return $this->successResponse(AppointmentResource::make($appt));
    }

    /**
     * @param $id
     * @return AppointmentController
     */
    public function schedules($id)
    {
        $appt = Appointment::where('clinic_id', Auth::id())->find($id);

        if (!$appt) {
            return $this->errorMessage('Appointment Not Found!', 404);
        }


    }

    /**
     * @param $id
     * @param AppointmentRescheduleRequest $request
     * @return AppointmentController|\Illuminate\Http\JsonResponse
     */
    public function reschedule($id, AppointmentRescheduleRequest $request)
    {
        $appt = Appointment::where('clinic_id', Auth::id())->find($id);

        if (!$appt) {
            return $this->errorMessage('Appointment Not Found!', 404);
        }

        $check = AppointmentSchedule::where('appointment_id', $id)->where('accept', true)->first();
        if ($check) {
            return $this->errorMessage('The schedule time was accepted so you can\'t reschedule appointment time.', 405);
        }

        $options = $request->get('options');

        if (count($options)) {
            AppointmentSchedule::where('appointment_id', $id)->delete();

            foreach ($options as $option) {
                AppointmentSchedule::create([
                    'appointment_id' => $id,
                    'reschedule_time' => Carbon::createFromTimestamp($option['reschedule_time'])
                ]);
            }
        }

        return $this->successResponseMessage([], 200, 'Your new appointment availabilities have beed sent to your patient. Please wait for a confirmation.');
    }

    /**
     * @param $id
     * @param AppointmentUpdateStatusRequest $request
     * @return AppointmentController
     */
    public function updateStatus($id, AppointmentUpdateStatusRequest $request)
    {
        $appt = Appointment::where('clinic_id', Auth::id())->find($id);
        if (!$appt) {
            return $this->errorMessage('Appointment Not Found!', 404);
        }

        $message = 'Update Appointment Status Successfull!';
        $error_message = '';

        Appointment::updateStatusClinic($appt, $request->get('status'), $message, $error_message, $request->get('schedule_item_id'));
        if ($error_message) {
            return $this->errorMessage($message, 403);
        }

        return $this->successResponseMessage(new AppointmentClientResource($appt), 200, $message);
    }
}
