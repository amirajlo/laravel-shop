<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\MainController;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;


class PermissionController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Permission::all();
        return view('admin.user.permission.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $model = Permission::create($inputs);
        return redirect()->route('admin.user.permission.index')->with('swal-success', 'دسترسی جدید با موفقیت ثبت شد');
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
    public function edit(Permission $model)
    {
        return view('admin.user.permission.edit', compact('model'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $model)
    {
        $inputs = $request->all();
        $model->update($inputs);
        return redirect()->route('admin.user.permission.index')->with('swal-success', 'دسترسی شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $model)
    {
        $result = $model->delete();
        return redirect()->route('admin.user.permission.index')->with('swal-success', 'دسترسی شما با موفقیت حذف شد');
    }
}
