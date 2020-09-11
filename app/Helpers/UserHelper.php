<?php
/**
 * Created by PhpStorm.
 * User: dinhln
 * Date: 7/7/20
 * Time: 14:32
 */

namespace App\Helpers;


use App\Models\UserAddress;
use App\User;
use Illuminate\Http\Request;

class UserHelper
{
    /**
     * @param User $user
     * @param Request $request
     * @return User
     */
    public static function storeClient(User $user, Request $request)
    {
        $user->first_name = isset($request->first_name) ? $request->first_name : $user->first_name;
        $user->last_name = isset($request->last_name) ? $request->last_name : $user->last_name;
        $user->gender = isset($request->gender) ? $request->gender : $user->gender;
        $user->birthday = isset($request->birthday) ? $request->birthday : $user->birthday;
        $user->phone = isset($request->phone) ? $request->phone : $user->phone;
        $user->save();

        $country = isset($request->country) ? $request->country : $user->country;
        if ($user && $country) {
            $city = isset($request->city) ? $request->city : $user->city;
            UserAddress::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'country' => $country,
                'city' => $city
            ]);
        }

        return $user;
    }
}