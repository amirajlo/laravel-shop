<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layouts.head-tag')
    @yield('head-tag')

</head>

<body dir="rtl">

    @include('admin.layouts.header')



    <section class="body-container">

        @include('admin.layouts.sidebar')


        <section id="main-body" class="main-body">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item font-size-12"><a href="/admin"> {{ \App\Models\Main::attributesName()['home'] }}</a></li>
                    @yield('breadCrumbs')
                </ol>
            </nav>
            @yield('content')

        </section>
    </section>


    @include('admin.layouts.script')
    @yield('script')

    <section class="toast-wrapper flex-row-reverse">
        @include('admin.alerts.toast.success')
        @include('admin.alerts.toast.error')
    </section>

    @include('admin.alerts.sweetalert.error')
    @include('admin.alerts.sweetalert.success')


</body>

</html>
