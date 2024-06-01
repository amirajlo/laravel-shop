<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminUserCreateRequest;
use App\Http\Requests\AdminUserUpdateRequest;
use App\Models\Main;
use App\Models\User;
use Spatie\Permission\Models\Permission;
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
        $models = User::where('role', '!=', Main::ROLE_CUSTOMER)->where(['is_deleted' => Main::STATUS_DEFAULT])->get();
        return view('admin.user.admin-user.index', compact('models'));
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
        $inputs['role'] = Main::ROLE_ADMIN;
        $user = User::create($inputs);
        return redirect()->route('admin.user.admin-user.index')->with('swal-success', 'ادمین جدید با موفقیت ثبت شد');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $model)
    {
        return view('admin.user.admin-user.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUserUpdateRequest $request, User $model)
    {
        $oldPassword = $request->old('password');
        $newPassword = $request->input('password');
        $request['role'] = Main::ROLE_ADMIN;

        $model->update($request->except('password'));
        if (!empty(trim($newPassword))) {
            $model->password = bcrypt($newPassword);
            $model->save();
        }


        return redirect()->route('admin.user.admin-user.index')->with('swal-success', 'ادمین سایت شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $model)
    {
        $model->is_deleted = Main::STATUS_IS_DELETED;
        $model->deleted_at = Carbon::now();
        $model->save();
        return redirect()->route('admin.user.admin-user.index')->with('swal-success', 'ادمین شما با موفقیت حذف شد');
    }

    public function status(User $model)
    {
        if (Auth::user()->role == Main::ROLE_ADMIN) {
            $outpot = ['status' => false, 'message' => "مشکلی در فرآیند به وجود آمده است."];
            if (in_array($model->status, [Main::STATUS_ACTIVE, Main::STATUS_DISABLED])) {
                $status = Main::STATUS_ACTIVE;
                if ($model->status == $status) {
                    $status = Main::STATUS_DISABLED;
                }
                $model->status = $status;
                $result = $model->save();
                if ($result) {
                    $outpot = ['status' => true, "message" => 'وضعیت کاربر به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
                }
            } else {
                $model->status = Main::STATUS_ACTIVE;
                $model->save();
                $outpot = ['status' => true, 'message' => 'وضعیت کاربر به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
            }
        } else {
            $outpot = ['status' => false, 'message' => "مجوز ندارید."];
        }


        return response()->json($outpot);


    }

    public function roles(User $model)
    {
        $roles = Role::all();
        return view('admin.user.admin-user.roles', compact('model', 'roles'));
    }

    public function rolesStore(Request $request, User $model)
    {
        $validated = $request->validate([
            'roles' => 'required|exists:roles,id|array'
        ]);

        $model->roles()->sync($request->roles);
        return redirect()->route('admin.user.admin-user.index')->with('swal-success', 'نقش با موفقیت ویرایش شد');
    }

    public function permissions(User $model)
    {
        $permissions = Permission::all();


        return view('admin.user.admin-user.permissions', compact('model', 'permissions'));
    }

    public function permissionsStore(Request $request, User $model)
    {
        $validated = $request->validate([
            'permissions' => 'required|exists:permissions,id|array'
        ]);

        $model->permissions()->sync($request->permissions);
        return redirect()->route('admin.user.admin-user.index')->with('swal-success', 'سطح دسترسی با موفقیت ویرایش شد');
    }


}
