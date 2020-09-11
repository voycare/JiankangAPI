<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicService extends Model
{
    const ONLINE_CONSULATION = 1;
    const SITE_VISIT = 2;

    protected $guarded = ['id'];
}
