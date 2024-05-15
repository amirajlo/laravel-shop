<?php

use App\Models\Main;

$attributesName = Main::attributesName();
?>
@extends('admin.layouts.master')

@section('head-tag')
    <title>

        {{ $attributesName['manage'] ." ". $attributesName['usersLabel'] }}
    </title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#"> {{ $attributesName['home'] }}</a></li>
            <li class="breadcrumb-item font-size-12"><a
                    href="#"> {{ $attributesName['part']." ".$attributesName['users'] }}</a></li>
            <li class="breadcrumb-item font-size-12 active"
                aria-current="page">{{ $attributesName['users']." ".$attributesName['userLabel'] }}</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        {{ $attributesName['manage'] ." ". $attributesName['usersLabel'] }}
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.user.customer.create') }}"
                       class="btn btn-info btn-sm">{{ $attributesName['create'] ." ". $attributesName['userLabel'] . " ".$attributesName['new'] }}</a>
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
                            <th>{{ $attributesName['first_name'] }}</th>
                            <th>{{ $attributesName['username'] }}</th>
                            <th>{{ $attributesName['email'] }}</th>
                            <th>{{ $attributesName['mobile'] }}</th>
                            <th>{{ $attributesName['status'] }}</th>
                            <th class="max-width-16-rem text-center"><i
                                    class="fa fa-cogs"></i> {{ $attributesName['setting'] }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($models as $key => $user)

                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $user->first_name }} {{ $user->last_name }} </td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobile }}</td>

                                <td id="status-{{ $user->id }}">
                                    {!! Main::userStatus(true)[$user->status] !!}
                                </td>

                                <td class="width-22-rem text-left">


                                    <label  id="statusb-{{ $user->id }}" class="btn btn-warning btn-sm"
                                           onclick="changeStatus({{ $user->id }})"
                                           data-url="{{ route('admin.user.customer.status', $user->id) }}">
                                        <i class="fa fa-undo "></i>
                                    </label>


                                    <a href="{{ route('admin.user.customer.edit', $user->id) }}"
                                       class="btn btn-primary btn-sm"><i
                                            class="fa fa-edit"></i> {{ $attributesName['edit'] }}</a>
                                    <form class="d-inline"
                                          action="{{ route('admin.user.customer.destroy', $user->id) }}"
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
    <script type="text/javascript">
        function changeStatus(id) {
            var element = $("#statusb-" + id)
            var url = element.attr('data-url')
            var csrf = "{{ csrf_token() }}";

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: csrf
                },
                success: function (response) {
                    if (response.status) {
                        document.getElementById('status-'+id).innerHTML = response.result;
                        successToast( response.message)

                    } else {

                        errorToast( response.message)
                    }
                },
                error: function () {

                    errorToast('ارتباط برقرار نشد')
                }
            });

            function successToast(message) {

                var successToastTag = '<section class="toast" data-delay="5000">\n' +
                    '<section class="toast-body py-3 d-flex bg-success text-white">\n' +
                    '<strong class="ml-auto">' + message + '</strong>\n' +
                    '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
                    '<span aria-hidden="true">&times;</span>\n' +
                    '</button>\n' +
                    '</section>\n' +
                    '</section>';

                $('.toast-wrapper').append(successToastTag);
                $('.toast').toast('show').delay(5500).queue(function () {
                    $(this).remove();
                })
            }

            function errorToast(message) {

                var errorToastTag = '<section class="toast" data-delay="5000">\n' +
                    '<section class="toast-body py-3 d-flex bg-danger text-white">\n' +
                    '<strong class="ml-auto">' + message + '</strong>\n' +
                    '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
                    '<span aria-hidden="true">&times;</span>\n' +
                    '</button>\n' +
                    '</section>\n' +
                    '</section>';

                $('.toast-wrapper').append(errorToastTag);
                $('.toast').toast('show').delay(5500).queue(function () {
                    $(this).remove();
                })
            }
        }
    </script>





    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
