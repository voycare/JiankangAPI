<?php


namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    const PUBLISHED = 1;
    const DRAFT = 0;
    protected $table = 'news';
    protected $guarded = ['id'];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::creating(function ($model) {
            $model->slug = Str::slug($model->title);
        });

        static::saving(function ($model) {
            $model->slug = Str::slug($model->title);
        });

        static::deleting(function ($model) {
            @unlink(storage_path($model->thumbnail));
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories()
    {
        return $this->belongsToMany(NewsCategory::class, 'news_category', 'news_id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
