<?php
//https://github.com/majidh1/JalaliDatePicker
use App\Models\Main;

$statusList = Main::userStatus();

$attributesName = Main::attributesName();
$pageName=$attributesName['create']." ". $attributesName['article'] ;
$perUrl=url()->route('admin.articles.index');
?>
@extends('admin.layouts.master')
@section('title-tag')
    <link rel="stylesheet" href="{{ asset('admin-assets/datepicker_majid/jalalidatepicker.min.css') }}">
@endsection
@section('title-tag')

        {{ $pageName }}

@endsection
@section('breadCrumbs')
    <li class="breadcrumb-item font-size-12"><a
            href="{{ $perUrl }}"> {{ $attributesName['manage'] ." ". $attributesName['articles']  }}</a>
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
                        {{ $attributesName['create']." ". $attributesName['article'] }}
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.articles.index') }}"
                       class="btn btn-info btn-sm">{{ $attributesName['Back'] }}</a>
                </section>

                <section>
                    <form action="{{ route('admin.articles.store') }}" method="post" id="form"
                          enctype="multipart/form-data">
                        @csrf

                        @include('admin/articles/_form', ['categories' => $categories,'model'=>$model,'attributesName'=>$attributesName])

                        <section class="row mt-3">

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

