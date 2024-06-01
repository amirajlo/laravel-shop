@if ($category->children->count())
    <tr class="child">
        <td colspan="3">
            @foreach ($category->children as $child)
                <span style="padding-left: 20px;">{{ $child->title }}</span>

            @endforeach
        </td>
    </tr>
@endif
