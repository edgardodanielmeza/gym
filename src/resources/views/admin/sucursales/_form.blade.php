@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre de la Sucursal</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $sucursal->nombre ?? '') }}" required
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('nombre') border-red-500 @enderror">
        @error('nombre')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
        <input type="text" name="direccion" id="direccion" value="{{ old('direccion', $sucursal->direccion ?? '') }}" required
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('direccion') border-red-500 @enderror">
        @error('direccion')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
        <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $sucursal->telefono ?? '') }}"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('telefono') border-red-500 @enderror">
        @error('telefono')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $sucursal->email ?? '') }}"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-500 @enderror">
        @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="horario_apertura" class="block text-sm font-medium text-gray-700">Horario de Apertura (HH:MM)</label>
        <input type="time" name="horario_apertura" id="horario_apertura" value="{{ old('horario_apertura', isset($sucursal) && $sucursal->horario_apertura ? \Carbon\Carbon::parse($sucursal->horario_apertura)->format('H:i') : '') }}"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('horario_apertura') border-red-500 @enderror">
        @error('horario_apertura')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="horario_cierre" class="block text-sm font-medium text-gray-700">Horario de Cierre (HH:MM)</label>
        <input type="time" name="horario_cierre" id="horario_cierre" value="{{ old('horario_cierre', isset($sucursal) && $sucursal->horario_cierre ? \Carbon\Carbon::parse($sucursal->horario_cierre)->format('H:i') : '') }}"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('horario_cierre') border-red-500 @enderror">
        @error('horario_cierre')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-6 flex justify-end">
    <a href="{{ route('admin.sucursales.index') }}" class="mr-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        Cancelar
    </a>
    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        {{ isset($sucursal) ? 'Actualizar Sucursal' : 'Guardar Sucursal' }}
    </button>
</div>
