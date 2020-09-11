<?php

namespace App\Http\Controllers;


use App\Http\Resources\DoctorResource;
use App\Http\Resources\UserResource;
use App\Models\Admin;
use App\Models\Doctor;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\JWTAuth;

class LoginController extends Controller
{
    use ApiResponser;
    protected $jwt;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->get('email'))->first();
        if (!$user) {
            return $this->errorMessage('User Not Found!', 404);
        }
        $token = $this->jwt->attempt($request->only('email', 'password'));
        if ($token == false) {
            return $this->successResponseMessage(new \stdClass(), 414, ["password" => "Password inccorect"]);
        } else {

            $data['token'] = $token;
            $data['user'] = new UserResource($user);
            if ($user->verify == 0) {
                return $this->successResponseMessage(new \stdClass(), 412, "Account not active");
            }
            return $this->successResponseMessage($data, 200, "Login success");
        }
    }

    public function loginSocial(Request $request)
    {
        $user = User::where('provide_id', $request->provide_id)->where('role', 0)->firstorFail();
        $token = $this->jwt->fromUser($user);

        $data['token'] = $token;
        $data['user'] = new UserResource($user);
        if ($user->verify == 0) {
            return $this->successResponseMessage(new \stdClass(), 412, "Account not active");
        }
        return $this->successResponseMessage($data, 200, "Login success");

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginAdmin(Request $request)
    {
        Config::set('auth.defaults.guard', 'admins');

        $admin = Admin::select('id', 'email', 'name')->where('email', $request->email)->firstorFail();
        $token = Auth::attempt($request->only('email', 'password'));
        if ($token == false) {
            return $this->successResponseMessage(new \stdClass(), 414, ["password" => "Password inccorect"]);
        } else {
            $data['token'] = $token;
            $data['admin'] = $admin;
            return $this->successResponseMessage($data, 200, "Login success");
        }

    }

}
