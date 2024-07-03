<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;


class Order extends Main
{
    use HasFactory;


    protected $fillable = [

        'title',
        'tax',
        'delivery_id',
        'delivery_price',
        'delivery_discount',
        'delivery_total',
        'delivery_description',
        'discount_id',
        'total_price',
        'total_discount',
        'total',
        'address_id',
        'payment_status',
        'ip',
        'email',
        'mobile',
        'phone',
        'author_id',
        'user_id',
        'description',
        'status',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


}
