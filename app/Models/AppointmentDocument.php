<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentDocument extends Model
{
    const SUPPORT = 'support';
    const TRANSLATE = 'translate';
    protected $guarded = ['id'];

}
