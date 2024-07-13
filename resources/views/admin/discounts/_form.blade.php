@php
    $oldExpired="";
if(!empty($model->expired_at)){
    $dateTimeInput = explode(' ', $model->expired_at);
    $date = explode('-', $dateTimeInput[0]);
    $datePart0 = Morilog\Jalali\CalendarUtils::toJalali($date[0], $date[1], $date[2]);
    $datePart0 = implode('/', $datePart0);
    $oldExpired = $datePart0;
}

@endphp
<section class="row">

    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['title'] }}</label>
            <input type="text" name="title" class="form-control form-control-sm"
                   value="{{ old('title',$model->title) }}">
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
            <label for="">{{ $attributesName['discount_code'] }}</label>
            <input type="text" name="discount_code" class="form-control form-control-sm"
                   value="{{ old('discount_code',$model->discount_code) }}">
        </div>
        @error('discount_code')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-12">
        <div class="form-group">
            <label for="">{{ $attributesName['product_id'] }}</label>

            <select id="product_id" class="form-control form-control-sm" style="width:500px;" name="product_id">
                @if($model->product_id)
                    <option value="{{$model->product->id}}"
                            data-select2-id="select2-data-28-j3ms">{{$model->product->title}}</option>
                @endif
            </select>

        </div>
        @error('product_id')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>

    <section class="col-12 col-md-12">
        <div class="form-group">
            <label for="">{{ $attributesName['discount_description'] }}</label>
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

    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['type'] }}</label>
            <input type="text" name="type" class="form-control form-control-sm"
                   value="{{ old('type',$model->type) }}">
        </div>
        @error('type')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['qty'] }}</label>
            <input type="text" name="qty" class="form-control form-control-sm"
                   value="{{ old('qty',$model->qty) }}">
        </div>
        @error('qty')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>

    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['discount_fee'] }}</label>
            <input type="text" name="fee" class="form-control form-control-sm"
                   value="{{ old('fee',$model->fee) }}">
        </div>
        @error('fee')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['percent'] }}</label>
            <input type="text" name="percent" class="form-control form-control-sm"
                   value="{{ old('percent',$model->percent) }}">
        </div>
        @error('percent')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>


    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['min_order'] }}</label>
            <input type="text" name="min_order" class="form-control form-control-sm"
                   value="{{ old('min_order',$model->min_order) }}">
        </div>
        @error('min_order')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['min_qty'] }}</label>
            <input type="text" name="min_qty" class="form-control form-control-sm"
                   value="{{ old('min_qty',$model->min_qty) }}">
        </div>
        @error('min_qty')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>

    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['discount_max'] }}</label>
            <input type="text" name="max" class="form-control form-control-sm"
                   value="{{ old('max',$model->max) }}">
        </div>
        @error('max')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['expired_at'] }}</label>
            <input type="hidden" name="expired_at" id="expired_at" value="{{old('expired_at',$model->expired_at)}}"
                   class="form-control form-control-sm">
            <input type="text" data-jdp data-jdp-miladi-input="expired_at" {{old('expired_at_view',$oldExpired)}} autocomplete="off"
                   id="expired_at_view" class="form-control form-control-sm">


        </div>
        @error('expired_at')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>

</section>

@section('head-tag')
    <link rel="stylesheet" href="{{ asset('admin-assets/datepicker_majid/jalalidatepicker.min.css') }}">
@endsection
@section('script')

    <script src="{{ asset('admin-assets/datepicker_majid/jalalidatepicker.min.js') }}"></script>
    <script src="{{ asset('admin-assets/datepicker_majid/functions.js') }}"></script>


    <script>
        $(document).ready(function () {

            jalaliDatepicker.startWatch({
                time: false,

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


        });
    </script>
    <script type="text/javascript">
        $('#product_id').select2({
            placeholder: 'عنوان را وارد کنید',
            ajax: {
                url: '/admin/ajax',
                dataType: 'json',

                data: function (params) {
                    var query = {
                        q: params.term,
                        table: 'products'

                    }


                    return query;
                }  ,
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.title,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
    </script>

@endsection
