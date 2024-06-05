<?php

use App\Models\Main;

$attributesName = Main::attributesName();
$pageName=$attributesName['manage'] ." ". $attributesName['permissionsLabel']  ;
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
                        دسترسی ها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.user.permission.create') }}" class="btn btn-info btn-sm">ایجاد دسترسی جدید</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام دسترسی </th>
                                <th>نام نقش ها </th>
                                <th>توضیحات دسترسی</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($models as $key => $model)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $model->name }}</td>
                                    <td>
                                        @if (empty($model->roles()->get()->toArray()))
                                            <span class="text-danger">برای این دسترسی هیچ نقشی تعریف نشده است</span>
                                        @else
                                            @foreach ($model->roles as $role)
                                                {{ $role->name }} <br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $model->description }}</td>
                                    <td class="width-22-rem text-left">
                                        <a href="{{ route('admin.user.permission.edit', $model->id) }}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> ویرایش</a>
                                        <form class="d-inline"
                                            action="{{ route('admin.user.permission.destroy', $model->id) }}"
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


@section('script')
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
