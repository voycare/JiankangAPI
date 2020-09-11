<?php


namespace App\Http\Controllers\Admin;


use App\Consts;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentCollection;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\ClinicCollection;
use App\Http\Resources\ClinicResource;
use App\Http\Resources\DoctorCollection;
use App\Http\Resources\FAQResource;
use App\Http\Resources\NewsResource;
use App\Jobs\DeleteDoctorJob;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\FAQ;
use App\Models\News;
use App\Traits\ApiResponser;
use App\Traits\MediaClass;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use ApiResponser;
    use MediaClass;

    public function createClinic(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password' => 'required|min:6',
            'country' => 'required',
            'address' => 'required'
        ]);
        $request->request->set('first_name', $request->name);
        $request->request->set('role', 1);
        $request->request->set('verify', 1);
        $password = Hash::make($request->password);
        $request->request->set('password', $password);
        $user = User::create($request->all());
        if (isset($request->avatar) && $request->avatar != null) {
            $avatar = $this->upload(Consts::AVATAR, $request->avatar, $user->id);
            $user->avatar = $avatar;
            $user->save();
        }
        return $this->successResponseMessage(new ClinicResource($user), 200, 'Register success');
    }

    public function getListClinic(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $key = isset($request->key) ? $request->key : '';
        $country = isset($request->country) ? $request->country : '';
        $clinics = User::when($key, function ($query) use ($key) {
            return $query->where('first_name', 'like', '%' . $key . '%');
        })->when($country, function ($query) use ($country) {
            return $query->where('country', $country);
        })
            ->where('role', Consts::TYPE_CLINIC)->orderBy('rate', 'DESC')->orderBy('created_at', 'DESC')->paginate($limit);
        return $this->successResponseMessage(new ClinicCollection($clinics), 200, 'Get list clinics success');
    }

    public function getListDoctor(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $doctors = Doctor::orderBy('created_at', 'DESC')->paginate($limit);
        return $this->successResponseMessage(new DoctorCollection($doctors), 200, 'Get list doctors success');
    }

    public function getListClient(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $clinics = User::where('role', Consts::TYPE_CLIENT)->orderBy('created_at', 'DESC')->paginate($limit);
        return $this->successResponseMessage(new ClientCollection($clinics), 200, 'Get list client success');
    }

    public function deleteClinic(Request $request)
    {
        User::where('id', $request->id)->delete();
        $this->dispatch(new DeleteDoctorJob($request->id));
        return $this->successResponseMessage(new \stdClass(), 200, 'Delete clinic success');
    }

    public function deleteDoctor(Request $request)
    {
        Doctor::where('id', $request->id)->delete();
        return $this->successResponseMessage(new \stdClass(), 200, 'Delete clinic success');
    }

    public function getAppointments(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $type_id = $request->type_id;
        $sortDate = $request->sort_created;
        $appointments = Appointment::where('type_id', $type_id)->orderBy('created_at', $sortDate)->paginate($limit);
        return $this->successResponseMessage(new AppointmentCollection($appointments), 200, 'Get appointments success');
    }

    public function logout(Request $request)
    {
        Config::set('auth.defaults.guard', 'admins');
        Auth::logout();
        return $this->successResponseMessage(new \stdClass(), 200, "Logout success");
    }

    public function createNews(Request $request)
    {
        $news = News::create($request->all());
        return $this->successResponseMessage(new NewsResource($news), 200, 'Create news success');
    }

    public function createFAQ(Request $request)
    {
        $fqa = FAQ::create($request->all());
        return $this->successResponseMessage(new FAQResource($fqa), 200, 'Create fqa success');
    }

    /**
     * @param Request $request
     * @return AdminController
     */
    public function users(Request $request) {
        $users = User::whereIn('role', [User::ROLE_CLIENT, User::ROLE_CLINIC])->whereRaw('email LIKE ? OR id = ?', $request->query)->get();

        return $this->successResponse($users->toArray());
    }
}
