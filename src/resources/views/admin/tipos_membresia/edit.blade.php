@extends('layouts.theme.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Editar Tipo de Membresía: <span class="text-indigo-600">{{ $tipoMembresia->nombre }}</span></h1>
            <a href="{{ route('admin.tipos-membresia.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                &larr; Volver al Listado
            </a>
        </div>

        <form action="{{ route('admin.tipos-membresia.update', $tipoMembresia->id) }}" method="POST">
            @method('PUT')
            @include('admin.tipos_membresia._form', ['tipoMembresia' => $tipoMembresia])
        </form>
    </div>
</div>
@endsection
