@php
$deliveryList=\App\Models\Delivery::deliveryList();
  $addressesList=\App\Models\Address::addressesList($model->user_id);


 @endphp
<section class="row">
    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['user_id'] }}</label>

            <select id="user_id" class="form-control"  name="user_id">
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
            <label for="">{{ $attributesName['address_id'] }}</label>
            <select id="address_id" name="address_id" class="form-control">
                <option value="">{{ $attributesName['DropdownLabel'] }} </option>

                @if($model->user_id)

                @include('components.load-types-dropdown', ['typeList' => $addressesList,'model'=>$model,'column'=>'address_id'])
                @endif




            </select>


        </div>
        @error('address_id')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['delivery_id'] . $model->delivery_id }}</label>
            <select class="form-control form-control-sm" name="delivery_id">
                <option value="">{{ $attributesName['DropdownLabel'] }} </option>
            @include('components.load-types-dropdown', ['typeList' => $deliveryList,'model'=>$model,'column'=>'delivery_id'])
            </select>
        </div>
        @error('delivery_id')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['email'] }}</label>
            <input type="text" name="email" class="form-control form-control-sm"
                   value="{{ old('email',$model->email) }}">
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
            <label for="">{{ $attributesName['mobile'] }}</label>
            <input type="text" name="mobile" class="form-control form-control-sm"
                   value="{{ old('mobile',$model->mobile) }}">
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
                   value="{{ old('phone',$model->phone) }}">
        </div>
        @error('phone')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-12">
        <div class="form-group">
            <label for="">{{ $attributesName['orders_description'] }}</label>
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

        $('#user_id').change(function(){
            var user_id = $(this).val();


            if(user_id){
                $.ajax({
                    url: '/admin/address/' + user_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data){
                        $('#address_id').empty();
                        $('#address_id').append('<option value="">--انتخاب کنید--</option>');
                        $.each(data, function(key, value){
                            $('#address_id').append('<option value="'+value.id+'">'+value.title+'</option>');
                        });
                    }
                });
            }
        });
    </script>

@endsection
