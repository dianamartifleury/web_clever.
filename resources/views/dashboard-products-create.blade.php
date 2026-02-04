<x-app-layout>
    <x-slot name="header">
        <h2>Crear Producto</h2>
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

                <!-- Mostrar errores de validación -->
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('dashboard.products.store') }}" enctype="multipart/form-data" class="filter-form">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Nombre del producto</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Descripción</label>
                        <textarea name="description" class="form-input">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Categoría</label>
                        <select name="category_id" class="form-input" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Subir imagen (opcional)</label>
                        <input type="file" name="image_path" accept="image/*" class="form-input">
                        <p class="text-sm text-gray-500">Máximo 5MB. Formatos permitidos: jpg, jpeg, png, gif.</p>
                    </div>

                    <div class="button-container right">
                        <button type="submit" class="btn">Crear producto</button>
                        <a href="{{ route('dashboard.products') }}" class="btn">Volver</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
