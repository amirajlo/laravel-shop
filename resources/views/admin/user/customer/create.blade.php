<?php
use App\Models\Main;
$sexList=Main::sexList();
$typeList=Main::typeList();
$statusList=Main::userStatus();
$attributesName=Main::attributesName();
?>
@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش کاربر ادمین</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#"> {{ $attributesName['home'] }}</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#"> {{ $attributesName['part']." ".$attributesName['users'] }}</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">{{ $attributesName['users']." ".$attributesName['userLabel'] }}</li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> {{ $attributesName['create']." ". $attributesName['user']." ".$attributesName['userLabel'] }}</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        {{ $attributesName['create']." ". $attributesName['user']." ".$attributesName['userLabel'] }}
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.user.customer.index') }}" class="btn btn-info btn-sm">{{ $attributesName['Back'] }}</a>
                </section>

                <section>
                    <form action="{{ route('admin.user.customer.store') }}" method="post"
                          enctype="multipart/form-data">
                        @csrf


                        <h2>مشخصات حساب</h2>
                        <hr/>
                        <section class="row">
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['username'] }}</label>
                                    <input type="text" name="username" class="form-control form-control-sm"
                                           value="{{ old('username') }}">
                                </div>
                                @error('username')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['email'] }}</label>
                                    <input type="text" name="email" class="form-control form-control-sm"
                                           value="{{ old('email') }}">
                                </div>
                                @error('email')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['mobile'] }}</label>
                                    <input type="text" name="mobile" class="form-control form-control-sm"
                                           value="{{ old('mobile') }}">
                                </div>
                                @error('mobile')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['password'] }}</label>
                                    <input type="password" name="password" class="form-control form-control-sm"
                                           value="">
                                </div>
                                @error('password')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                        </section>

                        <h2>مشخصات کاربر</h2>
                        <hr/>
                        <section class="row">

                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['user_type'] }}</label>
                                    <select  class="form-control form-control-sm" name="type">
                                        <option value="">{{ $attributesName['DropdownLabel'] }} </option>
                                        @foreach ($typeList as $index => $item)
                                            <option value="{{ $index }}"
                                                    @if ($index ==  old('type') )
                                                        selected
                                                @endif
                                            >
                                                {{ $item }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                @error('type')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['corporate_name'] }}</label>
                                    <input type="text" name="corporate_name" class="form-control form-control-sm"
                                           value="{{ old('corporate_name') }}">
                                </div>
                                @error('corporate_name')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['first_name'] }}</label>
                                    <input type="text" name="first_name" class="form-control form-control-sm"
                                           value="{{ old('first_name') }}">
                                </div>
                                @error('first_name')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['last_name'] }}</label>
                                    <input type="text" name="last_name" class="form-control form-control-sm"
                                           value="{{ old('last_name') }}">
                                </div>
                                @error('last_name')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>



                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['sex'] }}</label>
                                    <select  class="form-control form-control-sm" name="sex">
                                        <option value="">{{ $attributesName['DropdownLabel'] }}</option>
                                        @foreach ($sexList as $index => $item)
                                            <option value="{{ $index }}"
                                                    @if ($index ==  old('sex') )
                                                        selected
                                                @endif
                                            >
                                                {{ $item }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                @error('sex')
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
                                    <select  class="form-control form-control-sm" name="status">
                                        <option value="">{{ $attributesName['DropdownLabel'] }}</option>
                                        @foreach ($statusList as $index => $item)
                                            <option value="{{ $index }}"
                                                    @if ($index ==  old('status') )
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
                                    <label for="">{{ $attributesName['mobile_sms'] }}</label>
                                    <input type="text" name="mobile_sms" class="form-control form-control-sm"
                                           value="{{ old('mobile_sms') }}">
                                </div>
                                @error('mobile_sms')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['national_code'] }}</label>
                                    <input type="text" name="national_code" class="form-control form-control-sm"
                                           value="{{ old('national_code') }}">
                                </div>
                                @error('national_code')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>


                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['economical_code'] }}</label>
                                    <input type="text" name="economical_code" class="form-control form-control-sm"
                                           value="{{ old('economical_code') }}">
                                </div>
                                @error('economical_code')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['register_code'] }}</label>
                                    <input type="text" name="register_code" class="form-control form-control-sm"
                                           value="{{ old('register_code') }}">
                                </div>
                                @error('register_code')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['phone1'] }}</label>
                                    <input type="text" name="phone1" class="form-control form-control-sm"
                                           value="{{ old('phone1') }}">
                                </div>
                                @error('phone1')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['phone2'] }}</label>
                                    <input type="text" name="phone2" class="form-control form-control-sm"
                                           value="{{ old('phone2') }}">
                                </div>
                                @error('phone2')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>


                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['phone3'] }}</label>
                                    <input type="text" name="phone3" class="form-control form-control-sm"
                                           value="{{ old('phone3') }}">
                                </div>
                                @error('phone3')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['user_description'] }}</label>
                                    <textarea type="text" name="description" style="height: 169px;" class="form-control form-control-sm">{{ old('description') }}</textarea>
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
                        <h2>آدرس</h2>
                        <hr/>

                        <section class="row">

                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['province_id'] }}</label>
                                    <select  class="form-control form-control-sm" name="province_id">
                                        <option value="">{{ $attributesName['DropdownLabel'] }}</option>
                                    </select>
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
                                    <select  class="form-control form-control-sm" name="city_id">
                                        <option value="">{{ $attributesName['DropdownLabel'] }}</option>
                                    </select>
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
                                    <label for="">{{ $attributesName['address'] }}</label>
                                    <input type="text" name="address" class="form-control form-control-sm"
                                           value="{{ old('address') }}">
                                </div>
                                @error('address')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['postal_code'] }}</label>
                                    <input type="text" name="postal_code" class="form-control form-control-sm"
                                           value="{{ old('postal_code') }}">
                                </div>
                                @error('postal_code')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>










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
