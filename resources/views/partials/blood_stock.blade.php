<table class="stock-table">
    <thead>
    <tr>
        <th>Blood Type</th>
        <th>Units Available</th>
    </tr>
    </thead>
    <tbody>
    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
        @php
            $quantity = $bloodBank->$type ?? 0;
            $textClass = $quantity == 0 ? 'text-danger' : ($quantity < 5 ? 'text-warning' : 'text-success');
        @endphp
        <tr>
            <td class="blood-type {{ $textClass }}">{{ $type }}</td>
            <td class="{{ $textClass }}">{{ $quantity }} units</td>
        </tr>
    @endforeach
    </tbody>
</table>
