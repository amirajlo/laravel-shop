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

$displayfromto="none";
if(($model->price_currency_special) > 0 || ($model->price_special) > 0){
  $displayfromto="block";
}
$displayrial="block";
$displaydollar="none";

if($model->price_type == Product::PRICE_TYPE_DOLLAR){
$displayrial="none";
$displaydollar="block";
}
$managestock_active="block";
$managestock_deactive="none";
 if($model->manage_stock == Product::MANAGE_STOCK_DISABLE){
$managestock_active="none";
$managestock_deactive="block";
}
@endphp
@section('head-tag')
    <link rel="stylesheet" href="{{ asset('admin-assets/datepicker_majid/jalalidatepicker.min.css') }}">
@endsection
<section class="row">
    <section class="col-12 col-md-8">
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
            <section class="col-12">
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
            <section class="col-12">
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
            <section class="col-12">
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
<hr/>
        <section class="row">
            <section class="col-12">
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

            <section class="col-12">
                <div class="form-group">
                    <label for="">{{ $attributesName['price_type'] }} </label>
                    <select class="form-control form-control-sm" name="price_type" id="price_type">

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
        </section>

        <section class="row" id="pricetype_{{Product::PRICE_TYPE_ORDINARY}}" style="display: {{$displayrial}}">
                <section class="col-12">
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
                <section class="col-12">
                    <div class="form-group">
                        <label for="">{{ $attributesName['price_special'] }}</label>
                        <input type="text" name="price_special" class="form-control form-control-sm" oninput="showDatepicker()"  id="price_special"
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
            </section>


        <section class="row" id="pricetype_{{Product::PRICE_TYPE_DOLLAR}}" style="display: {{$displaydollar}}">
            <section class="col-12">
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
            <section class="col-12">
                <div class="form-group">
                    <label for="">{{ $attributesName['price_currency_special'] }}</label>
                    <input type="text" name="price_currency_special" class="form-control form-control-sm" oninput="showDatepicker()"  id="price_currency_special"
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
            </section>
        <section class="row"  id="fromto" style="display: {{$displayfromto}}">
            <section class="col-12">
                <div class="form-group">


                    <label for="">{{ $attributesName['price_special_from'] }}</label>
                    <input type="hidden" name="price_special_from" id="price_special_from"
                           value="{{old('price_special_from',$model->price_special_from)}}"
                           class="form-control form-control-sm">
                    <input type="text" data-jdp data-jdp-miladi-input="price_special_from"
                           value=" {{old('price_special_from_view',$oldPriceSpecialFrom)}} " autocomplete="off"
                           id="price_special_from_view"
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
            <section class="col-12">
                <div class="form-group">

                    <label for="">{{ $attributesName['price_special_to'] }}</label>
                    <input type="hidden" name="price_special_to" id="price_special_to"
                           value="{{old('price_special_to',$model->price_special_to)}}"
                           class="form-control form-control-sm">
                    <input type="text" data-jdp data-jdp-miladi-input="price_special_to"
                           value=" {{old('price_special_to_view',$oldPriceSpecialTo)}}" autocomplete="off"
                           id="price_special_to_view"
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
        </section>

        <hr/>
        <section class="row">



            <section class="col-12 col-md-12">
                <div class="form-group">
                    <label for="">{{ $attributesName['manage_stock'] }}</label>
                    <select class="form-control form-control-sm" name="manage_stock" id="manage_stock">

                        @include('components.load-types-dropdown', ['typeList' => $manageStockList,'model'=>$model,'column'=>'manage_stock'])
                    </select>

                </div>
                @error('manage_stock')
                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                @enderror
            </section>
            </section>
            <section class="row" id="managestock_{{Product::MANAGE_STOCK_ACTIVE}}" style="display: {{$managestock_active}}">
            <section class="col-12">
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
            <section class="col-12 ">
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
        <section class="row" id="managestock_{{Product::MANAGE_STOCK_DISABLE}}" style="display: {{$managestock_deactive}}">
            <section class="col-12">
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
        </section>

    </section>
    <section class="col-12 col-md-4">
        <section class="row">
            <section class="col-12">
                <div class="form-group">
                    <label for="">{{ $attributesName['category_id'] }}</label>
                    <select name="categories[]" id="categories" class="select2 form-control form-control-sm" multiple>

                        @include('components.load-productcategories-dropdown', ['categories' => $categories,'model'=>$model])
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
            <section class="col-12">
                <div class="form-group">
                    <label for="tags">تگ ها</label>


                    <select class="select2 form-control form-control-sm" name="tags[]" id="tags"
                            multiple>
                        @include('components.load-producttags-dropdown', ['categories' => $tags,'model'=>$model])

                    </select>
                </div>
                @error('tags')
                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                @enderror
            </section>
            <section class="col-12">
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
            <section class="col-12">
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
            <section class="col-12">
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
            <section class="col-12">
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
            <section class="col-12">
                <div class="form-group">
                    <label for="">{{ $attributesName['sidebar'] }}</label>
                    <textarea type="text" id="modelsidebar" name="sidebar" style="height: 169px;"
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
        </section>
    </section>
</section>







@section('script')
    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('admin-assets/datepicker_majid/jalalidatepicker.min.js') }}"></script>
    <script src="{{ asset('admin-assets/datepicker_majid/functions.js') }}"></script>
    <script>
        CKEDITOR.replace('description', {
            filebrowserUploadUrl: "{{route('main.upload', ['_token' => csrf_token() ])}}",
            filebrowserImageUploadUrl: "{{route('main.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.config.language = 'fa';
    </script>

    <script>
        CKEDITOR.replace('modelsidebar', {
            filebrowserUploadUrl: "{{route('main.upload', ['_token' => csrf_token() ])}}",
            filebrowserImageUploadUrl: "{{route('main.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.config.language = 'fa';
    </script>
    <script type="text/javascript">
        $('#categories').select2({
            placeholder: 'انتخاب کنید...',
            multiple: true,
            allowClear: true
        });
        $("#tags").select2({
            placeholder: 'لطفا تگ های خود را وارد نمایید',
            dir: "rtl",
            tags: true
        });
    </script>

    <script>
        document.getElementById("price_type").addEventListener("change", changePriceType);
        document.getElementById("manage_stock").addEventListener("change", changeStock);
        function showDatepicker() {

            document.getElementById("fromto").style.display = "block";
        }

        function changeStock() {
            var y = document.getElementById("manage_stock");

            if(y.value == {{Product::MANAGE_STOCK_ACTIVE}}){
                document.getElementById("managestock_{{Product::MANAGE_STOCK_ACTIVE}}").style.display = "block";
                document.getElementById("managestock_{{Product::MANAGE_STOCK_DISABLE}}").style.display = "none";
            }
            else{
                document.getElementById("managestock_{{Product::MANAGE_STOCK_ACTIVE}}").style.display = "none";
                document.getElementById("managestock_{{Product::MANAGE_STOCK_DISABLE}}").style.display = "block";
            }

        }
        function changePriceType() {
            var x = document.getElementById("price_type");
            if(x.value == {{Product::PRICE_TYPE_ORDINARY}}){
                document.getElementById("pricetype_{{Product::PRICE_TYPE_DOLLAR}}").style.display = "none";
                document.getElementById("pricetype_{{Product::PRICE_TYPE_ORDINARY}}").style.display = "block";
            }
            else{
                document.getElementById("pricetype_{{Product::PRICE_TYPE_DOLLAR}}").style.display = "block";
                document.getElementById("pricetype_{{Product::PRICE_TYPE_ORDINARY}}").style.display = "none";
            }

        }
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

