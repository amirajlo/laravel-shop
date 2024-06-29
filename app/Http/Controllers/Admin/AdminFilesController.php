<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\MainController;
use App\Models\File;
use App\Models\Main;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminFilesController extends MainController
{
    public function index()
    {
        $condition = Main::defaultCondition();
        $models = File::where($condition)->get();
        return view('admin.files.index', compact('models'));
    }
    public function delete(File $model)
    {
        $outpot = ['status' => true, "message" => 'فایل حذف شد.','id' =>Main::filesTypeList()[$model->type]."-".$model->id ];
        $model = File::where(['id' => $model->id])->delete();
        return response()->json($outpot);
    }


    public function edit(File $model)
    {
        $condition = Main::defaultCondition();



        return view('admin.files.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($request, File $model)
    {


    }


}
