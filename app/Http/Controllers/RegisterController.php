<?php

namespace App\Http\Controllers;

use App\Consts;
use App\Http\Resources\UserResource;
use App\Jobs\CreateSettingNotification;
use App\Jobs\SendOTPJob;
use App\Models\SettingNotification;
use App\Traits\ApiResponser;
use App\Traits\MediaClass;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\JWTAuth;

class RegisterController extends Controller
{
    use MediaClass;
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

    //register normal
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);
        $request->request->set('role', 0);
        $password = Hash::make($request->password);
        $request->request->set('birthday', 0);
        if (!isset($request->role)) {
            $request->request->set('role', 0);
        }
        $request->request->set('password', $password);
        $user = User::create($request->all());
        if (isset($request->avatar) && $request->avatar != null) {
            $avatar = $this->upload(Consts::AVATAR, $request->avatar, $user->id);
            $user->avatar = $avatar;
            $user->save();
        }
        $data['token'] = $this->jwt->fromUser($user);
        $data['user'] = new UserResource($user);
        $otp = str_random(32);
        $user->otp = $otp;
        $user->save();
        $this->dispatch(new SendOTPJob($request->email, $otp, $user));
        SettingNotification::create([
            'user_id' => $user->id
        ]);
        return $this->successResponseMessage($data, 200, 'Register success');
    }

    public function registerSocial(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:users',
            'provide_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
        ]);
        $request->request->set('role', 0);
        $request->request->set('password', Hash::make(''));
        $request->request->set('birthday', 0);
        if (!isset($request->role)) {
            $request->request->set('role', 0);
        }
        $user = User::create($request->all());
        if (isset($request->avatar) && $request->avatar != null) {
            $avatar = $this->upload(Consts::AVATAR, $request->avatar, $user->id);
            $user->avatar = $avatar;
            $user->save();
        }
        $data['token'] = $this->jwt->fromUser($user);
        $data['user'] = new UserResource($user);
        $otp = str_random(32);
        $user->otp = $otp;
        $user->save();
        $this->dispatch(new SendOTPJob($request->email, $otp, $user));
        SettingNotification::create([
            'user_id' => $user->id
        ]);
        return $this->successResponseMessage($data, 200, 'Register social success');
    }

    public function active(Request $request)
    {
        $otp = $request->code;
        $user = User::where('otp', $otp)->where('verify', 0)->firstOrFail();
        $user->verify = 1;
        $user->otp = '';
        $user->save();
        return view('activeAccount');
    }

}
