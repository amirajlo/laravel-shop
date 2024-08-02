<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\MainController;
use App\Http\Requests\StoreDiscountsRequest;
use App\Http\Requests\UpdateDiscountsRequest;
use App\Models\Discount;
use App\Models\Main;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class AdminDiscountsController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Discount::where(['is_deleted' => Main::STATUS_DISABLED])->get();
        return view('admin.discounts.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $model = new Discount();
        return view('admin.discounts.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiscountsRequest $request)
    {

        $generate = 1;
        if (is_null($request->generate_checkbox)) {
            $generate = 0;
        }
        if($generate == 1 ){
            $code=Str::random(5);
        }
        else{
            $code=$request->discount_code;
        }
        $request->merge([

            'author_id' => Auth::user()->id,
            'discount_code' =>$code,
        ]);

        Discount::create($request->all());
        return redirect()->route('admin.discounts.index')->with('swal-success', 'تخفیف جدید با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $model)
    {
        return view('admin.discounts.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $model)
    {
        return view('admin.discounts.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiscountsRequest $request, Discount $model)
    {
        $request->merge([
            'author_id' => Auth::user()->id,
        ]);
        $model->update($request->all());
        return redirect()->route('admin.discounts.index')->with('swal-success', 'تخفیف با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $model)
    {
        $model->is_deleted = Main::STATUS_ACTIVE;

        $model->deleted_at = Carbon::now();
        $model->save();
        return redirect()->route('admin.discounts.index')->with('swal-success', 'تخفیف با موفقیت حذف شد');
    }

    public function status(Discount $model)
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
            $outpot = ['status' => true, 'message' => 'وضعیت  به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
        }


        return response()->json($outpot);


    }
}
