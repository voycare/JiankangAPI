<?php

namespace App\Http\Controllers\Admin;

use App\Consts;
use App\Helpers\AppointmentHelper;
use App\Http\Requests\AppointmentDocumentUploadRequest;
use App\Http\Requests\AppointmentNoteAdminRequest;
use App\Http\Requests\AppointmentNoteRequest;
use App\Http\Requests\AppointmentSearchTotalRequest;
use App\Http\Requests\AppointmentUpdateStatusRequest;
use App\Http\Resources\AppointmentCancellationCollection;
use App\Http\Resources\AppointmentCollection;
use App\Http\Resources\AppointmentDocumentResource;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\AppointmentCancellation;
use App\Models\AppointmentDocument;
use App\Models\Doctor;
use App\Models\Interperter;
use App\Traits\ApiResponser;
use App\Traits\MediaClass;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    use ApiResponser;
    use MediaClass;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $type = $request->has('type') ? $request->type : '';
        $query = AppointmentHelper::index($request);

        // Filter by type 24h.
        switch ($type) {
            case '24h':
                $now = Carbon::now();
                $tomorrow = Carbon::tomorrow();
                $query = $query->where('date', '>=', $now)->where('date', '<=', $tomorrow);
                break;
            case '7d':
                $now = Carbon::now();
                $next_week = Carbon::now()->addDays(7);
                $query = $query->where('date', '>=', $now)->where('date', '<=', $next_week);
                break;
            case 'cr':
                $query = $query->where('status', Appointment::CANCELLED)->whereIn('state', [Appointment::PROCESSING, Appointment::DONE]);
                break;
        }

        $appointments = $query->paginate($limit);

        return $this->successResponseMessage(new AppointmentCollection($appointments), 200, 'Get Appointments success');
    }

    /**
     * @param $id
     * @param Request $request
     * @return AppointmentController
     */
    public function show($id)
    {
        $appt = Appointment::find($id);

        return $this->successResponse(AppointmentResource::make($appt));
    }

    /**
     * @param $id
     * @return AppointmentController|\Illuminate\Http\JsonResponse
     */
    public function notify($id)
    {
        $appt = Appointment::find($id);
        if (!$appt) {
            return $this->errorMessage('Appointment Not Found!', 404);
        }

        $id = Auth::id();
        $appt = $this->toggleNotifyId($appt, $id);

        return $this->successResponseMessage(AppointmentResource::make($appt));
    }

    /**
     * @param Appointment $appt
     * @param $user_id
     * @return Appointment
     */
    private function toggleNotifyId(Appointment $appt, $user_id)
    {
        $admin_notify_ids = $appt->admin_notify_ids;
        $admin_notify_ids = $admin_notify_ids ? json_decode($admin_notify_ids) : [];
        if (!in_array($user_id, $admin_notify_ids)) {
            $admin_notify_ids[] = $user_id;
        } else {
            foreach ($admin_notify_ids as $i => $k) {
                if ($k == $user_id) {
                    unset($admin_notify_ids[$i]);
                }
            }
        }
        $appt->admin_notify_ids = json_encode($admin_notify_ids);
        $appt->save();

        return $appt;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function notifyAll(Request $request)
    {
        $type = isset($request->type) ? $request->type : '';
        switch ($type) {
            case '24h':
                $now = Carbon::now();
                $tomorrow = Carbon::tomorrow();
                $appts = Appointment::where('date', '>=', $now)->where('date', '<=', $tomorrow)->get();
                $id = Auth::id();
                if (count($appts)) {
                    foreach ($appts as $appt) {
                        $this->toggleNotifyId($appt, $id);
                    }
                }
                break;
        }

        return $this->successResponseMessage(AppointmentResource::make($appt));
    }

    /**
     * @param $id
     * @param AppointmentDocumentUploadRequest $request
     * @return AppointmentController
     */
    public function uploadDocument($id, AppointmentDocumentUploadRequest $request)
    {
        $appt = Appointment::find($id);
        if (!$appt) {
            return $this->errorMessage('Appointment Not Found!', 404);
        }

        $doc = isset($request->doc) ? $request->doc : null;
        $type = isset($request->type) ? $request->type : AppointmentDocument::SUPPORT;
        $full_path = '';
        if ($doc) {
            $full_path = $this->upload(Consts::DOCUMENTS, $doc, $appt->id);
        }

        $record = null;
        if ($full_path) {
            $record = AppointmentDocument::create([
                'type' => $type,
                'name' => $doc->getClientOriginalName(),
                'admin_id' => Auth::id(),
                'appointment_id' => $id,
                'path' => $full_path
            ]);
        }

        return $this->successResponse($record);
    }

    /**
     * @param $id
     * @param Request $request
     * @return AppointmentController|\Illuminate\Http\JsonResponse
     */
    public function updateNote($id, AppointmentNoteRequest $request)
    {
        $appt = Appointment::find($id);
        if (!$appt) {
            return $this->errorMessage('Appointment Not Found!', 404);
        }
        
        $appt->note = $request->get('note');
        $appt->save();

        return $this->successResponseMessage(AppointmentResource::make($appt));
    }

    /**
     * @param $id
     * @param Request $request
     * @return AppointmentController|\Illuminate\Http\JsonResponse
     */
    public function updateNoteAdmin($id, AppointmentNoteAdminRequest $request)
    {
        $appt = Appointment::find($id);
        if (!$appt) {
            return $this->errorMessage('Appointment Not Found!', 404);
        }

        $appt->note_admin = $request->get('note_admin');
        $appt->save();

        return $this->successResponseMessage(AppointmentResource::make($appt));
    }

    /**
     * @param $id
     * @param Request $request
     * @return AppointmentController
     */
    public function updateInterpreter($id, Request $request)
    {
        $appt = Appointment::find($id);
        if (!$appt) {
            return $this->errorMessage('Appointment Not Found!', 404);
        }

        if (!$appt) {
            return $this->errorMessage('Appointment Not Found!', 404);
        }
        $interpreter_id = isset($request->interpreter_id) ? $request->interpreter_id : null;
        if ($interpreter_id) {
            $appt->interpreter_id = $interpreter_id;
            $appt->save();
        }

        return $this->successResponse(AppointmentResource::make($appt));
    }

    /**
     * @param $id
     * @param AppointmentUpdateStatusRequest $request
     * @return AppointmentController|\Illuminate\Http\JsonResponse
     */
    public function updateStatus($id, AppointmentUpdateStatusRequest $request)
    {
        $appt = Appointment::find($id);
        if (!$appt) {
            return $this->errorMessage('Appointment Not Found!', 404);
        }

        $message = 'Update Appointment Status Successfull!';
        $error_message = '';

        Appointment::updateStatusClient($appt, $request->get('status'), $message, $error_message, $request->get('schedule_item_id'));
        if ($error_message) {
            return $this->errorMessage($message, 403);
        }

        return $this->successResponseMessage(new AppointmentResource($appt), 200, $message);
    }

    /**
     * @param $id
     * @return AppointmentController
     */
    public function documents($id)
    {
        $appt = Appointment::find($id);
        if (!$appt) {
            return $this->errorMessage('Appointment Not Found!', 404);
        }

        $documents = AppointmentDocument::where('appointment_id', $id)->get();
        $data_documents = [];
        foreach ($documents as $document) {
            $data_documents[] = AppointmentDocumentResource::make($document);
        }

        return $this->successResponse($data_documents);
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
}
