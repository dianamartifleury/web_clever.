<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard de Productos
        </h2>
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
            <div class="content-box">
                <!-- BUSCADOR -->
                <form method="GET" action="{{ route('dashboard.products') }}" class="search-form">
                    <input type="text" name="q" id="q"
                        placeholder="Buscar producto..."
                        value="{{ request('q') }}"
                        class="form-input search-input">
                    <button type="submit" class="btn search-button">Buscar</button>
                </form>
                <!-- MENSAJE DE ÉXITO -->
                @if(session('success'))
                    <div class="content-box" style="background-color: #d1fae5; color: #065f46; border-left: 4px solid #10b981;">
                        {{ session('success') }}
                    </div>
                @endif
                <!-- GRID DE CATEGORÍAS -->
                <div class="category-section">
                    <h2 class="section-title">Categorías y Productos</h2>
                    <div class="category-grid">
                        @foreach($categories as $category)
                            <div class="content-box">
                                <h3 class="text-lg font-semibold mb-2">{{ $category->name }}</h3>
                                @if($category->products->isEmpty())
                                    <p class="text-gray-500">No hay productos</p>
                                    <div class="button-container">
                                        <a href="#" class="btn btn-secondary disabled" style="opacity: 0.5; cursor: not-allowed;">Ver</a>
                                        <button class="btn btn-secondary disabled" style="opacity: 0.5; cursor: not-allowed;" disabled>Eliminar</button>
                                    </div>
                                @else
                                    <ul class="category-list" style="list-style: none; padding: 0; margin: 0;">
                                        @foreach($category->products as $product)
                                            <li class="border p-2 rounded" style="margin-bottom: 0.75rem;">
                                                <div class="flex-between" style="display: flex; justify-content: space-between; align-items: center;">
                                                    <div>
                                                        <strong>{{ $product->name }}</strong>
                                                        <span style="color:#6b7280;">(Stock: {{ $product->stock ?? 0 }})</span><br>
                                                        <span class="text-gray-600">{{ $product->description }}</span>
                                                    </div>

                                                    <div class="button-container" style="gap: 0.5rem; padding-top: 0;">
                                                        <a href="{{ route('dashboard.products.show', $product) }}" class="btn">
                                                            Ver / Editar
                                                        </a>
                                                        <a href="{{ route('dashboard.products.confirmDelete', $product) }}" class="btn btn-secondary" style="background-color:#b91c1c; color:white;">
                                                            Eliminar
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
