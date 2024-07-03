<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Delivery extends Main
{
    use HasFactory;


    protected $fillable = [

        'title',
        'description',
        'status',
        'author_id',
        'main_image',
        'fee',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


}
