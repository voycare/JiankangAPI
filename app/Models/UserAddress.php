<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $appends = ['full_address'];
    protected $guarded = ['id'];

    /**
     * @return string
     */
    public function getFullAddressAttribute()
    {
        $country = $this->country;
        $city = $this->city;

        return implode(', ', [$city, $country]);
    }
}
