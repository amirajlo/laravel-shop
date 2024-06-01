<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
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

        'title',
        'sub_title',
        'lead',
        'categories',
        'tags',
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
        'related_articles',
        'related_products',
        'published_at',
        'count_visit',
        'count_comment',
        'count_score',
        'is_commentable',
        'sidebar',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
