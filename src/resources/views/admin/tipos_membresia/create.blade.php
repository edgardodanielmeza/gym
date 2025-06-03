@extends('layouts.theme.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Crear Nuevo Tipo de Membresía</h1>
            <a href="{{ route('admin.tipos-membresia.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                &larr; Volver al Listado
            </a>
        </div>

        <form action="{{ route('admin.tipos-membresia.store') }}" method="POST">
            {{-- Pasamos una variable 'tipoMembresia' como null o un objeto vacío si el form lo espera para 'isset($tipoMembresia)' --}}
            @include('admin.tipos_membresia._form', ['tipoMembresia' => null])
        </form>
    </div>
</div>
@endsection
