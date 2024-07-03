<?php

use App\Models\Main;

$statusList = Main::userStatus();
$attributesName = Main::attributesName();
$perUrl=url()->route('admin.payments.index');
$pageName=$attributesName['show']." ". $attributesName['payment'] ." شماره سفارش '". $model->order_id."'";
?>
@extends('admin.layouts.master')

@section('head-tag')
    <title>
        {{ $pageName }}
    </title>
@endsection



@section('breadCrumbs')

    <li class="breadcrumb-item font-size-12"><a
            href="{{ $perUrl  }}"> {{ $attributesName['manage'] ." ". $attributesName['payments']  }}</a>
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
                    <section class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tr>
                                <td><b>  {{ $attributesName['order_id'] }} </b></td>
                                <td> {{ $model->order_id }}</td>
                            </tr>
                            <tr>
                                <td><b>  {{ $attributesName['amount'] }} </b></td>
                                <td> {{ $model->amount }}</td>
                            </tr>
                            <tr>
                                <td><b>  {{ $attributesName['payment_date'] }} </b></td>
                                <td> {{      \Morilog\Jalali\Jalalian::forge($model->payment_date)->format('%Y-%m-%d')   }}</td>
                            </tr>
                            <tr>
                                <td><b>  {{ $attributesName['reference_id'] }} </b></td>
                                <td> {{ $model->reference_id }}</td>
                            </tr>
                            <tr>
                                <td><b>  {{ $attributesName['reference_number'] }} </b></td>
                                <td> {{ $model->reference_number }}</td>
                            </tr>
                            <tr>
                                <td><b>  {{ $attributesName['trace_number'] }} </b></td>
                                <td> {{ $model->trace_number }}</td>
                            </tr>
                        </table>
                    </section>
                </section>

            </section>
        </section>
    </section>
@endsection
