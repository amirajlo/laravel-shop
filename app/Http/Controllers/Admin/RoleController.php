<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\MainController;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;


class RoleController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Role::all();
        return view('admin.user.role.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $models = Permission::all();
        return view('admin.user.role.create', compact('models'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $inputs = $request->all();
        $model = Role::create($inputs);
        $inputs['permissions'] = $inputs['permissions'] ?? [];
        $model->permissions()->sync($inputs['permissions']);
        return redirect()->route('admin.user.role.index')->with('swal-success', 'نقش جدید با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $model)
    {
        return view('admin.user.role.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $model)
    {
        $inputs = $request->all();
        $model->update($inputs);
        return redirect()->route('admin.user.role.index')->with('swal-success', 'نقش شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $model)
    {
        $result = $model->delete();
        return redirect()->route('admin.user.role.index')->with('swal-success', 'نقش شما با موفقیت حذف شد');
    }

    public function permissionForm(Role $model)
    {
        $models = Permission::all();
        return view('admin.user.role.set-permission', compact('model', 'models'));
    }

    public function permissionUpdate(RoleRequest $request, Role $model)
    {
        $inputs = $request->all();
        $inputs['permissions'] = $inputs['permissions'] ?? [];
        $model->permissions()->sync($inputs['permissions']);
        return redirect()->route('admin.user.role.index')->with('swal-success', 'نقش جدید با موفقیت ویرایش شد');
    }
}
