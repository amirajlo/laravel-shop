<?php

use App\Models\Main;
use Morilog\Jalali;


$modeltags = $model->tags;
$oldPublished="";
if(!empty($model->published_at)){
    $dateTimeInput = explode(' ', $model->published_at);
    $date = explode('-', $dateTimeInput[0]);
    $datePart0 = Morilog\Jalali\CalendarUtils::toJalali($date[0], $date[1], $date[2]);
    $datePart0 = implode('/', $datePart0);
    $oldPublished = $datePart0 . " " . $dateTimeInput[1];

}

$statusList = Main::userStatus();
$attributesName = Main::attributesName();
$filesTypeList =Main::filesTypeList();
$perUrl = url()->route('admin.articles.index');
$pageName = $attributesName['update'] . " " . $attributesName['article'] . " " . $model->title;
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
            href="{{ $perUrl  }}"> {{ $attributesName['manage'] ." ". $attributesName['articles']  }}</a>
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
                    <form action="{{ route('admin.articles.update', $model->id) }}" method="post" id="form"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('admin/articles/_form', ['categories' => $categories,'model'=>$model,'attributesName'=>$attributesName])

                        <section class="row mt-3">

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
