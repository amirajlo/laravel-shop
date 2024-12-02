<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;


class Order extends Main
{
    use HasFactory;

    const ORDER_STATUS_DEFAULT = 0;
    const ORDER_STATUS_ACTIVE = 1;
    const ORDER_STATUS_DISABLED = 3;
    const ORDER_STATUS_PENDING = 4;
    const ORDER_STATUS_POCCESS = 6;
    const ORDER_STATUS_SEND = 8;
    const ORDER_STATUS_COMPLETED = 10;


    public static function orderStatusList($label = false)
    {
        $result = [

            self::ORDER_STATUS_ACTIVE => "فعال",
            self::ORDER_STATUS_DISABLED => "معلق",
            self::ORDER_STATUS_PENDING => "در انتظار پرداخت",
            self::ORDER_STATUS_POCCESS => "در حال پردازش",
            self::ORDER_STATUS_SEND => "ارسال شده",
            self::ORDER_STATUS_COMPLETED => "تکمیل شده",
        ];
        if ($label) {
            $result = [
                self::ORDER_STATUS_DEFAULT => "<label class='btn btn-primary btn-sm'></label>",

            ];
        }
        return $result;
    }


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


    public function orderTitle()
    {
        $orderTitle = $this->id;
        if (!empty($this->user_id)) {
            $orderTitle .= " - " . $this->user->getFullName();
        } elseif (!empty($this->title)) {
            $orderTitle .= " - " . $this->title;
        }
        return $orderTitle;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }

    public function calculateTax($totalDiscount)
    {
        $tax = ($totalDiscount * Main::TAX) / 100;

        $this->tax = floor($tax);
    }

    public function priceOfTotalItems()
    {
        return ($this->total_price - $this->total_discount);
    }
    public function calculateDiscount()
    {
        if(!is_null($this->discount_id)){
            DiscountUsed::minusUsed($this->discount_id,get_class($this),$this->id);
        }
        $priceOfTotalItems=$this->priceOfTotalItems();
        $checkDiscount = Discount::checkDiscount(['type' => Main::DISCOUNT_TYPE_ORDERS], $priceOfTotalItems);
        $discount=$checkDiscount['discount'];
        $discount_id=$checkDiscount['discount_id'];
        if ($discount > 0) {
            $this->discount_id =$discount_id;
            $this->discount =0;// $discount;
            DiscountUsed::addUsed($discount_id, get_class($this), $this->id);
        }


    }

    public function calculateDeliveryDiscount()
    {
        if(!is_null($this->delivery_discount_id)){
            DiscountUsed::minusUsed($this->delivery_discount_id,get_class($this),$this->id);
        }
        $this->delivery_price = $this->delivery->fee;
        $checkDiscount = Discount::checkDiscount(['type' => Main::DISCOUNT_TYPE_DELIVERY], $this->delivery_price);
        $discount=$checkDiscount['discount'];
        $discount_id=$checkDiscount['discount_id'];
        if ($discount > 0) {
            $this->delivery_discount_id =$discount_id;
            $this->delivery_discount = $discount ;
            $this->delivery_total=$this->delivery_price - $this->delivery_discount;
            DiscountUsed::addUsed($discount_id, get_class($this), $this->id);
        }
    }

    public function calculateTotal()
    {
        $itemsPrice = $this->total_price - $this->total_discount;
        $this->calculateTax($itemsPrice);
      //  $itemsPriceDiscount = ($itemsPrice - $this->discount);

        $this->total = $itemsPrice + $this->tax + $this->delivery_total;
    }

    public static function itemsOfOrder($order_id)
    {
        //get All Items by this orderId
        $items = OrderItem::where(['order_id' => $order_id])->where(Main::defaultCondition())->get();
        return $items;
    }


    public static function checkOut($order_id)
    {
        $order = Order::where(['id' => $order_id])->first();
        $order->calculateItems($order->id);
        $order->calculateDiscount();
        $order->calculateDeliveryDiscount();
        $order->calculateTotal();
        $order->save();
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function calculateItems($order_id)
    {
        $sum = 0;
        $sumDiscount = 0;

        $items = self::itemsOfOrder($order_id);
        foreach ($items as $item) {
            //per product calculate fee and total
            $item->calculateProductDiscount();

            $item->total = ($item->qty * $item->fee) ;
            $item->save();
            $sum += $item->total;
            $sumDiscount += $item->discount;
        }

        $this->total_price = $sum;
        $this->total_discount = $sumDiscount;
    }
}
