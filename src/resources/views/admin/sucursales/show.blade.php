@extends('layouts.theme.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Detalles de Sucursal: <span class="text-indigo-600">{{ $sucursal->nombre }}</span></h1>
            <div>
                <a href="{{ route('admin.sucursales.edit', $sucursal->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">
                    Editar
                </a>
                <a href="{{ route('admin.sucursales.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                    &larr; Volver al Listado
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Nombre:</h3>
                <p class="text-gray-700">{{ $sucursal->nombre }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Dirección:</h3>
                <p class="text-gray-700">{{ $sucursal->direccion }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Teléfono:</h3>
                <p class="text-gray-700">{{ $sucursal->telefono ?? 'N/A' }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Email:</h3>
                <p class="text-gray-700">{{ $sucursal->email ?? 'N/A' }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Horario de Apertura:</h3>
                <p class="text-gray-700">{{ $sucursal->horario_apertura ? \Carbon\Carbon::parse($sucursal->horario_apertura)->format('h:i A') : 'N/A' }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Horario de Cierre:</h3>
                <p class="text-gray-700">{{ $sucursal->horario_cierre ? \Carbon\Carbon::parse($sucursal->horario_cierre)->format('h:i A') : 'N/A' }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Fecha de Creación:</h3>
                <p class="text-gray-700">{{ $sucursal->created_at->format('d/m/Y H:i A') }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Última Actualización:</h3>
                <p class="text-gray-700">{{ $sucursal->updated_at->format('d/m/Y H:i A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
