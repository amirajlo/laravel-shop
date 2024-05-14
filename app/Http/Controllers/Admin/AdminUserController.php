<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminUserCreateRequest;
use App\Http\Requests\AdminUserUpdateRequest;
use App\Models\Main;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\Image\ImageService;


class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        //Role::create(['name' => 'admin']);
        $admins = User::where('role', '!=', Main::ROLE_CUSTOMER)->where(['is_deleted' => Main::STATUS_DEFAULT])->get();
        return view('admin.user.admin-user.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.admin-user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminUserCreateRequest $request)
    {
        $inputs = $request->all();

        $inputs['password'] = Hash::make($request->password);

        $user = User::create($inputs);
        return redirect()->route('admin.user.admin-user.index')->with('swal-success', 'ادمین جدید با موفقیت ثبت شد');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $admin)
    {
        return view('admin.user.admin-user.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUserUpdateRequest $request, User $admin)
    {
        $oldPassword = $request->old('password');
        $newPassword = $request->input('password');


        $admin->update($request->except('password'));
        if(!empty(trim($newPassword))){

            $admin->password =bcrypt($newPassword);
            $admin->save();
        }



        return redirect()->route('admin.user.admin-user.index')->with('swal-success', 'ادمین سایت شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $admin)
    {
        $admin->is_deleted = Main::STATUS_IS_DELETED;
        $admin->deleted_at = Carbon::now();
        $admin->save();
        return redirect()->route('admin.user.admin-user.index')->with('swal-success', 'ادمین شما با موفقیت حذف شد');
    }

    public function status(User $user)
    {
        if (Auth::user()->role == Main::ROLE_ADMIN) {
            $outpot = ['status' => false, 'message' => "مشکلی در فرآیند به وجود آمده است."];
            if (in_array($user->status, [Main::STATUS_ACTIVE, Main::STATUS_DISABLED])) {
                $status = Main::STATUS_ACTIVE;
                if ($user->status == $status) {
                    $status = Main::STATUS_DISABLED;
                }
                $user->status = $status;
                $result = $user->save();
                if ($result) {
                    $outpot = ['status' => true, "message" => 'وضعیت کاربر به روزرسانی شد.', 'result' => Main::userStatus(true)[$user->status]];
                }
            } else {
                $user->status = Main::STATUS_ACTIVE;
                $user->save();
                $outpot = ['status' => true, 'message' => 'وضعیت کاربر به روزرسانی شد.', 'result' => Main::userStatus(true)[$user->status]];
            }
        } else {
            $outpot = ['status' => false, 'message' => "مجوز ندارید."];
        }


        return response()->json($outpot);


    }


}
