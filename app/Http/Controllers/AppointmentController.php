<?php


namespace App\Http\Controllers;


use App\Consts;
use App\Http\Requests\AppointmentClientCreateRequest;
use App\Http\Requests\AppointmentUpdateStatusRequest;
use App\Http\Resources\AppointmentCollection;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\AppointmentCancellation;
use App\Models\Doctor;
use App\Traits\ApiResponser;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    use ApiResponser;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createAppointment(AppointmentClientCreateRequest $request)
    {
        $doctor = Doctor::find($request->doctor_id);
        if (!$doctor) {
            return $this->errorMessage('', 404);
        }
        $data = $request->all();
        $data['client_id'] = Auth::user()->id;
        $data['clinic_id'] = $doctor->clinic_id;
        $appointment = Appointment::create($data);

        return $this->successResponseMessage(new AppointmentResource($appointment), 200, 'Create appointment success');
    }

    /**
     * @param $id
     * @param Request $request
     * @return AppointmentController
     */
    public function show($id, Request $request)
    {
        $appt = Appointment::where('client_id', Auth::id())->find($id);

        return $this->successResponse(new AppointmentResource($appt));
    }

    /**
     * @param $id
     * @param Request $request
     */
    public function cancellationRequest($id, Request $request)
    {
        $appt = Appointment::where('client_id', Auth::id())->find($id);
        if (!$appt) {
            return abort(404);
        }

        AppointmentCancellation::updateOrCreate([
            'appointment_id' => $appt->id,
            'client_id' => Auth::id()
        ], [
            'why_cancel' => isset($request->why_cancel) ? $request->why_cancel : null,
            'note' => isset($request->note) ? $request->note : null,
            'provide_options' => isset($request->provide_options) ? $request->provide_options : null,
            'use_again' => isset($request->use_again) ? $request->use_again : null
        ]);

        return $this->successResponseMessage(new AppointmentResource($appt), 200, 'You will receive your refund in 5 to 7 business days. For questions, please contact us at support@hera.health');
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkCancelable($id)
    {
        $appt = Appointment::where('client_id', Auth::id())->find($id);

        if (
            $appt->status == Appointment::CONFIRMED
        ) {
            $now = Carbon::now();
            if ($now->diffInHours($appt->created_at) < 48) {
                return $this->errorResponse('Cannot cancel because appointment appointment is within less than 48 hours.', 200);
            }
        }

        return $this->successResponseMessage(new AppointmentResource($appt), 200, '');
    }

    /**
     * @param $id
     * @param AppointmentUpdateStatusRequest $request
     * @return AppointmentController
     */
    public function updateStatus($id, AppointmentUpdateStatusRequest $request)
    {
        $appt = Appointment::where('client_id', Auth::id())->find($id);
        $message = 'Update Appointment Status Successfull!';
        $error_message = '';

        Appointment::updateStatusClient($appt, $request->get('status'), $message, $error_message, $request->get('schedule_item_id'));
        if ($error_message) {
            return $this->errorMessage($error_message, 403);
        }

        return $this->successResponseMessage(new AppointmentResource($appt), 200, $message);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $sortDate = isset($request->sort_created) ? $request->sort_created : 'desc';
        $key = isset($request->key) ? $request->key : '';
        $country = isset($request->country) ? $request->country : '';
        $status_in = isset($request->status_in) ? $request->status_in : '';
        $query = User::query();
        $query = $query->select(['id', 'role', 'country'])->where('role', Consts::TYPE_CLINIC);
        if ($country) {
            $query = $query->where('country', $country);
        }
//        $clinic_ids = $query->get()->pluck('id')->toArray();
//        $query = Doctor::query();
//        $query = $query->select(['id', 'last_name', 'first_name']);
//        if ($key) {
//            $query = $query->where('first_name', 'like', '%' . $key . '%')
//                ->orWhere('last_name', 'like', '%' . $key . '%');
//        }
//        if (count($clinic_ids)) {
//            $query = $query->whereIn('clinic_id', $clinic_ids);
//        }
        $doctor_ids = []; //$query->get()->pluck('id')->toArray();
        $query = Appointment::query();
        $query = $query
            ->where('client_id', Auth::id())->orderBy('created_at', $sortDate);
        if (count($doctor_ids)) {
            $query = $query->whereIn('doctor_id', $doctor_ids);
        }
        if ($status_in) {
            $query = $query->whereIn('status', explode(',', $status_in));
        }

        $appointments = $query->paginate($limit);

        return $this->successResponseMessage(new AppointmentCollection($appointments), 200, 'Get Appointments success');
    }

    /**
     * @return AppointmentController
     */
    public function metas()
    {
        $result = [];
        $result['types'] = Appointment::getTypeOptions();
        $result['status'] = Appointment::getStatusOptions();
        $result['specialty'] = Appointment::getSpecialtyOptions();
        $result['fertility'] = Appointment::getFertilityOptions();
        $result['counseling'] = Appointment::getCounselingOptions();
        $result['treatment'] = array_merge($result['fertility'], $result['counseling']);
        $result['languages'] = [
            1 => 'English',
            2 => 'Chinese',
            3 => 'English/Chinese'
        ];

        return $this->successResponse($result);
    }

}
