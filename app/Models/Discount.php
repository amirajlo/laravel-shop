<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Discount extends Main
{
    use HasFactory;


    protected $fillable = [

        'title',
        'description',
        'discount_code',
        'type',
        'qty',
        'percent',
        'fee',
        'min_order',
        'min_qty',
        'max',
        'expired_at',
        'product_id',
        'status',
        'author_id',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
