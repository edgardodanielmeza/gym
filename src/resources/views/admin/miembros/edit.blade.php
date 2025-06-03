@extends('layouts.theme.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Editar Miembro: <span class="text-indigo-600">{{ $miembro->nombre }} {{ $miembro->apellidos }}</span></h1>
            <a href="{{ route('admin.miembros.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                &larr; Volver al Listado
            </a>
        </div>

        <form action="{{ route('admin.miembros.update', $miembro->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.miembros._form', ['miembro' => $miembro, 'sucursales' => $sucursales])
        </form>
    </div>
</div>
@endsection
