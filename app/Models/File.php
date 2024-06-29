<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;


class File extends Main
{
    use HasFactory;


    protected $fillable = [

        'title',
        'name',
        'alt',
        'path',
        'type',
        'model_id',
        'model_type',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'model_id');
    }
}
