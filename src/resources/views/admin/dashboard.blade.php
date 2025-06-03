@extends('layouts.theme.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Admin Dashboard</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <p class="text-gray-700">
            ¡Bienvenido al panel de administración! Aquí podrás gestionar usuarios, membresías, pagos y más.
        </p>
        <p class="text-gray-700 mt-4">
            Utiliza la barra lateral para navegar por las diferentes secciones.
        </p>
    </div>

    {{-- Example of how you might include stats or widgets later --}}
    {{--
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Usuarios Activos</h2>
            <p class="text-3xl font-bold text-indigo-600 mt-2">123</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-700">Ingresos del Mes</h2>
            <p class="text-3xl font-bold text-green-600 mt-2">$4,567</p>
        </div>
        <!-- More widgets -->
    </div>
    --}}
</div>
@endsection
