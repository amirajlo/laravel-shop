<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\MainController;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Main;
use App\Http\Requests\UpdateOrderItemsRequest;
use App\Http\Requests\StoreOrderItemsRequest;

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
        $models = OrderItem::where(['is_deleted' => Main::STATUS_DISABLED])->where(['order_id'=>'is NULL'])->get();
        return view('admin.orderitems.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Order $model )
    {

        return view('admin.orderitems.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderItemsRequest $request)
    {

        $defaultValues=[
            'author_id'=>Auth::user()->id,
        ];


        $request->merge($defaultValues);

        Order::create($request->all());
        return redirect()->route('admin.orderitems.index')->with('swal-success', 'آیتم جدید با موفقیت ثبت شد');
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
    public function update(UpdateOrderItemsRequest $request, Order $model)
    {
        $defaultValues=[
            'author_id'=>Auth::user()->id,
        ];


        $request->merge($defaultValues);
        $model->update($request->all());
        return redirect()->route('admin.orderitems.index')->with('swal-success', 'آیتم با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderItem $model)
    {
        $model->is_deleted = Main::STATUS_ACTIVE;
        $model->author_id =Auth::user()->id;
        $model->deleted_at = Carbon::now();
        $model->save();
        return redirect()->route('admin.orderitems.index')->with('swal-success', 'آیتم با موفقیت حذف شد');
    }

    public function status(OrderItem $model)
    {

        $outpot = ['status' => false, 'message' => "مشکلی در فرآیند به وجود آمده است."];
        if (in_array($model->status, [Main::STATUS_ACTIVE, Main::STATUS_DISABLED])) {
            $status = Main::STATUS_ACTIVE;
            if ($model->status == $status) {
                $status = Main::STATUS_DISABLED;
            }
            $model->status = $status;
            $model->author_id =Auth::user()->id;
            $result = $model->save();
            if ($result) {
                $outpot = ['status' => true, "message" => 'وضعیت  به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
            }
        } else {
            $model->status = Main::STATUS_ACTIVE;
            $model->author_id =Auth::user()->id;
            $model->save();
            $outpot = ['status' => true, 'message' => 'وضعیت  به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
        }


        return response()->json($outpot);


    }
}
