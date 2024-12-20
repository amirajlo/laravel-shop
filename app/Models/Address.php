<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Address extends Main
{
    use HasFactory;


    protected $fillable = [


        'title',
        'email',
        'description',
        'postal_code',
        'author_id',
        'user_id',
        'mobile',
        'phone',
        'province_id',
        'city_id',
        'town_id',
        'latitude',
        'longitude',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

public static function addressesList ($user_id)
{
    $addresses = Address::where(['user_id'=> $user_id,'is_deleted'=>Main::STATUS_DISABLED])->pluck('title', 'id');

    return $addresses;
}
}
