<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
    public static function buildTagsDropdown()
    {
        $condition = Main::defaultCondition();
        $tags = Tags::where($condition)->pluck('title', 'id')->toArray();

        return  $tags;
    }
    public static function addToDatabase($tags)
    {
        $result = [];
        foreach ($tags as $value) {
            $hasTag = Tags::where(['id' => $value])->first();
            if (!$hasTag) {

                $hasTag = new Tags();
                $hasTag->title = $value;
                $hasTag->slug = Str::slug($value, '-', null);
                $hasTag->created_at = Carbon::now();
                $hasTag->updated_at = Carbon::now();
                $hasTag->save();
            }
            $result[] = $hasTag->id;
        }
        return $result;
    }

    public function articles(): MorphToMany
    {
        return $this->morphedByMany('App\Models\Article', 'taggable', 'taggables', 'model_id');
    }

    /**
     * Get all of the videos that are assigned this tag.
     */
    public function products(): MorphToMany
    {
        return $this->morphedByMany('App\Models\Product', 'taggable', 'taggables', 'model_id');
    }

}
