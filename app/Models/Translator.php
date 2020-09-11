<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translator extends Model
{
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function languages() {
        return $this->hasMany(TranslatorLanguage::class, 'translator_id');
    }
}
