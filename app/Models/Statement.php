<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    const S_DRAFT = 1;
    const S_PUBLISH = 2;

    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function to()
    {
        return $this->belongsTo(Clinic::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(StatementItem::class);
    }
}
