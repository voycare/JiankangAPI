<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewCategory extends Model
{
    protected $table = 'news_category';
    protected $guarded = ['id'];
    public $timestamps = false;
}
