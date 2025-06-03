@extends('layouts.theme.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-700 mb-2 sm:mb-0">
                Detalles del Miembro: <span class="text-indigo-600">{{ $miembro->nombre }} {{ $miembro->apellidos }}</span>
            </h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.miembros.edit', $miembro->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Editar Miembro
                </a>
                <a href="{{ route('admin.miembros.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium py-2 px-4 border border-indigo-600 rounded">
                    &larr; Volver al Listado
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Columna de Foto y Datos Principales --}}
            <div class="md:col-span-1">
                @if($miembro->foto_perfil_url)
                    <img src="{{ $miembro->foto_perfil_url }}" alt="Foto de {{ $miembro->nombre }}" class="w-full h-auto rounded-lg shadow-md object-cover mb-4">
                @else
                    <div class="w-full h-64 bg-gray-100 flex items-center justify-center rounded-lg shadow-md mb-4">
                        <svg class="h-32 w-32 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                @endif
                <h3 class="text-lg font-semibold text-gray-800">Número de Identificación:</h3>
                <p class="text-gray-700 mb-2">{{ $miembro->numero_identificacion ?? 'N/A' }}</p>

                <h3 class="text-lg font-semibold text-gray-800">Estado:</h3>
                <p class="text-gray-700 mb-2">
                    @if ($miembro->activo)
                        <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Activo</span>
                    @else
                        <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactivo</span>
                    @endif
                </p>
                <h3 class="text-lg font-semibold text-gray-800">Fecha de Registro:</h3>
                <p class="text-gray-700">{{ $miembro->fecha_registro->format('d/m/Y') }}</p>
            </div>

            {{-- Columna de Información Detallada --}}
            <div class="md:col-span-2 space-y-3">
                <div><h3 class="text-md font-semibold text-gray-800">Email:</h3><p class="text-gray-700">{{ $miembro->email }}</p></div>
                <div><h3 class="text-md font-semibold text-gray-800">Teléfono:</h3><p class="text-gray-700">{{ $miembro->telefono }}</p></div>
                <div><h3 class="text-md font-semibold text-gray-800">Fecha de Nacimiento:</h3><p class="text-gray-700">{{ $miembro->fecha_nacimiento ? $miembro->fecha_nacimiento->format('d/m/Y') : 'N/A' }} ({{ $miembro->fecha_nacimiento ? $miembro->fecha_nacimiento->age : 'N/A' }} años)</p></div>
                <div><h3 class="text-md font-semibold text-gray-800">Género:</h3><p class="text-gray-700">{{ $miembro->genero ?? 'N/A' }}</p></div>
                <div><h3 class="text-md font-semibold text-gray-800">Dirección:</h3><p class="text-gray-700 whitespace-pre-wrap">{{ $miembro->direccion ?? 'N/A' }}</p></div>
                <div><h3 class="text-md font-semibold text-gray-800">Sucursal Predeterminada:</h3><p class="text-gray-700">{{ $miembro->sucursalPredeterminada->nombre ?? 'N/A' }}</p></div>
                <div>
                    <h3 class="text-md font-semibold text-gray-800">Notas Adicionales:</h3>
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $miembro->notas_adicionales ?? 'N/A' }}</p>
                </div>
                <div><h3 class="text-md font-semibold text-gray-800">Creado:</h3><p class="text-gray-700">{{ $miembro->created_at->format('d/m/Y H:i A') }}</p></div>
                <div><h3 class="text-md font-semibold text-gray-800">Actualizado:</h3><p class="text-gray-700">{{ $miembro->updated_at->format('d/m/Y H:i A') }}</p></div>
            </div>
        </div>

        <hr class="my-6">

        {{-- Sección de Membresías (Placeholder) --}}
        <div>
            <h2 class="text-xl font-bold text-gray-700 mb-4">Membresías del Miembro</h2>
            @if($miembro->membresias && $miembro->membresias->count() > 0)
                <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipo</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha Inicio</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha Fin</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($miembro->membresias as $membresia)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">{{ $membresia->tipoMembresia->nombre }}</td>
                                    <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">{{ $membresia->fecha_inicio->format('d/m/Y') }}</td>
                                    <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">{{ $membresia->fecha_fin->format('d/m/Y') }}</td>
                                    <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm text-center">
                                        @if ($membresia->estado == 'Activa')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Activa</span>
                                        @elseif ($membresia->estado == 'Vencida')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Vencida</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ $membresia->estado }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-700">Este miembro no tiene membresías registradas.</p>
            @endif
            {{-- Aquí se podría añadir un botón para "Añadir Nueva Membresía" que lleve a otra sección --}}
        </div>

    </div>
</div>
@endsection
