<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Discount extends Main
{
    use HasFactory;

public $generate_code;
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
        'cat_id',
        'status',
        'author_id',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',
        'generate_code',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function cat()
    {
        return $this->belongsTo(Categories::class, 'cat_id');
    }

    public static function checkDiscount($condition,$price,$qty=null)
    {
        $cond1=$qty;
        $cond2="min_qty";
        $discount = 0;
        $discount_id= 0;
        if(is_null($qty)){
            $cond1=$price;
            $cond2="min_order";
        }
        $hasDiscount = Discount::where($condition)->where(Main::defaultCondition())->first();
        if ($hasDiscount) {
            if ($hasDiscount->used < $hasDiscount->qty) {
                if ($cond1 >= $hasDiscount->$cond2) {

                    if (!empty($hasDiscount->fee)) {
                        $discount += $hasDiscount->fee;
                    }
                    if (!empty($hasDiscount->percent)) {
                        $percent = ($hasDiscount->percent * $price) / 100;
                        $discount += $percent;
                    }
                    if(!is_null($qty)){
                        $discount *= $cond1;
                    }

                    if ($discount > 0) {
                       $discount_id= $hasDiscount->id;
                        if ($hasDiscount->max != 0) {
                            if ($discount > $hasDiscount->max) {
                                $discount = $hasDiscount->max;
                            }
                        }
                        $hasDiscount->used += 1;
                        $hasDiscount->save();

                    }


                }
            }
        }

        return [
            'discount_id' => $discount_id,
            'discount' => $discount,
        ];

    }



}
