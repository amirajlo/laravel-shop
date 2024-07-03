<?php

use App\Models\Main;

$attributesName = Main::attributesName();
$pageName = $attributesName['manage'] . " " . $attributesName['addresses'];

?>
@extends('admin.layouts.master')

@section('title-tag')
    {{ $pageName }}
@endsection
@section('breadCrumbs')
    <li class="breadcrumb-item font-size-12 "
        aria-current="page">{{ $pageName }}</li>
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
                    <a href="{{ route('admin.addresses.create') }}"
                       class="btn btn-info btn-sm">{{ $attributesName['create'] ." ". $attributesName['address'] . " ".$attributesName['new'] }}</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text"
                               placeholder="{{ $attributesName['searchPlaceHolder'] }}">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ $attributesName['title'] }}</th>
                            <th>{{ $attributesName['address_description'] }}</th>
                            <th>{{ $attributesName['postal_code'] }}</th>
                            <th>{{ $attributesName['user_id'] }}</th>




                            <th class="max-width-16-rem text-center"><i
                                    class="fa fa-cogs"></i> {{ $attributesName['setting'] }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($models as $key => $model)

                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $model->title }} </td>
                                <td>{{ $model->description }} </td>
                                <td>{{ $model->postal_code }} </td>
                                <td>{{ $model->user_id }} </td>




                                <td class="width-22-rem text-left">




                                    <a href="{{ route('admin.addresses.edit', $model->id) }}"
                                       class="btn btn-primary btn-sm"><i
                                            class="fa fa-edit"></i> {{ $attributesName['edit'] }}</a>
                                    <form class="d-inline"
                                          action="{{ route('admin.addresses.destroy', $model->id) }}"
                                          method="post">
                                        @csrf
                                        {{ method_field('delete') }}
                                        <button class="btn btn-danger btn-sm delete" type="submit"><i
                                                class="fa fa-trash-alt"></i> {{ $attributesName['delete'] }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </section>

            </section>
        </section>
    </section>
@endsection

@section('script')


    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
