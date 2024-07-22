<?php

use App\Models\Main;

$statusList = Main::userStatus();
$attributesName = Main::attributesName();
$perUrl=url()->route('admin.orders.index');
$pageName=$attributesName['update']." ". $attributesName['order'] ." شماره سفارش '". $model->id."'";
?>
@extends('admin.layouts.master')

@section('title-tag')

        {{ $pageName }}

@endsection



@section('breadCrumbs')

    <li class="breadcrumb-item font-size-12"><a
            href="{{ $perUrl  }}"> {{ $attributesName['manage'] ." ". $attributesName['orders']  }}</a>
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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <p>لطفا خطاهای زیر را بررسی کنید:</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.orderitems.update', $model->id) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.orderitems._form',['order_id'=>$model->order_id,'model'=>$model,'statusList'=>$statusList,'attributesName'=>$attributesName])


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
