<?php

use App\Models\Main;

$typeList = Main::categoriesTypeList();
$type = request("type");
if (!in_array($type, array_keys($typeList))) {
    $type = Main::CATEGORY_TYPE_PRODUCT;
}
$statusList = Main::userStatus();

$typeName = $typeList[$type];
$attributesName = Main::attributesName();
$pageName=$attributesName['create']." ". $attributesName['category'] ." ". $typeName;
$perUrl=url()->route('admin.categories.index',$type);
?>
@extends('admin.layouts.master')

@section('title-tag')

        {{ $pageName }}

@endsection
@section('breadCrumbs')
    <li class="breadcrumb-item font-size-12"><a
            href="{{ $perUrl }}"> {{ $attributesName['manage'] ." ". $attributesName['category'] ." ". $typeName }}</a>
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
                @if ($errors->any())
<section>

        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

</section>
                @endif

                <section>
                    <form action="{{ route('admin.categories.store') }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" class="form-control form-control-sm"
                               value="{{ $type }}">
                        @include('admin/categories/_form', ['categories' => $categories,'model'=>$model,'attributesName'=>$attributesName])

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
