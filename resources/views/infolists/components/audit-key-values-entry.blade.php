<table class="fi-in-key-value">
    <thead>
        <tr>
            <th scope="col">
                Mező                    </th>

            <th scope="col">
                Érték                    </th>
        </tr>
    </thead>

    <tbody>
        @foreach($getState() ?? [] as $key => $value)
            <tr>
                <td>{{ $key }}</td>
                <td>{{ $value }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
