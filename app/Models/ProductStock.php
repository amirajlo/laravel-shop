<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Venturecraft\Revisionable\RevisionableTrait;


class ProductStock extends Main
{

    const REASON_NEW_PRODUCT = 1;
    const REASON_UPDATE_PRODUCT = 2;
    const REASON_ADD_ITEM_ORDER = 3;
    const REASON_UPDATE_ITEM_ORDER = 4;
    const REASON_REMOVE_ITEM_ORDER = 5;
    const REASON_REMOVE_ORDER = 6;
    use HasFactory;


    protected $fillable = [

        'qty',
        'author_id',
        'product_id',
        'status',

        'reason',
        'created_at',
        'updated_at',

    ];

    public static function insertNew($productId, $qty, $reason, $status, $itemId = null)
    {
        if($qty > 0){
            DB::table('product_stocks')->insert([
                'product_id' => $productId,
                'item_id' => $itemId,
                'qty' => $qty,
                'author_id' => Auth::user()->id,
                'reason' => $reason,
                'status' => $status,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

    }

    public static function calculateStock($productId, $oldStockQty, $newStockQty,$itemId=null)
    {

        $subtraction = $newStockQty - $oldStockQty;
        if ($subtraction != 0) {
            $status = Main::STOCK_INCREASE;
            if ($subtraction < 0) {
                $status = Main::STOCK_DECREASE;
            }
            self::insertNew($productId, abs($subtraction), self::REASON_UPDATE_PRODUCT, $status,$itemId);

        }


    }


}
