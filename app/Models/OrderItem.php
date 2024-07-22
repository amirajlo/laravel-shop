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

    public function calculateProductDiscount()
    {
        $product = Product::where(['id' => $this->product_id])->where(Main::defaultCondition())->first();
        $this->fee = $product->calculatePrice();

        $checkDiscount = Discount::checkDiscount(['product_id' => $product->id], $this->qty, $product->calculatePrice());
        $discount=$checkDiscount['discount'];
        $discount_id=$checkDiscount['discount_id'];
        if ($discount > 0) {
            $this->discount_id =$discount_id;
            $this->discount = $discount;
            DiscountUsed::addUsed($discount_id, get_class($this), $this->id);
        }
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
