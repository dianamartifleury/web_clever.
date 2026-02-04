<x-app-layout>
    {{-- Header de la Página --}}
    <x-slot name="header">
        <h1 class="section-title">
            {{ __('Listado de Clientes') }}
        </h1>
    </x-slot>

    <!-- Boton de Volver Atras -->
    <div class="header-box">
        <div class="button-container right">
            <a href="{{ route('dashboard') }}" class="btn">
                &larr; Volver al Dashboard
            </a>
        </div>
    </div>

    {{-- Tabla de Clientes --}}
    <div class="table-wrapper">
        <table class="results-table">
            {{-- Encabezados --}}
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
                    <th>Fecha Registro</th>
                </tr>
            </thead>

            {{-- Cuerpo --}}
            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td class="text-main">{{ $customer->id }}</td>

                        <td>
                            {{ $customer->first_name }} {{ $customer->last_name }}
                        </td>

                        <td>{{ $customer->email }}</td>

                        <td>{{ $customer->phone }}</td>

                        <td>{{ $customer->country ?: 'N/A' }}</td>

                        <td>{{ $customer->city ?: 'N/A' }}</td>

                        <td>{{ $customer->company ?: 'N/A' }}</td>

                        <td class="text-wrap">
                            @if($customer->categories->isNotEmpty())
                                {{ $customer->categories->pluck('name')->implode(', ') }}
                            @else
                                N/A
                            @endif
                        </td>

                        <td class="text-wrap">
                            {{ $customer->notes ?: 'Sin notas' }}
                        </td>

                        <td>{{ $customer->created_at?->format('d/m/Y H:i') }}</td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="10" class="empty-cell">
                            No hay clientes registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-app-layout>
