<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    const C_TYPE_ONLINE = 1;
    const C_TYPE_SITE_VISIT = 2;
    const P_TYPE_VISA = 1;
    const P_TYPE_ALIPAY = 2;
    const P_TYPE_WE_CHAT = 3;
    const S_DRAFT = 1;
    const S_PUBLISH = 2;

    protected $guarded = ['id'];

    /**
     * @param null $ctypeId
     * @return string
     */
    public static function getCTypeName($ctypeId = null)
    {
        switch ($ctypeId) {
            case self::C_TYPE_ONLINE:
                return 'Online';
                break;
            case self::C_TYPE_SITE_VISIT:
                return 'Site Visit';
                break;
        }
    }

    /**
     * @param null $pTypeId
     * @return string
     */
    public static function getPTypeName($pTypeId = null)
    {
        switch ($pTypeId) {
            case self::P_TYPE_VISA:
                return 'Visa';
                break;
            case self::P_TYPE_ALIPAY:
                return 'Alipay';
                break;
            case self::P_TYPE_WE_CHAT:
                return 'Wechat';
                break;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clinic()
    {
        return $this->belongsTo(User::class, 'clinic_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(PaymentItem::class);
    }

    /**
     * @param $value
     * @return false|int
     */
    public function getCreatedAtAttribute($value)
    {
        return strtotime($value);
    }

    /**
     * @param $value
     * @return false|int
     */
    public function getUpdatedAtAttribute($value)
    {
        return strtotime($value);
    }

    /**
     * @return array
     */
    public static function getPaymentsOptions()
    {
        return [
            self::P_TYPE_VISA => 'Visa',
            self::P_TYPE_ALIPAY => 'Alipay',
            self::P_TYPE_WE_CHAT => 'Wechat'
        ];
    }
}
