<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicCertificate extends Model
{
    protected $guarded = ['id'];

    /**
     * @return string
     */
    public function getPathAttribute()
    {
        return env('URL_WEB') . '/' . $this->attributes['path'];
    }
}
