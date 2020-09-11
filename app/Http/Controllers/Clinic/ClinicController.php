<?php


namespace App\Http\Controllers\Clinic;


use App\Consts;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorCollection;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Models\SummaryReview;
use App\Traits\ApiResponser;
use App\Traits\MediaClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClinicController extends Controller
{
    use ApiResponser;
    use MediaClass;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createDoctor(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:doctors',
            'first_name' => 'required',
            'password' => 'required|min:6',
        ]);
        if (!isset($request->clinic_id)) {
            if (isset(Auth::user()->role)) {
                $request->request->set('clinic_id', Auth::id());
            }
        }
        $password = Hash::make($request->password);
        $request->request->set('birthday', 0);
        $request->request->set('password', $password);
        $doctor = Doctor::create($request->all());
        if (isset($request->avatar) && $request->avatar != null) {
            $avatar = $this->upload(Consts::DOCTOR, $request->avatar, $doctor->id);
            $doctor->avatar = $avatar;
            $doctor->save();
        }
        return $this->successResponseMessage(new DoctorResource($doctor), 200, 'Register success');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListDoctor(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $doctors = Doctor::where('clinic_id', Auth::id())->orderBy('created_at', 'DESC')->paginate($limit);
        return $this->successResponseMessage(new DoctorCollection($doctors), 200, 'Get list doctors success');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getReviewSummary(Request $request)
    {
        $this->validate($request, [
            'clinic_id' => 'required'
        ]);
        $summmary = SummaryReview::select('star', 'star_1', 'star_2', 'star_3', 'star_4', 'star_5')->where('clinic_id', $request->clinic_id)->first();
        if ($summmary) {
            $data = $summmary;
        } else {
            $data = new \stdClass();
            $data->star = 0;
            $data->star_1 = 0;
            $data->star_2 = 0;
            $data->star_3 = 0;
            $data->star_4 = 0;
            $data->star_5 = 0;
        }
        return $this->successResponseMessage($data, 200, 'Get summary review success');
    }
}
