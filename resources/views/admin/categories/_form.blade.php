
<section class="row">

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

    <section class="col-12 col-md-6">
        <div class="form-group">
            <label for="">{{ $attributesName['en_title'] }}</label>
            <input type="text" name="en_title" class="form-control form-control-sm"
                   value="{{ old('en_title', $model->en_title) }}">
        </div>
        @error('en_title')
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
                   value="{{ old('seo_title', $model->seo_title) }}">
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
                   value="{{ old('seo_description', $model->seo_description) }}">
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
            <label for="">{{ $attributesName['content_title'] }}</label>
            <input type="text" name="content_title" class="form-control form-control-sm"
                   value="{{ old('content_title', $model->content_title) }}">
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
            <label for="">{{ $attributesName['parent_id'] }}</label>
            <select name="parent_id" id="parent_id" class=" form-control form-control-sm">
                <option value="">{{ $attributesName['DropdownLabel'] }}</option>
                @include('components.load-productcategories-dropdown', ['categories' => $categories,'model'=>$model])
            </select>
        </div>
        @error('parent_id')
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
                @foreach ($statusList as $index => $item)
                    <option value="{{ $index }}"
                            @if ($index ==  $model->status )
                                selected
                        @endif
                    >
                        {{ $item }}</option>
                @endforeach

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
</section>
