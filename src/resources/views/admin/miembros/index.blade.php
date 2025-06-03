@extends('layouts.theme.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-700 mb-4 sm:mb-0">Gestión de Miembros</h1>
        <a href="{{ route('admin.miembros.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Registrar Nuevo Miembro
        </a>
    </div>

    <!-- Filtros -->
    <div class="mb-6 p-4 bg-white shadow-md rounded-lg">
        <form action="{{ route('admin.miembros.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <label for="nombre_filter" class="block text-sm font-medium text-gray-700">Nombre/Apellido</label>
                <input type="text" name="nombre" id="nombre_filter" value="{{ request('nombre') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="email_filter" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="text" name="email" id="email_filter" value="{{ request('email') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="sucursal_filter" class="block text-sm font-medium text-gray-700">Sucursal</label>
                <select name="sucursal_id" id="sucursal_filter" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Todas</option>
                    @foreach($sucursales as $sucursal)
                        <option value="{{ $sucursal->id }}" {{ request('sucursal_id') == $sucursal->id ? 'selected' : '' }}>
                            {{ $sucursal->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Filtrar</button>
                <a href="{{ route('admin.miembros.index') }}" class="ml-2 text-sm text-gray-600 hover:text-gray-800">Limpiar</a>
            </div>
        </form>
    </div>


    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Éxito!</strong> <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong> <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Foto</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre Completo</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Teléfono</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Sucursal Pred.</th>
                    <th class="px-3 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Activo</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($miembros as $miembro)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm">
                            @if($miembro->foto_perfil_url)
                                <img src="{{ $miembro->foto_perfil_url }}" alt="Foto de {{ $miembro->nombre }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <span class="inline-block h-10 w-10 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center">
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $miembro->nombre }} {{ $miembro->apellidos }}</p>
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $miembro->email }}</p>
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $miembro->telefono }}</p>
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $miembro->sucursalPredeterminada->nombre ?? 'N/A' }}</p>
                        </td>
                        <td class="px-3 py-3 border-b border-gray-200 bg-white text-sm text-center">
                            @if ($miembro->activo)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Sí</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">No</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm whitespace-no-wrap">
                            <a href="{{ route('admin.miembros.show', $miembro->id) }}" class="text-xs bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline mr-1">Ver</a>
                            <a href="{{ route('admin.miembros.edit', $miembro->id) }}" class="text-xs bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline mr-1">Editar</a>
                            <form action="{{ route('admin.miembros.destroy', $miembro->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este miembro? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                            No hay miembros registrados que coincidan con los filtros.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($miembros->hasPages())
        <div class="mt-8">
            {{ $miembros->links() }}
        </div>
    @endif
</div>
@endsection
