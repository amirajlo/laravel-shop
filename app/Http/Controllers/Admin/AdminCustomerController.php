<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\MainController;
use App\Http\Requests\AdminCustomerCreateRequest;
use App\Http\Requests\AdminCustomerUpdateRequest;
use App\Models\Main;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;
use App\Http\Services\Image\ImageService;


class AdminCustomerController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = User::where('role', '=', Main::ROLE_CUSTOMER)->where(['is_deleted' => Main::STATUS_DISABLED])->get();
        return view('admin.user.customer.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminCustomerCreateRequest $request)
    {
        $inputs = $request->all();

        $inputs['password'] = Hash::make($request->password);
        $inputs['role']=Main::ROLE_CUSTOMER;
        $model = User::create($inputs);
        return redirect()->route('admin.user.customer.index')->with('swal-success', 'مشتری جدید با موفقیت ثبت شد');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $model)
    {
        return view('admin.user.customer.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminCustomerUpdateRequest $request, User $model)
    {
        $oldPassword = $request->old('password');
        $newPassword = $request->input('password');
        $request['role']=Main::ROLE_CUSTOMER;

        $model->update($request->except('password'));
        if(!empty(trim($newPassword))){

            $model->password =bcrypt($newPassword);
            $model->save();
        }



        return redirect()->route('admin.user.customer.index')->with('swal-success', 'مشتری سایت شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $model)
    {
        $model->is_deleted = Main::STATUS_ACTIVE;
        $model->deleted_at = Carbon::now();
        $model->save();
        return redirect()->route('admin.user.customer.index')->with('swal-success', 'مشتری شما با موفقیت حذف شد');
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
                $outpot = ['status' => true, 'message' => 'وضعیت  به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
            }



        return response()->json($outpot);


    }
}
