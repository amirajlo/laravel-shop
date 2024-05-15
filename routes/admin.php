<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminCustomerController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['role:admin']], function () {

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

});

Route::group(['middleware' => ['permission:create post']], function () {
    // Routes accessible only by users with the 'create post' permission
});
