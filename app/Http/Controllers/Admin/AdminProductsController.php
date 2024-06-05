<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\Product;
use App\Models\Main;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Product::where(['is_deleted' => Main::STATUS_DISABLED])->get();
        return view('admin.products.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductsRequest $request)
    {
        $request->merge([
            'slug' => Str::slug($request->title, '-', null),
            'author_id'=>Auth::user()->id,
        ]);

        Product::create($request->all());
        return redirect()->route('admin.products.index')->with('swal-success', 'محصول جدید با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $model)
    {
        return view('admin.products.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $model)
    {
        return view('admin.products.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductsRequest $request, Product $model)
    {
        $request->merge([
            'slug' => Str::slug($request->title, '-', null),
            'author_id'=>Auth::user()->id,
        ]);
        $model->update($request->all());
        return redirect()->route('admin.products.index')->with('swal-success', 'محصول با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $model)
    {
        $model->is_deleted = Main::STATUS_ACTIVE;
        $model->author_id =Auth::user()->id;
        $model->deleted_at = Carbon::now();
        $model->save();
        return redirect()->route('admin.products.index')->with('swal-success', 'محصول با موفقیت حذف شد');
    }

    public function status(Product $model)
    {

        $outpot = ['status' => false, 'message' => "مشکلی در فرآیند به وجود آمده است."];
        if (in_array($model->status, [Main::STATUS_ACTIVE, Main::STATUS_DISABLED])) {
            $status = Main::STATUS_ACTIVE;
            if ($model->status == $status) {
                $status = Main::STATUS_DISABLED;
            }
            $model->status = $status;
            $model->author_id =Auth::user()->id;
            $result = $model->save();
            if ($result) {
                $outpot = ['status' => true, "message" => 'وضعیت  به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
            }
        } else {
            $model->status = Main::STATUS_ACTIVE;
            $model->author_id =Auth::user()->id;
            $model->save();
            $outpot = ['status' => true, 'message' => 'وضعیت کاربر به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
        }


        return response()->json($outpot);


    }
}
