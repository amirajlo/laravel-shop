<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;


class OrderNote extends Main
{
    use HasFactory;


    protected $fillable = [

        'description',
        'author_id',
        'order_id',
        'status',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


}
