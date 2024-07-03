<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Main
{
    use HasFactory;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    protected $fillable = [
        'amount',
        'reference_id',
        'reference_number',
        'trace_number',
        'payment_date',
        'order_id',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
