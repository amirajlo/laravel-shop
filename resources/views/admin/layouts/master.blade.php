<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layouts.head-tag')

    @yield('head-tag')

  <title>@yield('title-tag')</title>
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

    <script type="text/javascript">
        function deleteFile(url) {
            var csrf = "{{ csrf_token() }}";

            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    _token: csrf
                },
                success: function (response) {

                    if (response.status) {
                        document.getElementById(response.id).innerHTML = "";
                        successToast(response.message)

                    } else {

                        errorToast(response
                            .message)
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
</body>

</html>
