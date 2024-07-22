<section class="row">
    <section class="col-12 col-md-12">
        <input type="hidden" name="user_id" class="form-control form-control-sm"
               value="{{ old('user_id',$model->user_id) }}">
        <input type="hidden" name="order_id" class="form-control form-control-sm"
               value="{{ old('order_id',$order_id) }}">
    </section>
    <section class="col-12 col-md-12">
        <div class="form-group">
            <label for="">{{ $attributesName['product_id'] }}</label>

            <select
                @if($model->product_id)
                    disabled
                @endif
                id="product_id" class="form-control form-control-sm" style="width:500px;" name="product_id">
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

    <section class="col-12 col-md-12">
        <div class="form-group">
            <label for="">{{ $attributesName['orderitems_description'] }}</label>
            <textarea type="text" name="description" style="height: 169px;"
                      class="form-control form-control-sm">{{ old('description') }}</textarea>
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
@section('script')

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
