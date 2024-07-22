<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Comment extends Main
{
    use HasFactory;


    protected $fillable = [

        'title',
        'description',
        'status',
        'parent_id',
        'user_id',
        'positive_points',
        'negative_points',
        'email',
        'website',
        'mobile',
        'model_type',
        'model_id',
        'ip',
        'score',
        'like',
        'dis_like',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
