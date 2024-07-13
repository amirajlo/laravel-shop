<?php

use App\Models\Main;

$statusList = Main::userStatus();
$attributesName = Main::attributesName();
$perUrl=url()->route('admin.discounts.index');
$pageName=$attributesName['update']." ". $attributesName['discount'] ." ". $model->title;
?>
@extends('admin.layouts.master')

@section('head-tag')
    <link rel="stylesheet" href="{{ asset('admin-assets/datepicker_majid/jalalidatepicker.min.css') }}">
@endsection
    @section('title-tag')
        {{ $pageName }}
@endsection



@section('breadCrumbs')

    <li class="breadcrumb-item font-size-12"><a
            href="{{ $perUrl  }}"> {{ $attributesName['manage'] ." ". $attributesName['discounts']  }}</a>
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
                    <form action="{{ route('admin.discounts.update', $model->id) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('admin.discounts._form',['model'=>$model,'statusList'=>$statusList,'attributesName'=>$attributesName])

                        <section class="row">

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
