<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreUserLocalizationRequest;
use App\Models\UserLocalization;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    use ApiResponser;
}
