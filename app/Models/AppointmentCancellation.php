<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AppointmentCancellation extends Model
{
    // status.
    const PROCESSING = 1;
    const DONE = 2;

    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
