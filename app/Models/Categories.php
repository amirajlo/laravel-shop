<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Main
{
    use HasFactory;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    protected $fillable = [
        'type',
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
    public function children()
    {
        return $this->hasMany(Categories::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Categories::class, 'parent_id');
    }

    public static function buildCategoryDropdown($parent_id = null, $level = 0,$type=Main::CATEGORY_TYPE_PRODUCT)
    {
        $categories = self::getCategories($parent_id,$type);
        $result = [];
        foreach ($categories as $category) {
            $result[$category->id] = str_repeat('- ', $level) . $category->title;
            $result += self::buildCategoryDropdown($category->id, $level + 1);

        }

        return $result;
    }


    public static function getCategories($parent = null,$type = Main::CATEGORY_TYPE_PRODUCT)
    {
        $deleteStatus=Main::STATUS_DISABLED;
        $condition = ['type' => $type,'is_deleted'=>$deleteStatus,'parent_id'=>$parent];


        return Categories::where($condition)->get();
    }
}
