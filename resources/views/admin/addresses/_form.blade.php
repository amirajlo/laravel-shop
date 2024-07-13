
<section class="row">
    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['user_id'] }}</label>
            <select id="user_id" class="form-control "  name="user_id">
                @if($model->user_id)
                    <option value="{{$model->user->id}}"
                            data-select2-id="select2-data-28-j3ms">{{$model->user->first_name." ".$model->user->last_name . " - ".$model->user->username}}</option>
                @endif
            </select>
        </div>
        @error('user_id')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
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
    <section class="col-12 col-md-12">
        <div class="form-group">
            <label for="">{{ $attributesName['province_id'] }}</label>
            <input type="text" name="province_id" class="form-control form-control-sm"
                   value="{{ old('province_id', $model->province_id) }}">
        </div>
        @error('province_id')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-12">
        <div class="form-group">
            <label for="">{{ $attributesName['city_id'] }}</label>
            <input type="text" name="city_id" class="form-control form-control-sm"
                   value="{{ old('city_id', $model->city_id) }}">
        </div>
        @error('city_id')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-12">
        <div class="form-group">
            <label for="">{{ $attributesName['town_id'] }}</label>
            <input type="text" name="town_id" class="form-control form-control-sm"
                   value="{{ old('town_id', $model->town_id) }}">
        </div>
        @error('town_id')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-12">
        <div class="form-group">
            <label for="">{{ $attributesName['address_description'] }}</label>
            <textarea type="text" name="description" style="height: 169px;"
                      class="form-control form-control-sm">{{ old('description', $model->description) }}</textarea>
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
            <label for="">{{ $attributesName['mobile'] }}</label>
            <input type="text" name="mobile" class="form-control form-control-sm"
                   value="{{ old('mobile', $model->mobile) }}">
        </div>
        @error('mobile')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['phone'] }}</label>
            <input type="text" name="phone" class="form-control form-control-sm"
                   value="{{ old('phone', $model->phone) }}">
        </div>
        @error('phone')
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
            <label for="">{{ $attributesName['email'] }}</label>
            <input type="text" name="email" class="form-control form-control-sm"
                   value="{{ old('email', $model->email) }}">
        </div>
        @error('email')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['postal_code'] }}</label>
            <input type="text" name="postal_code" class="form-control form-control-sm"
                   value="{{ old('postal_code', $model->postal_code) }}">
        </div>
        @error('postal_code')
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
            <label for="">{{ $attributesName['latitude'] }}</label>
            <input type="text" name="latitude" class="form-control form-control-sm"
                   value="{{ old('latitude', $model->latitude) }}">
        </div>
        @error('latitude')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['longitude'] }}</label>
            <input type="text" name="longitude" class="form-control form-control-sm"
                   value="{{ old('longitude', $model->longitude) }}">
        </div>
        @error('longitude')
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
        $('#user_id').select2({
            placeholder: 'عنوان را وارد کنید',
            ajax: {
                url: '/admin/ajax',
                dataType: 'json',

                data: function (params) {
                    var query = {
                        q: params.term,
                        table: 'users'

                    }

                    return query;
                },
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.first_name + " " + item.last_name + " - " + item.username ,
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
