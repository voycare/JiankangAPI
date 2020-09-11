<?php

namespace App;

use App\Models\ClinicCertificate;
use App\Models\ClinicLanguage;
use App\Models\ClinicProfile;
use App\Models\Doctor;
use App\Models\Review;
use App\Models\SettingNotification;
use App\Models\SummaryReview;
use App\Models\UserAddress;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    // Verify.
    const VERIFY_PENDING = 0;
    const VERIFY_APPROVED = 1;
    const VERIFY_DECLINED = 2;
    // Role.
    const ROLE_CLINIC = 1;
    const ROLE_ADMIN = 2;
    const ROLE_CLIENT = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone', 'email', 'first_name', 'last_name', 'gender', 'phone', 'avatar', 'role', 'type', 'password', 'birthday', 'provide_id', 'verify', 'country', 'city', 'rate', 'description'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @return array
     */
    public static function getGenderOptions()
    {
        return [
            0 => 'Nothing',
            1 => 'Male',
            2 => 'Female',
            3 => 'Other'
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function setting()
    {
        return $this->hasOne(SettingNotification::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function summaryReview()
    {
        return $this->hasOne(SummaryReview::class, 'clinic_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'clinic_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function address()
    {
        return $this->hasOne(UserAddress::class, 'user_id');
    }

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
