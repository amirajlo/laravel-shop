@foreach ($categories as $id => $title)
    <option value="{{ $id }}"
            @if (!empty($model->categories) &&  in_array($id,$model->categories) )
                selected
        @endif
    >{{ $title }} </option>
@endforeach