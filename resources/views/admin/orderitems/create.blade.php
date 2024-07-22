<?php

use App\Models\Main;

$statusList = Main::userStatus();

$attributesName = Main::attributesName();
$pageName = $attributesName['create'] . " " . $attributesName['orderitem'] . " برای " .$attributesName['order']."  ".$model->orderTitle();  ;
$perUrlOrder = url()->route('admin.orders.index');
$perUrl = url()->route('admin.orders.show', $model);
?>
@extends('admin.layouts.master')

@section('title-tag')

        {{ $pageName }}

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
                        {{ $pageName }}
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
                        @include('admin.orderitems._form',['order_id'=>$model->id,'model'=>$model,'statusList'=>$statusList,'attributesName'=>$attributesName])


                        <section class="row">
                            <section class="col-12">
                                <button name="save" class="btn btn-primary btn-sm">{{ $attributesName['createButton'] }}</button>
                                <button name="saveAdd" class="btn btn-primary btn-sm">{{ $attributesName['createButtonAdd'] }}</button>
                            </section>
                        </section>

                    </form>
                </section>

            </section>
        </section>
    </section>
@endsection
