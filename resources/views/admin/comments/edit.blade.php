<?php

use App\Models\Main;

$statusList = Main::userStatus();
$attributesName = Main::attributesName();
$perUrl=url()->route('admin.comments.index');
$pageName=$attributesName['update']." ". $attributesName['comment'] ." ". $model->title;
?>
@extends('admin.layouts.master')

@section('title-tag')

        {{ $pageName }}

@endsection



@section('breadCrumbs')

    <li class="breadcrumb-item font-size-12"><a
            href="{{ $perUrl  }}"> {{ $attributesName['manage'] ." ". $attributesName['comments']  }}</a>
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
                    <form action="{{ route('admin.comments.update', $model->id) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <section class="row">

                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['title'] }}</label>
                                    <input type="text" name="title" class="form-control form-control-sm"
                                           value="{{ old('title', $model->title) }}">
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
                                    <label for="">{{ $attributesName['description'] }}</label>
                                    <textarea type="text" name="description" style="height: 169px;"
                                              class="form-control form-control-sm">{{ old('description', $model->description) }}</textarea>
                                </div>
                                @error('description')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['status'] }}</label>
                                    <select class="form-control form-control-sm" name="status">
                                        <option value="">{{ $attributesName['DropdownLabel'] }}</option>
                                        @foreach ($statusList as $index => $item)
                                            <option value="{{ $index }}"
                                                    @if ($index ==  $model->status )
                                                        selected
                                                @endif
                                            >
                                                {{ $item }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                @error('status')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['score'] }}</label>
                                    <input type="text" name="score" class="form-control form-control-sm"
                                           value="{{ old('score', $model->score) }}">
                                </div>
                                @error('score')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                        </section>
                        <section class="row">

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['email'] }}</label>
                                    <input type="text" name="email" class="form-control form-control-sm"
                                           value="{{ old('email', $model->email) }}">
                                </div>
                                @error('email')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['website'] }}</label>
                                    <input type="text" name="website" class="form-control form-control-sm"
                                           value="{{ old('website', $model->website) }}">
                                </div>
                                @error('website')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                        </section>
                        <section class="row">

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['like'] }}</label>
                                    <input type="text" name="like" class="form-control form-control-sm"
                                           value="{{ old('like', $model->like) }}">
                                </div>
                                @error('like')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['diss_like'] }}</label>
                                    <input type="text" name="diss_like" class="form-control form-control-sm"
                                           value="{{ old('diss_like', $model->diss_like) }}">
                                </div>
                                @error('diss_like')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                        </section>
                        <section class="row">

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['positive_points'] }}</label>
                                    <input type="text" name="positive_points" class="form-control form-control-sm"
                                           value="{{ old('positive_points', $model->positive_points) }}">
                                </div>
                                @error('positive_points')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['negative_points'] }}</label>
                                    <input type="text" name="negative_points" class="form-control form-control-sm"
                                           value="{{ old('negative_points', $model->negative_points) }}">
                                </div>
                                @error('negative_points')
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
