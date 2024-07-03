<?php

use App\Models\Main;

$statusList = Main::userStatus();

$attributesName = Main::attributesName();
$pageName = $attributesName['create'] . " " . $attributesName['orderitem'];
$perUrlOrder = url()->route('admin.orders.index');
$perUrl = url()->route('admin.orders.show', $model);
?>
@extends('admin.layouts.master')

@section('head-tag')
    <title>
        {{ $pageName }}
    </title>
@endsection
@section('breadCrumbs')
    <li class="breadcrumb-item font-size-12">
        <a href="{{ $perUrlOrder }}"> {{ $attributesName['manage'] ." ". $attributesName['orders']  }}</a>
    </li>
    <li class="breadcrumb-item font-size-12">
        <a href="{{ $perUrl }}"> {{ $attributesName['manage'] ." ". $attributesName['orderitems'] ." سفارش ".$model->id }}</a>
    </li>
    <li class="breadcrumb-item font-size-12 active"
        aria-current="page"> {{ $pageName }}</li>
@endsection
@section('content')

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        {{ $attributesName['create']." ". $attributesName['orderitem'] }}
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ $perUrl }}"
                       class="btn btn-info btn-sm">{{ $attributesName['Back'] }}</a>
                </section>

                <section>
                    <form action="{{ route('admin.orderitems.store') }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <section class="row">
                            <section class="col-12 col-md-12">
                                <input type="hidden" name="user_id" class="form-control form-control-sm"
                                       value="{{ old('user_id',$model->user_id) }}">
                                <input type="hidden" name="order_id" class="form-control form-control-sm"
                                       value="{{ old('order_id',$model->id) }}">
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['product_id'] }}</label>
                                    <input type="text" name="product_id" class="form-control form-control-sm"
                                           value="{{ old('product_id') }}">
                                </div>
                                @error('product_id')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['qty'] }}</label>
                                    <input type="text" name="qty" class="form-control form-control-sm"
                                           value="{{ old('qty') }}">
                                </div>
                                @error('qty')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['orderitems_description'] }}</label>
                                    <textarea type="text" name="description" style="height: 169px;"
                                              class="form-control form-control-sm">{{ old('description') }}</textarea>
                                </div>
                                @error('description')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                        </section>

                        <section class="row">
                            <section class="col-12">
                                <button class="btn btn-primary btn-sm">{{ $attributesName['createButton'] }}</button>
                            </section>
                        </section>

                    </form>
                </section>

            </section>
        </section>
    </section>
@endsection
