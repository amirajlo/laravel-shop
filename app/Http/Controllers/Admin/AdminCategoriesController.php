<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoriesRequest;
use App\Http\Requests\UpdateCategoriesRequest;
use App\Models\Categories;
use App\Models\Main;
use App\Models\Tags;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($type = Main::CATEGORY_TYPE_PRODUCT)
    {
        $models = Categories::with('children')->whereNull('parent_id')->where(['type' => $type, 'is_deleted' => Main::STATUS_DEFAULT])->get();
        return view('admin.categories.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($type = Main::CATEGORY_TYPE_PRODUCT)
    {

        $categories = Categories::where(['type' => $type, 'is_deleted' => Main::STATUS_DEFAULT])->whereNull('parent_id')->with('children')->get();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriesRequest $request)
    {
        $request->merge([
            'slug' => Str::slug($request->title, '-', null),
            'author_id' => Auth::user()->id,
        ]);

        Categories::create($request->all());

        return redirect()->route('admin.categories.index', $request->input('type'))->with('swal-success', 'ادمین جدید با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $model)
    {
        return view('admin.categories.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $model)
    {
        $categories = Categories::where(['type' => $model->type, 'is_deleted' => Main::STATUS_DEFAULT])->whereNull('parent_id')->with('children')->get();

        return view('admin.categories.edit', compact('model', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriesRequest $request, Categories $model)
    {

        $request->merge([
            'slug' => Str::slug($request->title, '-', null),
            'author_id' => Auth::user()->id,
        ]);
        $model->update($request->all());
        return redirect()->route('admin.categories.index', $model->type)->with('swal-success', 'ادمین سایت شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $model)
    {
        $model->is_deleted = Main::STATUS_IS_DELETED;
        $model->deleted_at = Carbon::now();
        $model->author_id = Auth::user()->id;
        $model->save();
        return redirect()->route('admin.categories.index', $model->type)->with('swal-success', 'ادمین شما با موفقیت حذف شد');
    }

    public function status(Categories $model)
    {

        $outpot = ['status' => false, 'message' => "مشکلی در فرآیند به وجود آمده است."];
        if (in_array($model->status, [Main::STATUS_ACTIVE, Main::STATUS_DISABLED])) {
            $status = Main::STATUS_ACTIVE;
            if ($model->status == $status) {
                $status = Main::STATUS_DISABLED;
            }
            $model->status = $status;
            $model->author_id = Auth::user()->id;
            $result = $model->save();
            if ($result) {
                $outpot = ['status' => true, "message" => 'وضعیت کاربر به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
            }
        } else {
            $model->status = Main::STATUS_ACTIVE;
            $model->author_id = Auth::user()->id;
            $model->save();
            $outpot = ['status' => true, 'message' => 'وضعیت کاربر به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
        }


        return response()->json($outpot);


    }
}