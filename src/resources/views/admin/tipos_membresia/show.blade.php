@extends('layouts.theme.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Detalles del Tipo de Membresía: <span class="text-indigo-600">{{ $tipoMembresia->nombre }}</span></h1>
            <div>
                <a href="{{ route('admin.tipos-membresia.edit', $tipoMembresia->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">
                    Editar
                </a>
                <a href="{{ route('admin.tipos-membresia.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                    &larr; Volver al Listado
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Nombre:</h3>
                <p class="text-gray-700">{{ $tipoMembresia->nombre }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Duración:</h3>
                <p class="text-gray-700">{{ $tipoMembresia->duracion_dias }} días</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Precio:</h3>
                <p class="text-gray-700">${{ number_format($tipoMembresia->precio, 2) }} MXN</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Estado:</h3>
                <p class="text-gray-700">
                    @if ($tipoMembresia->activa)
                        <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Activa
                        </span>
                    @else
                        <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Inactiva
                        </span>
                    @endif
                </p>
            </div>
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Descripción:</h3>
            <p class="text-gray-700 whitespace-pre-wrap">{{ $tipoMembresia->descripcion ?? 'N/A' }}</p>
        </div>

        <hr class="my-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Fecha de Creación:</h3>
                <p class="text-gray-700">{{ $tipoMembresia->created_at->format('d/m/Y H:i A') }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Última Actualización:</h3>
                <p class="text-gray-700">{{ $tipoMembresia->updated_at->format('d/m/Y H:i A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
