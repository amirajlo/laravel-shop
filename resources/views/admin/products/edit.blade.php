<?php

use App\Models\Main;

$statusList = Main::userStatus();
$attributesName = Main::attributesName();
$filesTypeList = Main::filesTypeList();
$perUrl = url()->route('admin.products.index');
$pageName = $attributesName['update'] . " " . $attributesName['product'] . " " . $model->title;
?>
@extends('admin.layouts.master')

@section('title-tag')
        {{ $pageName }}
@endsection



@section('breadCrumbs')

    <li class="breadcrumb-item font-size-12"><a
            href="{{ $perUrl  }}"> {{ $attributesName['manage'] ." ". $attributesName['products']  }}</a>
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
                    <form action="{{ route('admin.products.update', $model->id) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('admin/products/_form', ['tags' => $tags,'categories' => $categories,'model'=>$model,'attributesName'=>$attributesName])


                        <section class="row mt-3">

                            <section class="col-12">
                                <button class="btn btn-primary btn-sm">{{ $attributesName['updateButton'] }}</button>
                            </section>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>
@endsection






