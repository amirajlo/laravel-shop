<?php

use App\Models\Main;

$statusList = Main::userStatus();
$typeList = Main::categoriesTypeList();
$type=$model->type;
$typeName = $typeList[$type];

$attributesName = Main::attributesName();
$pageName=$attributesName['update']." ". $attributesName['category'] ." ". $model->title;
$perUrl=url()->route('admin.categories.index',$type);
?>
@extends('admin.layouts.master')

@section('title-tag')

        {{ $pageName }}

@endsection

@section('breadCrumbs')

    <li class="breadcrumb-item font-size-12"><a
            href="{{ $perUrl  }}"> {{ $attributesName['manage'] ." ". $attributesName['category'] ." ". $typeName }}</a>
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
                        {{ $attributesName['update']." ". $attributesName['category']." ".$model->title }}
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ $perUrl  }}"
                       class="btn btn-info btn-sm">{{ $attributesName['Back'] }}</a>
                </section>

                <section>
                    <form action="{{ route('admin.categories.update', $model->id) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('admin/categories/_form', ['categories' => $categories,'model'=>$model,'attributesName'=>$attributesName])

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
