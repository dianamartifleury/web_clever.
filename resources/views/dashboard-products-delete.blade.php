<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Confirmar eliminación
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-10 px-6 bg-white dark:bg-gray-800 rounded shadow text-center">
        <h1 class="text-2xl font-bold mb-4">¿Seguro que deseas eliminar este producto?</h1>
        <p class="text-gray-600 mb-4">{{ $product->name }}</p>

        <div class="flex justify-center gap-4 mt-6">
            <form method="POST" action="{{ route('dashboard.products.destroy', $product) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Sí, eliminar
                </button>
            </form>

            <a href="{{ route('dashboard.products') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                Cancelar
            </a>
        </div>
    </div>
</x-app-layout>
