<?php


namespace App\Http\Controllers;


use App\Http\Resources\UserResource;
use App\Models\SettingNotification;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingNotificationController extends Controller
{
    use ApiResponser;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $user = Auth::user();
        if (!$user) {
            return $this->errorResponse('User Not Found!', 404);
        }
        $setting = SettingNotification::where('user_id', Auth::id())->first();

        return $this->successResponseMessage($setting ? $setting->toArray() : [], 200, 'Get setting notifications');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSetting(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return $this->errorResponse('User Not Found!', 404);
        }

        $setting = SettingNotification::where('user_id', Auth::id())->first();
        $data = $request->all();
        if ($setting) {
            $setting->update($data);
        } else {
            $data['user_id'] = Auth::id();
            SettingNotification::create($data);
        }

        return $this->successResponseMessage($setting ? $setting->toArray() : [], 200, 'Setting notification success');
    }
}
