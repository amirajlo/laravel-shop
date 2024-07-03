<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use App\Http\Requests\StoreDeliveriesRequest;
use App\Http\Requests\UpdateDeliveriesRequest;
use App\Models\Delivery;
use App\Models\Main;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminDeliveriesController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Delivery::where(['is_deleted' => Main::STATUS_DISABLED])->get();
        return view('admin.deliveries.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.deliveries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeliveriesRequest $request)
    {
        $request->merge([

            'author_id'=>Auth::user()->id,
        ]);

        Delivery::create($request->all());
        return redirect()->route('admin.deliveries.index')->with('swal-success', 'حمل و نقل جدید با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Delivery $model)
    {
        return view('admin.deliveries.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery $model)
    {
        return view('admin.deliveries.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeliveriesRequest $request, Delivery $model)
    {
        $request->merge([
            'author_id'=>Auth::user()->id,
        ]);
        $model->update($request->all());
        return redirect()->route('admin.deliveries.index')->with('swal-success', 'حمل و نقل با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery $model)
    {
        $model->is_deleted = Main::STATUS_ACTIVE;

        $model->deleted_at = Carbon::now();
        $model->save();
        return redirect()->route('admin.deliveries.index')->with('swal-success', 'حمل و نقل با موفقیت حذف شد');
    }

    public function status(Delivery $model)
    {

        $outpot = ['status' => false, 'message' => "مشکلی در فرآیند به وجود آمده است."];
        if (in_array($model->status, [Main::STATUS_ACTIVE, Main::STATUS_DISABLED])) {
            $status = Main::STATUS_ACTIVE;
            if ($model->status == $status) {
                $status = Main::STATUS_DISABLED;
            }
            $model->status = $status;

            $result = $model->save();
            if ($result) {
                $outpot = ['status' => true, "message" => 'وضعیت  به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
            }
        } else {
            $model->status = Main::STATUS_ACTIVE;

            $model->save();
            $outpot = ['status' => true, 'message' => 'وضعیت کاربر به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
        }


        return response()->json($outpot);


    }
}
