<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageState extends Model
{
    const STATE_DRAFT = 1;
    const STATE_TRASH = 2;
    protected $guarded = ['id'];
}
