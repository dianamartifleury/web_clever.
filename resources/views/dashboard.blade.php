<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Panel de administración
        </h1>
    </x-slot>

    <div class="page-wrapper">
        <div class="page-container">
            <div class="content-box">

                <!-- ========================================= -->
                <!-- SECCIÓN: Gestión de Clientes -->
                <!-- ========================================= -->
                <h2>Gestión de Clientes</h2>
                <hr class="my-6">

                <div class="button-container">
                    <a href="{{ route('customers.index') }}" class="btn">
                        Acceder al Listado de Clientes
                    </a>
                    <a href="{{ route('customers.filter') }}" class="btn">
                        Hacer Consulta Personalizada
                    </a>
                </div>

                <hr class="my-8">

                <div class="button-container">
                    <a href="{{ route('customers.metadata') }}" class="btn">
                        Consultar Metadatos
                    </a>
                </div>

            </div>

            <!-- ========================================= -->
            <!-- SECCIÓN: Gestión de Productos -->
            <!-- ========================================= -->
            <div class="content-box" style="margin-top: 2rem;">
                <h2>Gestión de Productos</h2>

                <div class="button-container">
                    <a href="{{ route('dashboard.products') }}" class="btn">
                        Gestionar Productos
                    </a>
                    <a href="{{ route('dashboard.products.create') }}" class="btn">
                        Añadir Nuevo Producto o Categoría
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
