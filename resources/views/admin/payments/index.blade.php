<?php

use App\Models\Main;

$attributesName = Main::attributesName();
$pageName = $attributesName['manage'] . " " . $attributesName['payments'];

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
                            <th>{{ $attributesName['order_id'] }}</th>
                            <th>{{ $attributesName['amount'] }}</th>
                            <th>{{ $attributesName['payment_date'] }}</th>
                            <th>{{ $attributesName['reference_id'] }}</th>
                            <th>{{ $attributesName['reference_number'] }}</th>
                            <th>{{ $attributesName['trace_number'] }}</th>



                            <th class="max-width-16-rem text-center"><i
                                    class="fa fa-cogs"></i> {{ $attributesName['setting'] }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($models as $key => $model)

                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $model->order_id }} </td>
                                <td>{{ $model->amount }} </td>
                                <td>
                                    {{  \Morilog\Jalali\Jalalian::forge($model->payment_date)->format('%Y-%m-%d')  }}
                                 </td>
                                 <td>{{ $model->reference_id }} </td>
                                <td>{{ $model->reference_number }} </td>
                                <td>{{ $model->trace_number }} </td>




                                <td class="width-22-rem text-left">




                                    <a href="{{ route('admin.payments.show', $model->id) }}"
                                       class="btn btn-primary btn-sm"><i
                                            class="fa fa-search"></i> {{ $attributesName['show'] }}</a>
                                    <form class="d-inline"
                                          action="{{ route('admin.payments.destroy', $model->id) }}"
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
                        document.getElementById('status-' + id).innerHTML = response.result;
                        successToast(response.message)

                    } else {

                        errorToast(response.message)
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
