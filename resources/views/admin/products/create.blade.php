<?php

use App\Models\Main;

$statusList = Main::userStatus();

$attributesName = Main::attributesName();
$pageName = $attributesName['create'] . " " . $attributesName['product'];
$perUrl = url()->route('admin.products.index');
?>
@extends('admin.layouts.master')

@section('title-tag')

        {{ $pageName }}

@endsection
@section('breadCrumbs')
    <li class="breadcrumb-item font-size-12"><a
            href="{{ $perUrl }}"> {{ $attributesName['manage'] ." ". $attributesName['products']  }}</a>
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
                        {{ $attributesName['create']." ". $attributesName['product'] }}
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.products.index') }}"
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
                    <form action="{{ route('admin.products.store') }}" method="post"
                          enctype="multipart/form-data">
                        @csrf


                       @include('admin/products/_form', ['tags' => $tags,'categories' => $categories,'model'=>$model,'attributesName'=>$attributesName])

                        <section class="row mt-3">

                            <section class="col-12 col-md-6">
                                <button class="btn btn-primary btn-sm">{{ $attributesName['createButton'] }}</button>
                            </section>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>
@endsection
