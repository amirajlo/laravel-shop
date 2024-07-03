<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\MainController;
use App\Models\Payment;
use App\Models\Main;
use Carbon\Carbon;


class AdminPaymentsController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Payment::where(['is_deleted' => Main::STATUS_DISABLED])->get();
        return view('admin.payments.index', compact('models'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Payment $model)
    {
        return view('admin.payments.show', compact('model'));
    }

    public function destroy(Payment $model)
    {
        $model->is_deleted = Main::STATUS_ACTIVE;

        $model->deleted_at = Carbon::now();
        $model->save();
        return redirect()->route('admin.payments.index')->with('swal-success', 'پرداخت با موفقیت حذف شد');
    }

}
