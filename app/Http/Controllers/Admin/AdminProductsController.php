<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\MainController;
use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\Categories;
use App\Models\File;
use App\Models\Product;
use App\Models\Main;

use App\Models\ProductStock;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminProductsController extends MainController
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
        $model = new Product();
        $model->stock_status = Main::STATUS_ACTIVE;
        $model->show_price = Main::STATUS_ACTIVE;
        $model->status = Main::STATUS_ACTIVE;
        $categories = Product::getCategoriesChild();
        return view('admin.products.create', compact('categories', 'model'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductsRequest $request)
    {

        $show_price = 1;
        if (is_null($request->show_price)) {
            $show_price = 0;
        }

        $stock_qty = 0;
        if (floor($request->stock_qty) > 0) {
            $stock_qty = $request->stock_qty;
        }
        $low_stock = 0;
        if (floor($request->low_stock) > 0) {
            $low_stock = $request->low_stock;
        }

        $request->merge([
            'slug' => Str::slug($request->title, '-', null),
            'author_id' => Auth::user()->id,
            'show_price' => $show_price,
            'stock_qty' => $stock_qty,
            'low_stock' => $low_stock,
        ]);

        $model = Product::create($request->except('main_image'));
        if ($model->manage_stock == Main::STATUS_ACTIVE) {
            ProductStock::insertNew($model->id, $model->stock_qty,ProductStock::REASON_NEW_PRODUCT,Main::STOCK_INCREASE);
        }
        // Handle main image upload

        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $uploadmainImage = $this->uploadMainImage($file);
            if ($uploadmainImage['status'] == Main::STATUS_ACTIVE) {
                $fileModel = new File();
                $fileModel->model_id = $model->id;
                $fileModel->model_type = get_class($model);
                $fileModel->path = $uploadmainImage['fileName'];
                $fileModel->type = Main::FILES_MAIN_IMAGE;
                $fileModel->save();
                $model->main_image = $fileModel->id;
                $model->save();
            }
        }

        if ($request->hasFile('gallery_images')) {
            $files = $request->file('gallery_images');
            $UploadGalleryImages = $this->UploadGalleryImages($files);

            if ($UploadGalleryImages['status'] == Main::STATUS_ACTIVE) {
                foreach ($UploadGalleryImages['fileNames'] as $items) {
                    $fileModel = new File();
                    $fileModel->model_id = $model->id;
                    $fileModel->model_type = get_class($model);
                    $fileModel->path = $items;
                    $fileModel->type = Main::FILES_GALLERY_IMAGES;
                    $fileModel->save();
                }

                $model->save();
            }
        }
        // Handle gallery image uploads (if any)
        // $this->uploadGalleryImages($request, $product);

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

        $categories = Product::getCategoriesChild();
        $mainImage = File::where(['model_id' => $model->id, 'model_type' => get_class($model), 'type' => Main::FILES_MAIN_IMAGE])->first();
        $headerImage = File::where(['model_id' => $model->id, 'model_type' => get_class($model), 'type' => Main::FILES_HEADER_IMAGE])->first();
        $galleryImages = File::where(['model_id' => $model->id, 'model_type' => get_class($model), 'type' => Main::FILES_GALLERY_IMAGES])->get();
        return view('admin.products.edit', compact('model', 'categories', 'mainImage', 'headerImage', 'galleryImages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductsRequest $request, Product $model)
    {

        $oldStockQty = $model->stock_qty;
        $newStockQty = $request->stock_qty;
        $show_price = 1;
        if (is_null($request->show_price)) {
            $show_price = 0;
        }
        $request->merge([
            'slug' => Str::slug($request->title, '-', null),
            'author_id' => Auth::user()->id,
            'show_price' => $show_price,
        ]);
        $model->update($request->except('main_image'));

        ProductStock::calculateStock($model->id,$oldStockQty,$newStockQty);

        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $uploadmainImage = $this->uploadMainImage($file);

            if ($uploadmainImage['status'] == Main::STATUS_ACTIVE) {
                File::where(['model_id' => $model->id, 'model_type' => get_class($model), 'type' => Main::FILES_MAIN_IMAGE])->delete();

                $fileModel = new File();
                $fileModel->model_id = $model->id;
                $fileModel->model_type = get_class($model);
                $fileModel->path = $uploadmainImage['fileName'];
                $fileModel->type = Main::FILES_MAIN_IMAGE;
                $fileModel->save();
                $model->main_image = $fileModel->id;
                $model->save();
            }
        }

        if ($request->hasFile('gallery_images')) {
            $files = $request->file('gallery_images');
            $UploadGalleryImages = $this->UploadGalleryImages($files);
            if ($UploadGalleryImages['status'] == Main::STATUS_ACTIVE) {
                File::where(['model_id' => $model->id, 'model_type' => get_class($model), 'type' => Main::FILES_GALLERY_IMAGES])->delete();
                foreach ($UploadGalleryImages['fileNames'] as $items) {
                    $fileModel = new File();
                    $fileModel->model_id = $model->id;
                    $fileModel->model_type = get_class($model);
                    $fileModel->path = $items;
                    $fileModel->type = Main::FILES_GALLERY_IMAGES;
                    $fileModel->save();
                }
            }
        }

        return redirect()->route('admin.products.index')->with('swal-success', 'محصول با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $model)
    {
        $model->is_deleted = Main::STATUS_ACTIVE;
        $model->author_id = Auth::user()->id;
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
            $model->author_id = Auth::user()->id;
            $result = $model->save();
            if ($result) {
                $outpot = ['status' => true, "message" => 'وضعیت  به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
            }
        } else {
            $model->status = Main::STATUS_ACTIVE;
            $model->author_id = Auth::user()->id;
            $model->save();
            $outpot = ['status' => true, 'message' => 'وضعیت  به روزرسانی شد.', 'result' => Main::userStatus(true)[$model->status]];
        }


        return response()->json($outpot);


    }
}
