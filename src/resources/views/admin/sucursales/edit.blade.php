@extends('layouts.theme.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Editar Sucursal: <span class="text-indigo-600">{{ $sucursal->nombre }}</span></h1>
            <a href="{{ route('admin.sucursales.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                &larr; Volver al Listado
            </a>
        </div>

        <form action="{{ route('admin.sucursales.update', $sucursal->id) }}" method="POST">
            @method('PUT')
            @include('admin.sucursales._form', ['sucursal' => $sucursal])
        </form>
    </div>
</div>
@endsection
