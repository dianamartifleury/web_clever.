<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Consulta Personalizada de Clientes
        </h1>
    </x-slot>

    <div class="page-wrapper">
        <div class="page-container">

            <!-- Boton de Volver Atras -->
            <div class="header-box">
                <div class="button-container right">
                    <a href="{{ route('dashboard') }}" class="btn">
                        &larr; Volver al Dashboard
                    </a>
                </div>
            </div>

            {{-- ===================== BLOQUE 1: FILTROS ===================== --}}
            <div class="content-box filtros-container">
                <form method="GET" action="{{ route('customers.filter') }}" class="filter-form">
                    
                    <div class="form-grid-2col">
                        <!-- Nombre -->
                        <div>
                            <label for="first_name" class="form-label">Nombre</label>
                            <input type="text" id="first_name" name="first_name" value="{{ request('first_name') }}"
                                placeholder="Ej: Juan" class="form-input">
                        </div>

                        <!-- Apellidos -->
                        <div>
                            <label for="last_name" class="form-label">Apellidos</label>
                            <input type="text" id="last_name" name="last_name" value="{{ request('last_name') }}"
                                placeholder="Ej: Pérez" class="form-input">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" value="{{ request('email') }}"
                                placeholder="Ej: juan@ejemplo.com" class="form-input">
                        </div>

                        <!-- Empresa -->
                        <div>
                            <label for="company" class="form-label">Empresa</label>
                            <input type="text" id="company" name="company" value="{{ request('company') }}"
                                placeholder="Ej: Tech Solutions" class="form-input">
                        </div>

                        <!-- País -->
                        <div>
                            <label for="country" class="form-label">País</label>
                            <input type="text" id="country" name="country" value="{{ request('country') }}"
                                placeholder="Ej: España" class="form-input">
                        </div>

                        <!-- Ciudad -->
                        <div>
                            <label for="city" class="form-label">Ciudad</label>
                            <input type="text" id="city" name="city" value="{{ request('city') }}"
                                placeholder="Ej: Madrid" class="form-input">
                        </div>

                        <!-- Fechas -->
                        <div>
                            <label for="customer_date_from" class="form-label">Registrado Desde</label>
                            <input type="date" id="customer_date_from" name="customer_date_from"
                                value="{{ request('customer_date_from') }}" class="form-input">
                        </div>

                        <div>
                            <label for="customer_date_to" class="form-label">Registrado Hasta</label>
                            <input type="date" id="customer_date_to" name="customer_date_to"
                                value="{{ request('customer_date_to') }}" class="form-input">
                        </div>

                        <!-- Fuente -->
                        <div>
                            <label for="source" class="form-label">Fuente</label>
                            <select id="source" name="source" class="form-input">
                                <option value="">-- Todas las fuentes --</option>
                                <option value="Formulario de Contacto Web"
                                    {{ request('source') == 'Formulario de Contacto Web' ? 'selected' : '' }}>
                                    Formulario de Contacto Web
                                </option>
                                <option value="Importacion" {{ request('source') == 'Importacion' ? 'selected' : '' }}>
                                    Importación
                                </option>
                            </select>
                        </div>

                        <!-- Idioma -->
                        <div>
                            <label for="language" class="form-label">Idioma</label>
                            <input type="text" id="language" name="language" value="{{ request('language') }}"
                                placeholder="Ej: es-ES, en" class="form-input">
                        </div>
                    </div>

                    <!-- Categorías -->
                    <div class="category-section">
                        <label class="form-label">Categorías de Interés</label>
                        <div class="category-grid">
                            @foreach ($categories as $category)
                                <div class="checkbox-group">
                                    <input type="checkbox" id="cat{{ $category->id }}" name="categories[]"
                                        value="{{ $category->id }}"
                                        {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                                    <label for="cat{{ $category->id }}">{{ $category->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="button-container right">
                        <button type="submit" class="btn">Aplicar Filtros</button>
                        <a href="{{ route('customers.filter') }}" class="btn btn-secondary">Limpiar</a>
                        <a href="{{ route('customers.export', request()->all()) }}" class="btn btn-secondary">Descargar Excel</a>
                    </div>
                </form>
            </div>

            {{-- ===================== BLOQUE 2: RESULTADOS ===================== --}}
            <div class="content-box resultados-container">
                <h2 class="section-title">Resultados ({{ count($customers ?? []) }} clientes encontrados)</h2>

                <div class="table-wrapper">
                    <table class="results-table">
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

                        {{-- Cuerpo de la Tabla --}}
<tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
@forelse ($customers ?? [] as $customer)
<tr>

    {{-- ID --}}
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
        {{ $customer->id }}
    </td>

    {{-- Nombre --}}
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
        {{ $customer->first_name }} {{ $customer->last_name }}
    </td>

    {{-- Email --}}
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
        {{ $customer->email }}
    </td>

    {{-- Teléfono --}}
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
        {{ $customer->phone }}
    </td>

    {{-- País --}}
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
        {{ $customer->country ?: 'N/A' }}
    </td>

    {{-- Ciudad --}}
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
        {{ $customer->city ?: 'N/A' }}
    </td>

    {{-- Empresa --}}
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
        {{ $customer->company ?: 'N/A' }}
    </td>

    {{-- Intereses --}}
    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300 max-w-xs overflow-hidden truncate">
        @if($customer->categories->isNotEmpty())
            {{ $customer->categories->pluck('name')->implode(', ') }}
        @else
            N/A
        @endif
    </td>

    {{-- Notas --}}
    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300 max-w-xs overflow-hidden truncate">
        {{ $customer->notes ?: 'Sin notas' }}
    </td>

    {{-- Fecha registro cliente --}}
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
        {{ $customer->created_at->format('d/m/Y H:i') }}
    </td>

    {{-- Fecha metadata --}}
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
        {{ $customer->metadata?->registration_date?->format('d/m/Y H:i') ?? 'N/A' }}
    </td>

    {{-- 🟦 GEOLOCALIZACIÓN CRM – SIEMPRE VISIBLE --}}
    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
        @if(is_array($customer->metadata?->geolocation))
            <div class="p-3 rounded bg-gray-100 dark:bg-gray-700 shadow text-xs">
                <p><strong>IP:</strong> {{ data_get($customer->metadata->geolocation, 'ip', 'N/A') }}</p>
                <p><strong>Lat:</strong> {{ data_get($customer->metadata->geolocation, 'lat', 'N/A') }}</p>
                <p><strong>Lon:</strong> {{ data_get($customer->metadata->geolocation, 'lon', 'N/A') }}</p>
                <p><strong>Precisión:</strong> {{ data_get($customer->metadata->geolocation, 'accuracy', 'N/A') }}m</p>
            </div>
        @else
            N/A
        @endif
    </td>

{{-- 🟦 TIMELINE CRM – DESPLEGABLE --}}
<td class="px-6 py-4">

    @if(is_array($customer->metadata?->digital_trace))

        {{-- Botón --}}
        <button
            type="button"
            onclick="toggleTrace({{ $customer->id }})"
            class="crm-btn-view"
        >
            Mostrar
        </button>

        {{-- Contenido oculto --}}
        <div id="trace-{{ $customer->id }}" class="hidden mt-3">

            <div class="space-y-3 p-2 bg-gray-50 dark:bg-gray-700 rounded shadow-inner max-h-72 overflow-y-auto">

                @foreach($customer->metadata->digital_trace as $trace)
                    <div class="flex items-start gap-3 p-2 border-b border-gray-200 dark:border-gray-600">

                        {{-- Icono --}}
                        @if($trace['type'] === 'click')
                            <div class="w-8 h-8 flex items-center justify-center bg-blue-500 text-white rounded-full">
                                <i class="bi bi-hand-index-thumb"></i>
                            </div>
                        @elseif($trace['type'] === 'route')
                            <div class="w-8 h-8 flex items-center justify-center bg-green-500 text-white rounded-full">
                                <i class="bi bi-link-45deg"></i>
                            </div>
                        @endif

                        {{-- Texto --}}
                        <div class="text-xs text-gray-700 dark:text-gray-300">
                            <p class="font-semibold">
                                {{ ucfirst($trace['type']) }}
                            </p>

                            <p><strong>Texto:</strong> {{ $trace['text'] ?: '-' }}</p>

                            @if(!empty($trace['href']))
                                <p>
                                    <strong>URL:</strong>
                                    <span class="text-blue-600 dark:text-blue-400">
                                        {{ $trace['href'] }}
                                    </span>
                                </p>
                            @endif

                            <p>
                                <strong>Hora:</strong>
                                {{ \Carbon\Carbon::parse($trace['timestamp'])->format('d/m/Y H:i:s') }}
                            </p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    @else
        N/A
    @endif
</td>


    {{-- IDIOMA --}}
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
        {{ $customer->metadata?->browser_language ?? 'N/A' }}
    </td>

    {{-- FUENTE --}}
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
        {{ $customer->metadata?->source ?? 'N/A' }}
    </td>

</tr>

@empty
<tr>
    <td colspan="16" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
        No se encontraron clientes con los filtros aplicados.
    </td>
</tr>
@endforelse
</tbody>
                {{-- Fin de la Tabla --}}

            </div>
        </div>
    </div>
</div>
<style>
.crm-btn-view {
    @apply bg-indigo-600 text-white px-3 py-1 rounded text-xs shadow hover:bg-indigo-700 transition;
}

.crm-card {
    @apply mt-2 p-3 rounded bg-gray-100 dark:bg-gray-700 text-xs text-gray-700 dark:text-gray-300 shadow;
}

.crm-timeline {
    @apply mt-3 space-y-3 p-2 bg-gray-50 dark:bg-gray-700 rounded shadow-inner max-h-60 overflow-y-auto;
}

.crm-timeline-item {
    @apply flex items-start gap-3 p-2 border-b border-gray-200 dark:border-gray-600;
}

.crm-t-icon {
    @apply w-8 h-8 flex items-center justify-center text-white rounded-full;
}
</style>
<script>
function toggleTrace(id) {
    document.getElementById("trace-" + id).classList.toggle("hidden");
}
function toggleGeo(id) {
    document.getElementById("geo-" + id).classList.toggle("hidden");
}
</script>


</x-app-layout>