<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagsRequest;
use App\Http\Requests\UpdateTagsRequest;
use App\Models\Tags;
use App\Models\Main;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Tags::where(['is_deleted' => Main::STATUS_DEFAULT])->get();
        return view('admin.tags.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagsRequest $request)
    {
        $inputs = $request->all();

        $model = Tags::create($inputs);
        return redirect()->route('admin.tags.index')->with('swal-success', 'برچسب جدید با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tags $model)
    {
        return view('admin.tags.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tags $model)
    {
        return view('admin.tags.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagsRequest $request, Tags $model)
    {
        $oldPassword = $request->old('password');
        $newPassword = $request->input('password');
        $model->update($request->except('password'));
        return redirect()->route('admin.tags.index')->with('swal-success', 'برچسب با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tags $model)
    {
        $model->is_deleted = Main::STATUS_IS_DELETED;
        $model->deleted_at = Carbon::now();
        $model->save();
        return redirect()->route('admin.tags.index')->with('swal-success', 'برچسب با موفقیت حذف شد');
    }

    public function status(User $model)
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
