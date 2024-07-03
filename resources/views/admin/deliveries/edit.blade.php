<?php

use App\Models\Main;

$statusList = Main::userStatus();
$attributesName = Main::attributesName();
$perUrl=url()->route('admin.deliveries.index');
$pageName=$attributesName['update']." ". $attributesName['delivery'] ." ". $model->title;
?>
@extends('admin.layouts.master')

@section('head-tag')
    <title>
        {{ $pageName }}
    </title>
@endsection



@section('breadCrumbs')

    <li class="breadcrumb-item font-size-12"><a
            href="{{ $perUrl  }}"> {{ $attributesName['manage'] ." ". $attributesName['deliveries']  }}</a>
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
                    <form action="{{ route('admin.deliveries.update', $model->id) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')



                        <section class="row">

                        <section class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="">{{ $attributesName['title'] }}</label>
                                <input type="text" name="title" class="form-control form-control-sm"
                                       value="{{ old('title',$model->title) }}">
                            </div>
                            @error('title')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="">{{ $attributesName['deliveries_fee'] }}</label>
                                <input type="text" name="fee" class="form-control form-control-sm"
                                       value="{{ old('fee',$model->fee) }}">
                            </div>
                            @error('fee')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="">{{ $attributesName['deliveries_description'] }}</label>
                                <textarea type="text" name="description" style="height: 169px;"
                                          class="form-control form-control-sm">{{ old('description',$model->description) }}</textarea>
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
                                <button class="btn btn-primary btn-sm">{{ $attributesName['updateButton'] }}</button>
                            </section>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>
@endsection
