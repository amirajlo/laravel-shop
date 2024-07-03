<?php

use App\Models\Main;

$statusList = Main::userStatus();
$attributesName = Main::attributesName();
$perUrl=url()->route('admin.addresses.index');
$pageName=$attributesName['update']." ". $attributesName['address'] ." ". $model->title;
?>
@extends('admin.layouts.master')

@section('head-address')
    <title>
        {{ $pageName }}
    </title>
@endsection



@section('breadCrumbs')

    <li class="breadcrumb-item font-size-12"><a
            href="{{ $perUrl  }}"> {{ $attributesName['manage'] ." ". $attributesName['addresses']  }}</a>
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
                    <form action="{{ route('admin.addresses.update', $model->id) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')




                        <section class="row">
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['user_id'] }}</label>
                                    <input type="text" name="user_id" class="form-control form-control-sm"
                                           value="{{ old('user_id', $model->user_id) }}">
                                </div>
                                @error('user_id')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
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
                                    <label for="">{{ $attributesName['province_id'] }}</label>
                                    <input type="text" name="province_id" class="form-control form-control-sm"
                                           value="{{ old('province_id', $model->province_id) }}">
                                </div>
                                @error('province_id')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['city_id'] }}</label>
                                    <input type="text" name="city_id" class="form-control form-control-sm"
                                           value="{{ old('city_id', $model->city_id) }}">
                                </div>
                                @error('city_id')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['town_id'] }}</label>
                                    <input type="text" name="town_id" class="form-control form-control-sm"
                                           value="{{ old('town_id', $model->town_id) }}">
                                </div>
                                @error('town_id')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['address_description'] }}</label>
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


                        </section>
                        <section class="row">
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['mobile'] }}</label>
                                    <input type="text" name="mobile" class="form-control form-control-sm"
                                           value="{{ old('mobile', $model->mobile) }}">
                                </div>
                                @error('mobile')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['phone'] }}</label>
                                    <input type="text" name="phone" class="form-control form-control-sm"
                                           value="{{ old('phone', $model->phone) }}">
                                </div>
                                @error('phone')
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
                                    <label for="">{{ $attributesName['postal_code'] }}</label>
                                    <input type="text" name="postal_code" class="form-control form-control-sm"
                                           value="{{ old('postal_code', $model->postal_code) }}">
                                </div>
                                @error('postal_code')
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
                                    <label for="">{{ $attributesName['latitude'] }}</label>
                                    <input type="text" name="latitude" class="form-control form-control-sm"
                                           value="{{ old('latitude', $model->latitude) }}">
                                </div>
                                @error('latitude')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['longitude'] }}</label>
                                    <input type="text" name="longitude" class="form-control form-control-sm"
                                           value="{{ old('longitude', $model->longitude) }}">
                                </div>
                                @error('longitude')
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
