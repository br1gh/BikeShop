<div class="table-responsive">
    <table class="table tablesorter " id="">
        <thead class=" text-primary">
        <tr>
            @foreach($table->headers as $header)
                <th {{$loop->last ? 'class="text-center"' : '' }}>
                    {{$header}}
                </th>
            @endforeach
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @if (sizeof($items->items()) == 0)
            <tr>
                <td colspan="{{sizeof($table->headers) + 1}}" class="text-center">
                    No records found
                </td>
            </tr>
        @else
            <tr>
                @foreach($items->items() as $item)
                    @foreach($table->fieldNames as $field)
                        <td {{$loop->last ? 'class="text-center"' : '' }}>
                            {{ $item->{$field} }}
                        </td>
                    @endforeach
                    <td class="td-actions text-right">
                        <a href="{{route($table->tableName.'.edit', ['id' => $item->id])}}"
                           class="btn btn-primary btn-sm btn-icon">
                            <i class="tim-icons icon-settings"></i>
                        </a>
                        <a href="{{route($table->tableName.'.delete', ['id' => $item->id])}}"
                           class="btn btn-danger btn-sm btn-icon">
                            <i class="tim-icons icon-simple-remove"></i>
                        </a>
                    </td>
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
