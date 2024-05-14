<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', [AdminDashboardController::class, 'dashboard']);
Route::get('/', [AdminDashboardController::class, 'dashboard']);

Route::prefix('user')->namespace('User')->group(function () {

    //admin-user
    Route::prefix('admin-user')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('admin.user.admin-user.index');
        Route::get('/create', [AdminUserController::class, 'create'])->name('admin.user.admin-user.create');
        Route::post('/store', [AdminUserController::class, 'store'])->name('admin.user.admin-user.store');
        Route::get('/edit/{admin}', [AdminUserController::class, 'edit'])->name('admin.user.admin-user.edit');

        Route::put('/update/{admin}', [AdminUserController::class, 'update'])->name('admin.user.admin-user.update');
        Route::delete('/destroy/{admin}', [AdminUserController::class, 'destroy'])->name('admin.user.admin-user.destroy');
        Route::post('/status/{user}', [AdminUserController::class, 'status'])->name('admin.user.admin-user.status');

        Route::get('/activation/{user}', [AdminUserController::class, 'activation'])->name('admin.user.admin-user.activation');
        Route::get('/roles/{admin}', [AdminUserController::class, 'roles'])->name('admin.user.admin-user.roles');
        Route::post('/roles/{admin}/store', [AdminUserController::class, 'rolesStore'])->name('admin.user.admin-user.roles.store');
        Route::get('/permissions/{admin}', [AdminUserController::class, 'permissions'])->name('admin.user.admin-user.permissions');
        Route::post('/permissions/{admin}/store', [AdminUserController::class, 'permissionsStore'])->name('admin.user.admin-user.permissions.store');
    });

    //customer
    Route::prefix('customer')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('admin.user.customer.index');
        Route::get('/create', [CustomerController::class, 'create'])->name('admin.user.customer.create');
        Route::post('/store', [CustomerController::class, 'store'])->name('admin.user.customer.store');
        Route::get('/edit/{user}', [CustomerController::class, 'edit'])->name('admin.user.customer.edit');
        Route::put('/update/{user}', [CustomerController::class, 'update'])->name('admin.user.customer.update');
        Route::delete('/destroy/{user}', [CustomerController::class, 'destroy'])->name('admin.user.customer.destroy');
        Route::get('/status/{user}', [CustomerController::class, 'status'])->name('admin.user.customer.status');
        Route::get('/activation/{user}', [CustomerController::class, 'activation'])->name('admin.user.customer.activation');
    });

    //role
    Route::prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('admin.user.role.index');
        Route::get('/create', [RoleController::class, 'create'])->name('admin.user.role.create');
        Route::post('/store', [RoleController::class, 'store'])->name('admin.user.role.store');
        Route::get('/edit/{role}', [RoleController::class, 'edit'])->name('admin.user.role.edit');
        Route::put('/update/{role}', [RoleController::class, 'update'])->name('admin.user.role.update');
        Route::delete('/destroy/{role}', [RoleController::class, 'destroy'])->name('admin.user.role.destroy');
        Route::get('/permission-form/{role}', [RoleController::class, 'permissionForm'])->name('admin.user.role.permission-form');
        Route::put('/permission-update/{role}', [RoleController::class, 'permissionUpdate'])->name('admin.user.role.permission-update');
    });

    //permission
    Route::prefix('permission')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('admin.user.permission.index');
        Route::get('/create', [PermissionController::class, 'create'])->name('admin.user.permission.create');
        Route::post('/store', [PermissionController::class, 'store'])->name('admin.user.permission.store');
        Route::get('/edit/{permission}', [PermissionController::class, 'edit'])->name('admin.user.permission.edit');
        Route::put('/update/{permission}', [PermissionController::class, 'update'])->name('admin.user.permission.update');
        Route::delete('/destroy/{permission}', [PermissionController::class, 'destroy'])->name('admin.user.permission.destroy');
    });
});

