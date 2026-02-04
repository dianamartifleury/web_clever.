<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre Completo</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>País</th>
            <th>Ciudad</th>
            <th>Empresa</th>
            <th>Intereses</th>
            <th>Notas</th>
            <th>Fecha Cliente</th>
            <th>Meta Fecha</th>
            <th>IP</th>
            <th>Navegador</th>
            <th>Idioma</th>
            <th>Fuente</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
        <tr>
            <td>{{ $customer->id }}</td>
            <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ $customer->phone ?: 'N/A' }}</td>
            <td>{{ $customer->country ?: 'N/A' }}</td>
            <td>{{ $customer->city ?: 'N/A' }}</td>
            <td>{{ $customer->company ?: 'N/A' }}</td>
            <td>{{ $customer->categories->pluck('name')->implode(', ') ?: 'N/A' }}</td>
            <td>{{ $customer->notes ?: 'Sin notas' }}</td>
            <td>{{ $customer->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ optional($customer->metadata?->registration_date)->format('d/m/Y H:i') ?? 'N/A' }}</td>

            {{-- Geolocation: convertir a string simple --}}
            <td>
                @if(is_array($customer->metadata?->geolocation))
                    IP: {{ $customer->metadata['geolocation']['ip'] ?? 'N/A' }},
                    Lat: {{ $customer->metadata['geolocation']['lat'] ?? 'N/A' }},
                    Lon: {{ $customer->metadata['geolocation']['lon'] ?? 'N/A' }},
                    Precisión: {{ $customer->metadata['geolocation']['accuracy'] ?? 'N/A' }}
                @else
                    {{ $customer->metadata?->geolocation ?? 'N/A' }}
                @endif
            </td>

            {{-- Digital Trace: convertir a string resumido --}}
            <td>
                @if(is_array($customer->metadata?->digital_trace))
                    @foreach($customer->metadata['digital_trace'] as $trace)
                        [{{ ucfirst($trace['type'] ?? '-') }}] {{ $trace['text'] ?? '-' }};
                    @endforeach
                @else
                    {{ $customer->metadata?->digital_trace ?? 'N/A' }}
                @endif
            </td>

            <td>{{ $customer->metadata?->browser_language ?? 'N/A' }}</td>
            <td>{{ $customer->metadata?->language ?? 'N/A' }}</td>
            <td>{{ $customer->metadata?->source ?? 'N/A' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
