<?php

use App\Models\Main;

$attributesName = Main::attributesName();
$pageName=$attributesName['manage'] ." ". $attributesName['rolessLabel']  ;
?>
@extends('admin.layouts.master')

@section('title-tag')
    {{ $pageName }}
@endsection
@section('content')



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نقش ها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.user.role.create') }}" class="btn btn-info btn-sm">ایجاد نقش جدید</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام نقش </th>
                                <th>دسترسی ها</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($models as $key => $model)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $model->name }}</td>
                                    <td>
                                        @if (empty($model->permissions()->get()->toArray()))
                                            <span class="text-danger">برای این نقش هیچ سطح دسترسی تعریف نشده است</span>
                                        @else
                                            @foreach ($model->permissions as $permission)
                                                {{ $permission->name }} <br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="width-22-rem text-left">
                                        <a href="{{ route('admin.user.role.permission-form', $model->id) }}"
                                            class="btn btn-success btn-sm"><i class="fa fa-user-graduate"></i> دسترسی ها</a>
                                        <a href="{{ route('admin.user.role.edit', $model->id) }}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> ویرایش</a>
                                        <form class="d-inline" action="{{ route('admin.user.role.destroy', $model->id) }}"
                                            method="post">
                                            @csrf
                                            {{ method_field('delete') }}
                                            <button class="btn btn-danger btn-sm delete" type="submit"><i
                                                    class="fa fa-trash-alt"></i> حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </section>

            </section>
        </section>
    </section>
@endsection
