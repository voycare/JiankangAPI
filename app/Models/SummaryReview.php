<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SummaryReview extends Model
{
    public $timestamps = false;
    protected $table = 'summary_reviews';
    protected $fillable = ['star_5', 'star_4', 'star_3', 'star_2', 'star_1', 'star', 'clinic_id'];
    protected $guarded = ['id'];
}
