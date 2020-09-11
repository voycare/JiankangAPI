<?php

namespace App\Http\Controllers\Admin;

use App\Models\AppointmentDocument;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppointmentDocumentController extends Controller
{
    use ApiResponser;

    /**
     * @param $id
     * @param Request $request
     * @return AppointmentController
     */
    public function remove($id)
    {
        $record = AppointmentDocument::where('admin_id', Auth::id())->find($id);
        if (!$record) {
            return $this->errorMessage('Appointment Document Not Found!', 404);
        }

        @unlink(storage_path($record->path));
        $record->delete();

        return $this->successResponse([]);
    }
}
