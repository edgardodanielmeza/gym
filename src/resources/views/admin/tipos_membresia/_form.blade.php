@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Tipo de Membresía</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $tipoMembresia->nombre ?? '') }}" required
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('nombre') border-red-500 @enderror">
        @error('nombre')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="duracion_dias" class="block text-sm font-medium text-gray-700">Duración (días)</label>
        <input type="number" name="duracion_dias" id="duracion_dias" value="{{ old('duracion_dias', $tipoMembresia->duracion_dias ?? '') }}" required min="1"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('duracion_dias') border-red-500 @enderror">
        @error('duracion_dias')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="3"
                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $tipoMembresia->descripcion ?? '') }}</textarea>
        @error('descripcion')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="precio" class="block text-sm font-medium text-gray-700">Precio (MXN)</label>
        <input type="number" name="precio" id="precio" value="{{ old('precio', $tipoMembresia->precio ?? '') }}" required min="0" step="0.01"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('precio') border-red-500 @enderror">
        @error('precio')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center mt-4 md:mt-8">
        <input type="checkbox" name="activa" id="activa" value="1"
               @if(old('activa', isset($tipoMembresia) ? $tipoMembresia->activa : true)) checked @endif
               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
        <label for="activa" class="ml-2 block text-sm font-medium text-gray-700">Activa</label>
        @error('activa')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-8 flex justify-end">
    <a href="{{ route('admin.tipos-membresia.index') }}" class="mr-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        Cancelar
    </a>
    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        {{ isset($tipoMembresia) ? 'Actualizar Tipo' : 'Guardar Tipo' }}
    </button>
</div>
