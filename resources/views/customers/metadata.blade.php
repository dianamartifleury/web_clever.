<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-center">
            {{ __('Metadatos de Clientes') }}
        </h2>
    </x-slot>

    <div class="page-wrapper">
        <div class="page-container">

            <!-- Botón para volver al Dashboard -->
            <div class="button-container right">
                <a href="{{ route('dashboard') }}" class="btn">
                    &larr; Volver al Dashboard
                </a>
            </div>

            <div class="content-box">

                <h3 class="text-xl font-semibold mb-4">Registros de Metadatos</h3>

                <div class="table-wrapper">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th>ID Meta</th>
                                <th>Cliente (Email)</th>
                                <th>Fecha Registro</th>
                                <th>Geolocalización</th>
                                <th>Digital Trace</th>
                                <th>Idioma</th>
                                <th>Fuente</th>
                                <th>Bot Score</th>
                                <th>¿Es Bot?</th>
                            </tr>
                        </thead>

                        <tbody>

                        @forelse ($metadataItems as $item)

                            {{-- Ocultar registros sin cliente asociado --}}
                            @if (!optional($item->customer)->email)
                                @continue
                            @endif

                            <tr>
                                <td>{{ $item->id }}</td>

                                <td>{{ $item->customer->email }}</td>

                                <td>{{ $item->registration_date?->format('d/m/Y H:i:s') ?? 'N/A' }}</td>

                                <!-- GEOLOCALIZACIÓN (SIN CAMBIOS) -->
                                <td>
                                    @if ($item->consent_given && is_array($item->geolocation))

                                        <strong>IP:</strong> {{ $item->geolocation['ip'] ?? 'N/A' }}<br>

                                        @if(isset($item->geolocation['lat'], $item->geolocation['lon']))
                                            <small>
                                                Lat: {{ $item->geolocation['lat'] }},
                                                Lon: {{ $item->geolocation['lon'] }}
                                            </small><br>
                                        @endif

                                        @if(isset($item->geolocation['accuracy']))
                                            <small>Precisión: {{ $item->geolocation['accuracy'] }} m</small>
                                        @endif

                                    @else
                                        <span class="text-gray-400 italic">N/A</span>
                                    @endif
                                </td>

                                <!-- ===============================
                                     DIGITAL TRACE (DESPLEGABLE)
                                     =============================== -->
                                <td class="px-6 py-4 text-sm max-w-xs">

                                    @if ($item->consent_given && is_array($item->digital_trace))

                                        <details>
                                            <summary class="cursor-pointer text-indigo-600 hover:underline">
                                                Mostrar
                                            </summary>

                                            <div class="mt-2 whitespace-pre-wrap">

                                                @foreach ($item->digital_trace as $traceIndex => $trace)

                                                    @php
                                                        $type = $trace['type'] ?? '';
                                                        $text = $trace['text'] ?? '';
                                                        $timestamp = $trace['timestamp'] ?? '';
                                                        $hrefFull = $trace['href'] ?? '';
                                                        $parsed = parse_url($hrefFull);
                                                        $pathOnly = $parsed['path'] ?? '';

                                                        $isInitialHomeRoute =
                                                            $traceIndex === 0 &&
                                                            $type === 'route' &&
                                                            ($pathOnly === '/' || $pathOnly === '');
                                                    @endphp

                                                    @if ($isInitialHomeRoute)
                                                        @continue
                                                    @endif

                                                    @if ($type === 'route')
                                                        🧭 <strong>Ruta:</strong> {{ $text }}<br>
                                                    @endif

                                                    @if ($type === 'click')
                                                        🖱️ <strong>Click:</strong> {{ $text }}
                                                        @if ($hrefFull)
                                                            (<a href="{{ $hrefFull }}" target="_blank"
                                                                class="text-indigo-500 underline">link</a>)
                                                        @endif
                                                        <br>
                                                    @endif

                                                    <small class="text-gray-400">{{ $timestamp }}</small><br><br>

                                                @endforeach

                                            </div>
                                        </details>

                                    @else
                                        <span class="text-gray-400 italic">N/A</span>
                                    @endif
                                </td>

                                <!-- IDIOMA -->
                                <td>{{ $item->browser_language ?? 'N/A' }}</td>

                                <!-- FUENTE -->
                                <td>{{ $item->source ?? 'N/A' }}</td>

                                <!-- BOT SCORE -->
                                <td>
                                    <span class="
                                        @if($item->bot_score >= 50)
                                            text-red-500 font-bold
                                        @elseif($item->bot_score >= 30)
                                            text-yellow-400 font-bold
                                        @else
                                            text-green-500
                                        @endif
                                    ">
                                        {{ $item->bot_score }}
                                    </span>
                                </td>

                                <!-- ¿ES BOT? -->
                                <td>
                                    <span class="{{ $item->suspected_bot ? 'text-red-500 font-bold' : 'text-green-500' }}">
                                        {{ $item->suspected_bot ? 'SÍ' : 'No' }}
                                    </span>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-400">
                                    No hay registros de metadatos.
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
