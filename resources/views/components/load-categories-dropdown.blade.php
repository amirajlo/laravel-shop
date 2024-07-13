@foreach ($categories as $category)
    <option value="{{ $category->id }}"
            @if ($category->id ==  old('categories',$model->categories) )
                selected
        @endif
    >{{ $category->title }}</option>
    @if ($category->children->count())
        @foreach ($category->children as $child)
            <option value="{{ $child->id }}"
                    @if ($child->id ==  old('categories',$model->categories) )
                        selected
                @endif
            >- {{ $child->title }}</option>
        @endforeach
    @endif
@endforeach
