<?php

use App\Http\Controllers\Admin\AdminCategoriesController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminTagsController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminBrandsController;
use App\Http\Controllers\Admin\AdminArticlesController;
use App\Http\Controllers\Admin\AdminProductsController;
use App\Http\Controllers\Admin\AdminCommentsController;
use App\Http\Controllers\Admin\AdminGalleriesController;
use App\Http\Controllers\Admin\AdminDiscountsController;
use App\Http\Controllers\Admin\AdminOrdersController;
use App\Http\Controllers\Admin\AdminOrderItemsController;
use App\Http\Controllers\Admin\AdminPaymentsController;
use App\Http\Controllers\Admin\AdminDeliveriesController;
use App\Http\Controllers\Admin\AdminAddressesController;
use App\Http\Controllers\Admin\AdminFilesController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['role:admin']], function () {

    Route::post('/upload', [MainController::class, 'upload'])->name('main.upload');
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard']);
    Route::get('/ajax',  [AdminDashboardController::class, 'ajax']);
    Route::get('/address/{id}', [AdminDashboardController::class, 'getAddress']);
    Route::get('/', [AdminDashboardController::class, 'dashboard']);


    Route::prefix('user')->namespace('User')->group(function () {

        //admin-user
        Route::prefix('admin-user')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('admin.user.admin-user.index');
            Route::get('/create', [AdminUserController::class, 'create'])->name('admin.user.admin-user.create');
            Route::post('/store', [AdminUserController::class, 'store'])->name('admin.user.admin-user.store');
            Route::get('/edit/{model}', [AdminUserController::class, 'edit'])->name('admin.user.admin-user.edit');

            Route::put('/update/{model}', [AdminUserController::class, 'update'])->name('admin.user.admin-user.update');
            Route::delete('/destroy/{model}', [AdminUserController::class, 'destroy'])->name('admin.user.admin-user.destroy');
            Route::post('/status/{model}', [AdminUserController::class, 'status'])->name('admin.user.admin-user.status');
            Route::get('/roles/{model}', [AdminUserController::class, 'roles'])->name('admin.user.admin-user.roles');
            Route::post('/roles/{model}/store', [AdminUserController::class, 'rolesStore'])->name('admin.user.admin-user.roles.store');
            Route::get('/permissions/{model}', [AdminUserController::class, 'permissions'])->name('admin.user.admin-user.permissions');
            Route::post('/permissions/{model}/store', [AdminUserController::class, 'permissionsStore'])->name('admin.user.admin-user.permissions.store');
        });

        //customer
        Route::prefix('customer')->group(function () {
            Route::get('/', [AdminCustomerController::class, 'index'])->name('admin.user.customer.index');
            Route::get('/create', [AdminCustomerController::class, 'create'])->name('admin.user.customer.create');
            Route::post('/store', [AdminCustomerController::class, 'store'])->name('admin.user.customer.store');
            Route::get('/edit/{model}', [AdminCustomerController::class, 'edit'])->name('admin.user.customer.edit');
            Route::put('/update/{model}', [AdminCustomerController::class, 'update'])->name('admin.user.customer.update');
            Route::delete('/destroy/{model}', [AdminCustomerController::class, 'destroy'])->name('admin.user.customer.destroy');
            Route::post('/status/{model}', [AdminCustomerController::class, 'status'])->name('admin.user.customer.status');
        });

        //role
        Route::prefix('role')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('admin.user.role.index');
            Route::get('/create', [RoleController::class, 'create'])->name('admin.user.role.create');
            Route::post('/store', [RoleController::class, 'store'])->name('admin.user.role.store');
            Route::get('/edit/{model}', [RoleController::class, 'edit'])->name('admin.user.role.edit');
            Route::put('/update/{model}', [RoleController::class, 'update'])->name('admin.user.role.update');
            Route::delete('/destroy/{model}', [RoleController::class, 'destroy'])->name('admin.user.role.destroy');
            Route::get('/permission-form/{model}', [RoleController::class, 'permissionForm'])->name('admin.user.role.permission-form');
            Route::put('/permission-update/{model}', [RoleController::class, 'permissionUpdate'])->name('admin.user.role.permission-update');
        });

        //permission
        Route::prefix('permission')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('admin.user.permission.index');
            Route::get('/create', [PermissionController::class, 'create'])->name('admin.user.permission.create');
            Route::post('/store', [PermissionController::class, 'store'])->name('admin.user.permission.store');
            Route::get('/edit/{model}', [PermissionController::class, 'edit'])->name('admin.user.permission.edit');
            Route::put('/update/{model}', [PermissionController::class, 'update'])->name('admin.user.permission.update');
            Route::delete('/destroy/{model}', [PermissionController::class, 'destroy'])->name('admin.user.permission.destroy');
        });
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [AdminCategoriesController::class, 'index'])->name('admin.categories.index');
        Route::get('/index/{type?}/{parent?}', [AdminCategoriesController::class, 'index'])->name('admin.categories.index');
        Route::get('/create/{type?}', [AdminCategoriesController::class, 'create'])->name('admin.categories.create');
        Route::post('/store', [AdminCategoriesController::class, 'store'])->name('admin.categories.store');
        Route::get('/edit/{model}', [AdminCategoriesController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/update/{model}', [AdminCategoriesController::class, 'update'])->name('admin.categories.update');
        Route::delete('/destroy/{model}', [AdminCategoriesController::class, 'destroy'])->name('admin.categories.destroy');
        Route::post('/status/{model}', [AdminCategoriesController::class, 'status'])->name('admin.categories.status');
    });

    Route::prefix('tags')->group(function () {
        Route::get('/', [AdminTagsController::class, 'index'])->name('admin.tags.index');
        Route::get('/create', [AdminTagsController::class, 'create'])->name('admin.tags.create');
        Route::post('/store', [AdminTagsController::class, 'store'])->name('admin.tags.store');
        Route::get('/edit/{model}', [AdminTagsController::class, 'edit'])->name('admin.tags.edit');
        Route::put('/update/{model}', [AdminTagsController::class, 'update'])->name('admin.tags.update');
        Route::delete('/destroy/{model}', [AdminTagsController::class, 'destroy'])->name('admin.tags.destroy');
        Route::post('/status/{model}', [AdminTagsController::class, 'status'])->name('admin.tags.status');
    });

    Route::prefix('brands')->group(function () {
        Route::get('/', [AdminBrandsController::class, 'index'])->name('admin.brands.index');
        Route::get('/create', [AdminBrandsController::class, 'create'])->name('admin.brands.create');
        Route::post('/store', [AdminBrandsController::class, 'store'])->name('admin.brands.store');
        Route::get('/edit/{model}', [AdminBrandsController::class, 'edit'])->name('admin.brands.edit');
        Route::put('/update/{model}', [AdminBrandsController::class, 'update'])->name('admin.brands.update');
        Route::delete('/destroy/{model}', [AdminBrandsController::class, 'destroy'])->name('admin.brands.destroy');
        Route::post('/status/{model}', [AdminBrandsController::class, 'status'])->name('admin.brands.status');
    });


    Route::prefix('articles')->group(function () {
        Route::get('/', [AdminArticlesController::class, 'index'])->name('admin.articles.index');
        Route::get('/create', [AdminArticlesController::class, 'create'])->name('admin.articles.create');
        Route::post('/store', [AdminArticlesController::class, 'store'])->name('admin.articles.store');
        Route::get('/edit/{model}', [AdminArticlesController::class, 'edit'])->name('admin.articles.edit');
        Route::put('/update/{model}', [AdminArticlesController::class, 'update'])->name('admin.articles.update');
        Route::delete('/destroy/{model}', [AdminArticlesController::class, 'destroy'])->name('admin.articles.destroy');
        Route::post('/status/{model}', [AdminArticlesController::class, 'status'])->name('admin.articles.status');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [AdminProductsController::class, 'index'])->name('admin.products.index');
        Route::get('/create', [AdminProductsController::class, 'create'])->name('admin.products.create');
        Route::post('/store', [AdminProductsController::class, 'store'])->name('admin.products.store');
        Route::get('/edit/{model}', [AdminProductsController::class, 'edit'])->name('admin.products.edit');
        Route::put('/update/{model}', [AdminProductsController::class, 'update'])->name('admin.products.update');
        Route::delete('/destroy/{model}', [AdminProductsController::class, 'destroy'])->name('admin.products.destroy');
        Route::post('/status/{model}', [AdminProductsController::class, 'status'])->name('admin.products.status');
    });

    Route::prefix('comments')->group(function () {
        Route::get('/', [AdminCommentsController::class, 'index'])->name('admin.comments.index');
        Route::get('/create', [AdminCommentsController::class, 'create'])->name('admin.comments.create');
        Route::post('/store', [AdminCommentsController::class, 'store'])->name('admin.comments.store');
        Route::get('/edit/{model}', [AdminCommentsController::class, 'edit'])->name('admin.comments.edit');
        Route::put('/update/{model}', [AdminCommentsController::class, 'update'])->name('admin.comments.update');
        Route::delete('/destroy/{model}', [AdminCommentsController::class, 'destroy'])->name('admin.comments.destroy');
        Route::post('/status/{model}', [AdminCommentsController::class, 'status'])->name('admin.comments.status');
    });


    Route::prefix('addresses')->group(function () {
        Route::get('/', [AdminAddressesController::class, 'index'])->name('admin.addresses.index');
        Route::get('/create', [AdminAddressesController::class, 'create'])->name('admin.addresses.create');
        Route::post('/store', [AdminAddressesController::class, 'store'])->name('admin.addresses.store');
        Route::get('/edit/{model}', [AdminAddressesController::class, 'edit'])->name('admin.addresses.edit');
        Route::put('/update/{model}', [AdminAddressesController::class, 'update'])->name('admin.addresses.update');
        Route::delete('/destroy/{model}', [AdminAddressesController::class, 'destroy'])->name('admin.addresses.destroy');
        Route::post('/status/{model}', [AdminAddressesController::class, 'status'])->name('admin.addresses.status');
    });


    Route::prefix('galleries')->group(function () {
        Route::get('/', [AdminGalleriesController::class, 'index'])->name('admin.galleries.index');
        Route::get('/create', [AdminGalleriesController::class, 'create'])->name('admin.galleries.create');
        Route::post('/store', [AdminGalleriesController::class, 'store'])->name('admin.galleries.store');
        Route::get('/edit/{model}', [AdminGalleriesController::class, 'edit'])->name('admin.galleries.edit');
        Route::put('/update/{model}', [AdminGalleriesController::class, 'update'])->name('admin.galleries.update');
        Route::delete('/destroy/{model}', [AdminGalleriesController::class, 'destroy'])->name('admin.galleries.destroy');
        Route::post('/status/{model}', [AdminGalleriesController::class, 'status'])->name('admin.galleries.status');
    });

    Route::prefix('deliveries')->group(function () {
        Route::get('/', [AdminDeliveriesController::class, 'index'])->name('admin.deliveries.index');
        Route::get('/create', [AdminDeliveriesController::class, 'create'])->name('admin.deliveries.create');
        Route::post('/store', [AdminDeliveriesController::class, 'store'])->name('admin.deliveries.store');
        Route::get('/edit/{model}', [AdminDeliveriesController::class, 'edit'])->name('admin.deliveries.edit');
        Route::put('/update/{model}', [AdminDeliveriesController::class, 'update'])->name('admin.deliveries.update');
        Route::delete('/destroy/{model}', [AdminDeliveriesController::class, 'destroy'])->name('admin.deliveries.destroy');
        Route::post('/status/{model}', [AdminDeliveriesController::class, 'status'])->name('admin.deliveries.status');
    });


    Route::prefix('discounts')->group(function () {
        Route::get('/', [AdminDiscountsController::class, 'index'])->name('admin.discounts.index');
        Route::get('/create', [AdminDiscountsController::class, 'create'])->name('admin.discounts.create');
        Route::post('/store', [AdminDiscountsController::class, 'store'])->name('admin.discounts.store');
        Route::get('/edit/{model}', [AdminDiscountsController::class, 'edit'])->name('admin.discounts.edit');
        Route::put('/update/{model}', [AdminDiscountsController::class, 'update'])->name('admin.discounts.update');
        Route::delete('/destroy/{model}', [AdminDiscountsController::class, 'destroy'])->name('admin.discounts.destroy');
        Route::post('/status/{model}', [AdminDiscountsController::class, 'status'])->name('admin.discounts.status');
    });

    Route::prefix('payments')->group(function () {
        Route::get('/', [AdminPaymentsController::class, 'index'])->name('admin.payments.index');
        Route::delete('/destroy/{model}', [AdminPaymentsController::class, 'destroy'])->name('admin.payments.destroy');
        Route::get('/show/{model}', [AdminPaymentsController::class, 'show'])->name('admin.payments.show');
    });

    Route::prefix('file')->group(function () {


        Route::delete('/delete/{model}', [AdminfilesController::class, 'delete'])->name('admin.file.delete');

    });


    Route::prefix('orders')->group(function () {
        Route::get('/', [AdminOrdersController::class, 'index'])->name('admin.orders.index');
        Route::get('/create', [AdminOrdersController::class, 'create'])->name('admin.orders.create');
        Route::post('/store', [AdminOrdersController::class, 'store'])->name('admin.orders.store');
        Route::get('/edit/{model}', [AdminOrdersController::class, 'edit'])->name('admin.orders.edit');
        Route::get('/show/{model}', [AdminOrdersController::class, 'show'])->name('admin.orders.show');
        Route::post('/checkout/{model}', [AdminOrdersController::class, 'checkout'])->name('admin.orders.checkout');
        Route::put('/update/{model}', [AdminOrdersController::class, 'update'])->name('admin.orders.update');
        Route::delete('/destroy/{model}', [AdminOrdersController::class, 'destroy'])->name('admin.orders.destroy');
        Route::post('/status/{model}', [AdminOrdersController::class, 'status'])->name('admin.orders.status');
    });

    Route::prefix('orderitems')->group(function () {
        Route::get('/', [AdminOrderItemsController::class, 'index'])->name('admin.orderitems.index');
        Route::get('/create/{model}', [AdminOrderItemsController::class, 'create'])->name('admin.orderitems.create');
        Route::post('/store', [AdminOrderItemsController::class, 'store'])->name('admin.orderitems.store');
        Route::get('/edit/{model}', [AdminOrderItemsController::class, 'edit'])->name('admin.orderitems.edit');
        Route::put('/update/{model}', [AdminOrderItemsController::class, 'update'])->name('admin.orderitems.update');
        Route::delete('/destroy/{model}', [AdminOrderItemsController::class, 'destroy'])->name('admin.orderitems.destroy');
        Route::post('/status/{model}', [AdminOrderItemsController::class, 'status'])->name('admin.orderitems.status');
    });

    Route::group(['middleware' => ['permission:create post']], function () {
        // Routes accessible only by users with the 'create post' permission
    });
});
