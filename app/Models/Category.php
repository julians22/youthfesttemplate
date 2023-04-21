<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasSlug;

    public const MUSIC = 'Music';
    public const DANCE = 'Dance';
    public const ART_PERFORMANCE = 'Art Performance';
    public const MERCHANDISE_DESIGN = 'Merchandise Design';
    public const PHOTOGRAPHY = 'Photography';
    public const VIDEOGRAPHY = 'Videography';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
