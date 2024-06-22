<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Taggables extends Main
{
    use HasFactory;

    protected $table = 'taggables';

    protected $fillable = [

        'tag_id',
        'taggable_id',
        'taggable_type',
    ];



}
