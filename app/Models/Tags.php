<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Main
{

    use HasFactory;

    protected $fillable = [

        'title',
        'en_title',
        'description',
        'seo_title',
        'seo_description',
        'content_title',
        'slug',
        'status',
        'parent_id',
        'author_id',
        'redirect',
        'canonical',
        'sidebar',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function articles(): MorphToMany
    {
        return $this->morphedByMany('App\Models\Article', 'taggable','taggables','model_id');
    }

    /**
     * Get all of the videos that are assigned this tag.
     */
    public function products(): MorphToMany
    {
        return $this->morphedByMany('App\Models\Product', 'taggable','taggables','model_id');
    }

}
