
    @foreach ($typeList as $index => $item)
        <option value="{{ $index }}"
                @if ($index ==  old($column,$model->$column) )
                    selected
            @endif
        >
            {{ $item }}</option>
    @endforeach

