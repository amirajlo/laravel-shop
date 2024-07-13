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

                        <section class="row">

                            <section class="col-12 col-md-6">
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

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['sub_title'] }}</label>
                                    <input type="text" name="sub_title" class="form-control form-control-sm"
                                           value="{{ old('en_title', $model->sub_title) }}">
                                </div>
                                @error('sub_title')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>


                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['seo_title'] }}</label>
                                    <input type="text" name="seo_title" class="form-control form-control-sm"
                                           value="{{ old('seo_title', $model->seo_title) }}">
                                </div>
                                @error('seo_title')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['seo_description'] }}</label>
                                    <input type="text" name="seo_description" class="form-control form-control-sm"
                                           value="{{ old('seo_description', $model->seo_description) }}">
                                </div>
                                @error('seo_description')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">تاریخ انتشار</label>
                                    <input type="hidden" name="published_at" id="published_at"
                                           value="{{$model->published_at}}"
                                           class="form-control form-control-sm">
                                    <input type="text" data-jdp data-jdp-miladi-input="published_at" autocomplete="off"
                                           id="published_at_view" class="form-control form-control-sm"
                                           value="{{$oldPublished}}">
                                </div>
                                @error('published_at')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12">
                                <div class="form-group">
                                    <label for="tags">تگ ها</label>



                                    <select class="select2 form-control form-control-sm" name="tags[]" id="tags"
                                            multiple="multiple">
                                        @foreach($tags as $tag)
                                            <option
{{--                                                @if(in_array($tag->title,$modeltags))--}}
{{--                                                    selected--}}
{{--                                                @endif--}}
                                                value="{{$tag->title}}">{{$tag->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('tags')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['content_title'] }}</label>
                                    <input type="text" name="content_title" class="form-control form-control-sm"
                                           value="{{ old('content_title', $model->content_title) }}">
                                </div>
                                @error('content_title')
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
                                    <label for="">{{ $attributesName['description'] }}</label>
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

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['redirect'] }}</label>
                                    <input type="text" name="redirect" class="form-control form-control-sm"
                                           value="{{ old('redirect',$model->redirect) }}">
                                </div>
                                @error('redirect')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['canonical'] }}</label>
                                    <input type="text" name="canonical" class="form-control form-control-sm"
                                           value="{{ old('canonical',$model->canonical) }}">
                                </div>
                                @error('canonical')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">{{ $attributesName['sidebar'] }}</label>
                                    <textarea type="text" name="sidebar" style="height: 169px;"
                                              class="form-control form-control-sm">{{ old('sidebar',$model->sidebar) }}</textarea>
                                </div>
                                @error('sidebar')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="is_commentable">{{ $attributesName['is_commentable'] }}</label>
                                    <input type="checkbox" name="is_commentable" class="form-check-input" id="is_commentable"
                                           @if($model->is_commentable)
                                               checked
                                           @endif
                                            >
                                </div>
                                @error('is_commentable')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="main_image">Main Image:</label>
                                    <input type="file" name="main_image" id="main_image" class="form-control "
                                           accept="image/*">
                                </div>
                                @error('main_image')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            @if($mainImage)

                                <section class="row">
                                    <div class="col-md-2" id="{{$filesTypeList[$mainImage->type]}}-{{ $mainImage->id }}">
                                        <a data-url="{{route('admin.file.delete',$mainImage->id)}}" class="btn btn-sm btn-danger "
                                           onclick="return  confirm('آیا مطمئن هستید که می خواهید این تصویر را حذف کنید؟')?   deleteFile(this.getAttribute('data-url')):'' "
                                        >
                                            <i class="fa fa-undo "></i>
                                        </a>
                                        <img class="card-img-top" style="width: 200px; height: 65px;"
                                             src="{{ asset('uploads/'.$mainImage->path) }}" alt="{{$mainImage->alt}}">
                                    </div>
                                </section>
                            @endif
                        </section>
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
@section('script')
    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('admin-assets/datepicker_majid/jalalidatepicker.min.js') }}"></script>
    <script src="{{ asset('admin-assets/datepicker_majid/functions.js') }}"></script>
    <script>
        CKEDITOR.replace('description',{
            filebrowserUploadUrl: "{{route('main.upload', ['_token' => csrf_token() ])}}",
            filebrowserImageUploadUrl:"{{route('main.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.config.language='fa';
    </script>
    <script>
        $(document).ready(function () {

            jalaliDatepicker.startWatch({
          //      time:true,
         });
            document.querySelector("[data-jdp-miladi-input]").addEventListener("jdp:change", function (e) {
                var miladiInput = document.getElementById(this.getAttribute("data-jdp-miladi-input"));
                if (!this.value) {
                    miladiInput.value = "";
                    return;
                }
                var date = this.value.split("/");
                miladiInput.value = jalali_to_gregorian(date[0], date[1], date[2]).join("/")
            });

            $("#tags").select2({
                placeholder: 'لطفا تگ های خود را وارد نمایید',
                dir: "rtl",
                tags: true,

            });

        });
    </script>


@endsection
