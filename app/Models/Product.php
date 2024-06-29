<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Product extends Main
{
    use HasFactory;


    protected $fillable = [
        'main_image',
        'header_image',

        'title',
        'sub_title',
        'en_title',
        'categories',
        'tags',
        'description',
        'seo_title',
        'seo_description',
        'content_title',
        'slug',
        'status',
        'band_id',
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
        'show_price',
        'price_type',
        'price',
        'price_special',
        'price_currency',
        'price_currency_special',
        'price_special_from',
        'price_special_to',
        'manage_stock',
        'stock_status',
        'stock_qty',
        'low_stock',
        'sitemap_check',
    ];



    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tags::class, 'taggable','taggables','tag_id');
    }
}
