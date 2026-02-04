<x-app-layout>
    <x-slot name="header">
        <h2>Editar Producto</h2>
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

                <!-- Mensajes de éxito -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('dashboard.products.update', $product) }}" enctype="multipart/form-data" class="filter-form">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label class="form-label">Nombre del producto</label>
                        <input type="text" name="name" value="{{ $product->name }}" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Descripción</label>
                        <textarea name="description" class="form-input">{{ $product->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" value="{{ $product->stock ?? 0 }}" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Categoría</label>
                        <select name="category_id" class="form-input" required>
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}" @if($product->category_id == $category->id) selected @endif>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Imagen actual -->
                    @if($product->image_path)
                        <div class="form-group">
                            <label class="form-label">Imagen actual</label>
                            <div>
                                <img src="{{ asset('storage/' . $product->image_path) }}" 
                                     alt="{{ $product->name }}" 
                                     style="width:100px; height:100px; object-fit:cover; border-radius:0.5rem; box-shadow:0 1px 2px rgba(0,0,0,0.05);">
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">Subir nueva imagen</label>
                        <input type="file" name="image_path" accept="image/*" class="form-input">
                    </div>

                    <div class="button-container">
                        <button type="submit" class="btn">Guardar cambios</button>
                        <a href="{{ route('dashboard.products') }}" class="btn">Volver</a>
                    </div>
                </form>

                <!-- Eliminar producto -->
                <div class="button-container right">
                    <form method="POST" action="{{ route('dashboard.products.destroy', $product) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background-color:#ef4444; color:white;">Eliminar producto</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
