<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Main
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
}
