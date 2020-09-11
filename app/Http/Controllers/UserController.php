<?php


namespace App\Http\Controllers;


use App\Consts;
use App\Helpers\UserHelper;
use App\Http\Requests\PostChangePasswordRequest;
use App\Http\Requests\UserForgotPasswordRequest;
use App\Http\Resources\CareShortCollection;
use App\Http\Resources\ClinicCollection;
use App\Http\Resources\DetailClinicResource;
use App\Models\Care;
use App\Models\UserAddress;
use App\User;
use App\MyConst;
use App\Models\Patient;
use App\Traits\MediaClass;
use Tymon\JWTAuth\JWTAuth;
use App\Jobs\ForgotPassword;
use App\Models\Notification;
use App\Models\NurseProfile;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Jobs\CancelAccountJob;
use Elasticsearch\ClientBuilder;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\NotificationCollection;
use Str;

class UserController extends Controller
{
    use ApiResponser;
    use MediaClass;
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPass(UserForgotPasswordRequest $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if (!$user) {
            return $this->errorMessage('User Not Found!', 404);
        }
        $pass = Str::random(4) . '@' . Str::random(4);
        $this->dispatch(new ForgotPassword($pass, $user->email));
        $password = Hash::make($pass);
        $user->password = $password;
        $user->save();
        return $this->successResponseMessage(new \stdClass(), 200, 'Get password success');
    }

    /**
     * @param PostChangePasswordRequest $postChangePasswordRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(PostChangePasswordRequest $postChangePasswordRequest)
    {
        $data = [];
        $user = Auth::user();
        $old_password = $postChangePasswordRequest->get('old_password');
        if (Hash::make($old_password) != $user->password) {
            $data = new \stdClass();
            $status = 414;
            $message = ["password" => "Old password inccorect"];
        } else {
            $password = Hash::make($postChangePasswordRequest->new_password);
            User::where('id', $user->id)->update(['password' => $password]);
            $status = 200;
            $message = 'Change password successfull';
            $this->jwt->invalidate();
            $user = User::find($user->id);
            $this->jwt->invalidate();
            $data['token'] = $this->jwt->fromUser($user);
        }

        return $this->successResponseMessage($data, $status, $message);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $this->jwt->invalidate();
        return $this->successResponseMessage(new \stdClass(), 200, "Logout success");
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editProfile(Request $request)
    {
        $user = User::find(Auth::id());
        if (!$user) {
            return $this->errorMessage('Client Not Found', 404);
        }
        $avatar = $user->avatar;
        if (isset($request->avatar) && $request->avatar != null) {
            $avatar = $this->upload(Consts::AVATAR, $request->avatar, Auth::id());
        }
        $user->avatar = $avatar;
        $user = UserHelper::storeClient($user, $request);

        return $this->successResponseMessage(new UserResource($user), 200, 'Edit profile success');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getClinicDetail(Request $request)
    {
        $clinic = User::find($request->id);
        if (!$clinic) {
            return $this->errorMessage('User Not Found!', 404);
        }

        return $this->successResponseMessage(new DetailClinicResource($clinic), 200, 'Get detail clinic success');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function topClinicReviews(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $clinics = User::withCount('reviews')->orderBy('reviews_count', 'desc')->paginate($limit);

        return $this->successResponseMessage(new ClinicCollection($clinics, 'reviews_count'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function clientClinicFavouries(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : Consts::LIMIT_ITEM_PAGE;
        $clinics = User::where('id', Auth::id())->withCount('reviews')->orderBy('reviews_count', 'desc')->paginate($limit);

        return $this->successResponseMessage(new ClinicCollection($clinics, 'reviews_count'));
    }
}
