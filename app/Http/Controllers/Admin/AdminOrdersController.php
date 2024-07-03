<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\MainController;
use App\Http\Requests\StoreOrdersRequest;
use App\Http\Requests\UpdateOrdersRequest;
use App\Models\Order;
use App\Models\Main;

use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class AdminOrdersController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Order::where(['is_deleted' => Main::STATUS_DISABLED])->get();
        return view('admin.orders.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrdersRequest $request)
    {

        $defaultValues = [
            'author_id' => Auth::user()->id,
        ];

        if (empty($request->input('title'))) {
            $user = User::where(['id' => $request->input('user_id')])->first();
            if ($user) {
                $defaultValues['title'] = $user->getFullName();
            }
        }
        $request->merge($defaultValues);

        Order::create($request->all());
        return redirect()->route('admin.orders.index')->with('swal-success', 'سفارش جدید با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $model)
    {
        $models = OrderItem::where(['is_deleted' => Main::STATUS_DISABLED, 'order_id' => $model->id])->get();
        return view('admin.orders.show', compact('model','models'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $model)
    {
        return view('admin.orders.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrdersRequest $request, Order $model)
    {
        $defaultValues = [
            'author_id' => Auth::user()->id,
        ];

        if (empty($request->input('title'))) {
            $user = User::where(['id' => $request->input('user_id')])->first();
            if ($user) {
                $defaultValues['title'] = $user->getFullName();
            }
        }
        $request->merge($defaultValues);
        $model->update($request->all());
        return redirect()->route('admin.orders.index')->with('swal-success', 'سفارش با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $model)
    {
        $model->is_deleted = Main::STATUS_ACTIVE;
        $model->author_id = Auth::user()->id;
        $model->deleted_at = Carbon::now();
        $model->save();
        return redirect()->route('admin.orders.index')->with('swal-success', 'سفارش با موفقیت حذف شد');
    }

    public function status(Order $model)
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
            $outpot = ['status' => true, 'message' => 'وضعیت کاربر به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
        }


        return response()->json($outpot);


    }
}
