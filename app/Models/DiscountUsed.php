<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class DiscountUsed extends Main
{
    use HasFactory;

    protected $table = "discount_used";
    protected $fillable = [

        'discount_id',
        'model_type',
        'model_id',
        'is_deleted',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function addUsed($id,$type,$model)
    {
        $countDiscount = new DiscountUsed();
        $countDiscount->discount_id=$id;
        $countDiscount->model_id = $model;
        $countDiscount->model_type = $type;
        $countDiscount->save();
    }
    public static function minusUsed($id,$type,$model)
    {
        $countDiscount = DiscountUsed::where(['discount_id'=>$id,'model_id'=>$model,'model_type'=>$type,'is_deleted'=>Main::STATUS_DISABLED])->first();
        $countDiscount->is_deleted=Main::STATUS_ACTIVE;
        $countDiscount->save();
        $hasDiscount = Discount::where(['id'=>$id])->first();
        $hasDiscount->used -=1;
        $hasDiscount->save();
    }
}
