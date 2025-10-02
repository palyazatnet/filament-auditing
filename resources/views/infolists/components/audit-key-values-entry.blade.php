<table class="fi-in-key-value">
    <thead>
        <tr>
            <th scope="col">
                {{ trans('filament-auditing::filament-auditing.infolist.key_label') }}
            </th>

            <th scope="col">
                {{ trans('filament-auditing::filament-auditing.infolist.value_label') }}
            </th>
        </tr>
    </thead>

    <tbody>
        @foreach($getState() ?? [] as $key => $value)
            <tr>
                @if(method_exists($getRecord()->auditable, 'translateAuditField'))
                    <td>{{ $getRecord()->auditable->translateAuditField($key, 'old') }}</td>
                @else
                    <td>{{ $key }}</td>
                @endif
                @if(method_exists($getRecord()->auditable, 'formatFieldForPresentation'))
                    <td>{{ $getRecord()->auditable->formatFieldForPresentation($key, $value) }}</td>
                @else
                    <td>{{ $value }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
