<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;


class OrderItem extends Main
{
    use HasFactory;


    protected $fillable = [

        'order_id',
        'qty',
        'fee',
        'total',
        'discount_id',
        'discount',
        'discount_description',
        'product_id',
        'guest_token',
        'user_id',
        'author_id',
        'description',
        'status',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


}
