<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SettingNotification extends Model
{
    public $timestamps = false;
    protected $table = 'notification_settings';
    protected $fillable = ['user_id', 'consultation', 'site_visit', 'second_option', 'chat', 'call', 'appointments', 'message'];
    protected $guarded = ['id'];
}
