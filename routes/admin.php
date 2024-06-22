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
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['role:admin']], function () {
    Route::post('/upload', [MainController::class, 'upload'])->name('main.upload');
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard']);

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

    Route::group(['middleware' => ['permission:create post']], function () {
        // Routes accessible only by users with the 'create post' permission
    });
});
