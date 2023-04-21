<?php

namespace App\Models;

use App\Domains\Auth\Models\User;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Share;

class Post extends Model
{
    use HasFactory, HasSlug, SoftDeletes, \Conner\Likeable\Likeable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'user_id'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['share_link'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * @var string[]
     */
    protected $with = [
        'user',
        'video'
    ];

    /**
     * Get the share_links attribute
     *
     * @return array
     */
    public function getShareLinkAttribute()
    {
        $url = route('frontend.galery.show', ['slug' => $this->slug]);
        $links = Share::page($url, $this->title)
            ->facebook()
            ->twitter()
            ->linkedin()
            ->whatsapp()
            ->getRawLinks();
        return $links;
    }

    /**
     * Get the user that owns the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the video associated with the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function video(): HasOne
    {
        return $this->hasOne(Video::class, 'post_id', 'id');
    }

    public function hasVideo()
    {
        return $this->video;
    }
}
