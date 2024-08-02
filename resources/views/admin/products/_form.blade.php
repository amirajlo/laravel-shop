@php
    use App\Models\Main;
    use App\Models\Product;
    $priceTypeList=Product::priceTypeList();
    $manageStockList=Product::manageStockList();
    $stockStatusList=Product::stockStatusList();

    $oldPriceSpecialTo="";
if(!empty($model->price_special_to)){
    $dateTimeInput = explode(' ', $model->price_special_to);
    $date = explode('-', $dateTimeInput[0]);
    $datePart0 = Morilog\Jalali\CalendarUtils::toJalali($date[0], $date[1], $date[2]);
    $datePart0 = implode('/', $datePart0);
    $oldPriceSpecialTo = $datePart0 ;

}

    $oldPriceSpecialFrom="";
if(!empty($model->price_special_from)){
    $dateTimeInput = explode(' ', $model->price_special_from);
    $date = explode('-', $dateTimeInput[0]);
    $datePart0 = Morilog\Jalali\CalendarUtils::toJalali($date[0], $date[1], $date[2]);
    $datePart0 = implode('/', $datePart0);
    $oldPriceSpecialFrom = $datePart0 ;

}
@endphp
@section('head-tag')
    <link rel="stylesheet" href="{{ asset('admin-assets/datepicker_majid/jalalidatepicker.min.css') }}">
@endsection
<section class="row">

    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['category_id'] }}</label>
            <select name="categories" id="categories" class="form-control form-control-sm">
                <option value="">{{ $attributesName['DropdownLabel'] }}</option>
                @include('components.load-categories-dropdown', ['categories' => $categories,'model'=>$model])
            </select>
        </div>
        @error('categories')
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
            <label for="">{{ $attributesName['sub_title'] }}</label>
            <input type="text" name="sub_title" class="form-control form-control-sm"
                   value="{{ old('sub_title',$model->sub_title) }}">
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
                   value="{{ old('seo_title',$model->seo_title) }}">
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
                   value="{{ old('seo_description',$model->seo_description) }}">
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
            <label for="">{{ $attributesName['content_title'] }}</label>
            <input type="text" name="content_title" class="form-control form-control-sm"
                   value="{{ old('content_title',$model->content_title) }}">
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
                @include('components.load-types-dropdown', ['typeList' => $statusList,'model'=>$model,'column'=>'status'])

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
    <section class="col-12 col-md-12">
        <div class="form-group">
            <label for="is_commentable">{{ $attributesName['show_price'] }} </label>
            <input type="checkbox" name="show_price" id="show_price"

                   @if($model->show_price == 1)
                       checked
                   @endif
                   class="form-check-input">
        </div>
        @error('show_price')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-12">
        <div class="form-group">
            <label for="">{{ $attributesName['price_type'] }} </label>
            <select class="form-control form-control-sm" name="price_type">
                <option value="">{{ $attributesName['DropdownLabel'] }} </option>
                @include('components.load-types-dropdown', ['typeList' => $priceTypeList,'model'=>$model,'column'=>'price_type'])
            </select>

        </div>
        @error('price_type')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>

    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['price'] }}</label>
            <input type="text" name="price" class="form-control form-control-sm"
                   value="{{ old('price',$model->price) }}">
        </div>
        @error('price')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['price_special'] }}</label>
            <input type="text" name="price_special" class="form-control form-control-sm"
                   value="{{ old('price_special',$model->price_special) }}">
        </div>
        @error('price_special')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>


    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['price_currency'] }}</label>
            <input type="text" name="price_currency" class="form-control form-control-sm"
                   value="{{ old('price_currency',$model->price_currency) }}">
        </div>
        @error('price_currency')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['price_currency_special'] }}</label>
            <input type="text" name="price_currency_special" class="form-control form-control-sm"
                   value="{{ old('price_currency_special',$model->price_currency_special) }}">
        </div>
        @error('price_currency_special')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>


    <section class="col-12 col-md-6">
        <div class="form-group">


            <label for="">{{ $attributesName['price_special_from'] }}</label>
            <input type="hidden" name="price_special_from" id="price_special_from"
                   value="{{old('price_special_from',$model->price_special_from)}}"
                   class="form-control form-control-sm">
            <input type="text" data-jdp data-jdp-miladi-input="price_special_from"
                value=" {{old('price_special_from_view',$oldPriceSpecialFrom)}} "  autocomplete="off" id="price_special_from_view"
                   class="form-control form-control-sm">

        </div>
        @error('price_special_from')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-6">
        <div class="form-group">

            <label for="">{{ $attributesName['price_special_to'] }}</label>
            <input type="hidden" name="price_special_to" id="price_special_to"
                   value="{{old('price_special_to',$model->price_special_to)}}"
                   class="form-control form-control-sm">
            <input type="text" data-jdp data-jdp-miladi-input="price_special_to"
                   value=" {{old('price_special_to_view',$oldPriceSpecialTo)}}" autocomplete="off" id="price_special_to_view"
                   class="form-control form-control-sm">

        </div>
        @error('price_special_to')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>


    <section class="col-12 col-md-12">
        <div class="form-group">
            <label for="">{{ $attributesName['manage_stock'] }}</label>
            <select class="form-control form-control-sm" name="manage_stock">
                <option value="">{{ $attributesName['DropdownLabel'] }} </option>
                @include('components.load-types-dropdown', ['typeList' => $manageStockList,'model'=>$model,'column'=>'manage_stock'])
            </select>

        </div>
        @error('price_type')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>

    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['stock_status'] }}</label>
            <select class="form-control form-control-sm" name="stock_status">
                <option value="">{{ $attributesName['DropdownLabel'] }} </option>
                @include('components.load-types-dropdown', ['typeList' => $stockStatusList,'model'=>$model,'column'=>'stock_status'])
            </select>

        </div>
        @error('stock_status')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>


    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['stock_qty'] }}</label>
            <input type="text" name="stock_qty" class="form-control form-control-sm"
                   value="{{ old('stock_qty',$model->stock_qty) }}">
        </div>
        @error('stock_qty')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>
    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['low_stock'] }}</label>
            <input type="text" name="low_stock" class="form-control form-control-sm"
                   value="{{ old('low_stock',$model->low_stock) }}">
        </div>
        @error('low_stock')
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

    <section class="col-12 col-md-12 ">
        <div class="form-group">
            <label for="gallery_images">Gallery Images:</label>
            <input type="file" name="gallery_images[]" id="gallery_images" class="form-control  "
                   multiple accept="image/*">
        </div>
        @error('gallery_images')
        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
        @enderror
    </section>

</section>


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

@endsection

