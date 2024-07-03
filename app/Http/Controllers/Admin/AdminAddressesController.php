<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\MainController;
use App\Http\Requests\StoreAddressesRequest;
use App\Http\Requests\UpdateAddressesRequest;
use App\Models\Address;
use App\Models\Main;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminAddressesController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Address::where(['is_deleted' => Main::STATUS_DISABLED])->get();
        return view('admin.addresses.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.addresses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressesRequest $request)
    {
        $request->merge([

            'author_id' => Auth::user()->id,
        ]);

        Address::create($request->all());
        return redirect()->route('admin.addresses.index')->with('swal-success', 'آدرس جدید با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $model)
    {
        return view('admin.addresses.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $model)
    {
        return view('admin.addresses.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressesRequest $request, Address $model)
    {
        $request->merge([
            'author_id' => Auth::user()->id,
        ]);
        $model->update($request->all());
        return redirect()->route('admin.addresses.index')->with('swal-success', 'آدرس با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $model)
    {
        $model->is_deleted = Main::STATUS_ACTIVE;
        $model->deleted_at = Carbon::now();
        $model->save();
        return redirect()->route('admin.addresses.index')->with('swal-success', 'آدرس با موفقیت حذف شد');
    }

    public function status(Address $model)
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
