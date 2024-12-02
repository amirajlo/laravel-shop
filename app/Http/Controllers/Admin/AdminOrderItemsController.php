<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\MainController;

use App\Models\Delivery;
use App\Models\DiscountUsed;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Main;
use App\Http\Requests\UpdateOrderItemsRequest;
use App\Http\Requests\StoreOrderItemsRequest;

use App\Models\Product;
use App\Models\ProductStock;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class AdminOrderItemsController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = OrderItem::where(['is_deleted' => Main::STATUS_DISABLED])->where(['order_id' => 'is NULL'])->get();
        return view('admin.orderitems.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Order $model)
    {

        return view('admin.orderitems.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderItemsRequest $request)
    {

        $redirectPath = 'admin.orders.show';
        $swal = 'swal-success';
        $message = 'عملیات با موفقیت انجام شد.';
        if (isset($_POST['saveAdd'])) {
            $redirectPath = 'admin.orderitems.create';
        }

        $qty = $request->input('qty');
        $order_id = $request->input('order_id');
        $description = $request->input('description');
        $product_id = $request->input('product_id');
        $product = Product::where(['id' => $product_id])->where(Main::defaultCondition())->first();

        $stock = $product->calculateStock($qty);

        if ($stock['status'] == Product::IN_STOCK) {
            $redirectPath = 'admin.orders.show';
            $message = 'محصول موجود نیست';
            $swal = 'swal-error';
        } else {
            if (isset($stock['qty'])) {
                $qty = $stock['qty'];
                $product->stock_qty -= $qty;
                $product->save();
            }

            $model = OrderItem::where(['order_id' => $order_id, 'product_id' => $product_id])->where(Main::defaultCondition())->first();
            if (!$model) {
                $defaultValues = [
                    'author_id' => Auth::user()->id,
                    'qty' => $qty,

                ];
                $request->merge($defaultValues);
                $model = OrderItem::create($request->all());

            }
            else {
                $totalQty = $model->qty + $qty;
                $model->description += $description;
                $model->qty = $totalQty;
                $model->save();
            }

            ProductStock::insertNew($product->id, $qty,ProductStock::REASON_ADD_ITEM_ORDER,Main::STOCK_DECREASE,$model->id);
            Order::checkOut($order_id);

        }



        return redirect()->route($redirectPath, $order_id)->with($swal, $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderItem $model)
    {
        return view('admin.orderitems.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderItem $model)
    {
        return view('admin.orderitems.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderItemsRequest $request, OrderItem $model)
    {

        $newStockQty=$request->qty;
        $redirectPath = 'admin.orders.show';
        $swal = 'swal-success';
        $message = 'عملیات با موفقیت انجام شد.';
        if (isset($_POST['saveAdd'])) {
            $redirectPath = 'admin.orderitems.create';
        }
        $product_id =$model->product_id;
        $order_id = $model->order_id;
        $oldQty = $model->qty;

        $qty = $request->input('qty');
        $product = Product::where(['id' => $product_id])->where(Main::defaultCondition())->first();
        $stock = $product->calculateStock($qty,$oldQty,$model->id);
        $product->save();
        if ($stock['status'] == Product::IN_STOCK) {
            $redirectPath = 'admin.orders.show';
            $message = 'محصول موجود نیست';
            $swal = 'swal-error';
        } else {

            if (isset($stock['qty'])) {
                $qty = $stock['qty'];
                $product->stock_qty -= $qty;
                $product->save();
            }


            $defaultValues = [
                'author_id' => Auth::user()->id,
                'product_id' => $product_id,
                'qty' => $qty,
            ];
            $request->merge($defaultValues);
            $model->update($request->all());
            ProductStock::insertNew($product->id,$qty,ProductStock::REASON_UPDATE_ITEM_ORDER,Main::STOCK_DECREASE,$model->id);
           if(!is_null($model->discount_id)){
                DiscountUsed::minusUsed($model->discount_id,get_class($model),$model->id);
            }

            Order::checkOut($order_id);

        }
        return redirect()->route($redirectPath, $order_id)->with($swal, $message);
    }

    /**
     * Remove the specified resource from storage.
     */


    public function status(OrderItem $model)
    {

        $outpot = ['status' => false, 'message' => "مشکلی در فرآیند به وجود آمده است."];
        if (in_array($model->status, [Main::STATUS_ACTIVE, Main::STATUS_DISABLED])) {
            $status = Main::STATUS_ACTIVE;
            if ($model->status == $status) {
                $status = Main::STATUS_DISABLED;
            }
            $model->status = $status;
            $model->author_id = Auth::user()->id;
            $result = $model->save();
            if ($result) {
                $outpot = ['status' => true, "message" => 'وضعیت  به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
            }
        } else {
            $model->status = Main::STATUS_ACTIVE;
            $model->author_id = Auth::user()->id;
            $model->save();
            $outpot = ['status' => true, 'message' => 'وضعیت  به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
        }


        return response()->json($outpot);


    }

    public function destroy(OrderItem $model)
    {
        $order_id = $model->order_id;
        $model->is_deleted = Main::STATUS_ACTIVE;
        $model->author_id = Auth::user()->id;
        $model->deleted_at = Carbon::now();
        $model->save();
        $product=Product::where(['id'=>$model->product_id])->first();
        $product->backStock($model->qty,$model->id,ProductStock::REASON_REMOVE_ITEM_ORDER);
        $product->save();
        if(!is_null($model->discount_id)){
            DiscountUsed::minusUsed($model->discount_id,get_class($model),$model->id);
        }
        if(!is_null($model->order->discount_id)){
            DiscountUsed::minusUsed($model->order->discount_id,get_class($model->order),$model->order->id);
        }
        if(!is_null($model->order->delivery_discount_id)){
            DiscountUsed::minusUsed($model->order->delivery_discount_id,get_class($model->order),$model->order->id);
        }
        Order::checkOut($order_id);
        return redirect()->route('admin.orders.show', $order_id)->with('swal-success', 'آیتم با موفقیت حذف شد');
    }

}
