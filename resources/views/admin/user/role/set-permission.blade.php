@extends('admin.layouts.master')

@section('title-tag')
    دسترسی های نقش
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">نقش ها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> دسترسی نقش</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        دسترسی نقش
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3  pb-2">
                    <a href="{{ route('admin.user.role.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('admin.user.role.permission-update', $model->id) }}" method="post">
                        @csrf
                        @method('put')
                        <section class="row">

                            <section class="col-12">
                                <section class="row border-top mt-3 py-3">

                                    <section class="col-12 col-md-5">
                                        <div class="form-group">
                                            <label for="">نام نقش</label>
                                            <section>{{ $model->name }}</section>
                                        </div>
                                    </section>

                                    <section class="col-12 col-md-5">
                                        <div class="form-group">
                                            <label for="">توضیح نقش</label>
                                            <section>{{ $model->description }}</section>
                                        </div>
                                    </section>


                                    @php
                                        $modelPermissionsArray = $model->permissions->pluck('id')->toArray();
                                    @endphp
                                    @foreach ($models as $key => $per)
                                        <section class="col-md-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="permissions[]"
                                                    value="{{ $per->id }}" id="{{ $per->id }}"
                                                    @if (in_array($per->id, $modelPermissionsArray)) checked @endif />
                                                <label for="{{ $per->id }}"
                                                    class="form-check-label mr-3 mt-1">{{ $per->name }}</label>
                                            </div>
                                            <div class="mt-2">
                                                @error('permissions.' . $key)
                                                    <span class="alert_required bg-danger text-white p-1 rounded"
                                                        role="alert">
                                                        <strong>
                                                            {{ $message }}
                                                        </strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </section>
                                    @endforeach


                                    <section class="col-12 col-md-2">
                                        <button class="btn btn-primary btn-sm mt-md-4">ثبت</button>
                                    </section>

                                </section>
                            </section>

                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>
@endsection
