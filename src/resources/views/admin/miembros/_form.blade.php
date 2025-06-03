@csrf
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- Columna 1 --}}
    <div class="md:col-span-1 space-y-6">
        <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre(s)</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $miembro->nombre ?? '') }}" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('nombre') border-red-500 @enderror">
            @error('nombre') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $miembro->apellidos ?? '') }}" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('apellidos') border-red-500 @enderror">
            @error('apellidos') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $miembro->email ?? '') }}" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-500 @enderror">
            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
            <input type="tel" name="telefono" id="telefono" value="{{ old('telefono', $miembro->telefono ?? '') }}" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('telefono') border-red-500 @enderror">
            @error('telefono') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Columna 2 --}}
    <div class="md:col-span-1 space-y-6">
        <div>
            <label for="numero_identificacion" class="block text-sm font-medium text-gray-700">Número Identificación (Opcional)</label>
            <input type="text" name="numero_identificacion" id="numero_identificacion" value="{{ old('numero_identificacion', $miembro->numero_identificacion ?? '') }}"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('numero_identificacion') border-red-500 @enderror">
            @error('numero_identificacion') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento', isset($miembro) && $miembro->fecha_nacimiento ? $miembro->fecha_nacimiento->format('Y-m-d') : '') }}"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('fecha_nacimiento') border-red-500 @enderror">
            @error('fecha_nacimiento') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="genero" class="block text-sm font-medium text-gray-700">Género</label>
            <select name="genero" id="genero" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('genero') border-red-500 @enderror">
                <option value="">Seleccione...</option>
                <option value="Masculino" {{ old('genero', $miembro->genero ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                <option value="Femenino" {{ old('genero', $miembro->genero ?? '') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                <option value="Otro" {{ old('genero', $miembro->genero ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
                <option value="Prefiero no decirlo" {{ old('genero', $miembro->genero ?? '') == 'Prefiero no decirlo' ? 'selected' : '' }}>Prefiero no decirlo</option>
            </select>
            @error('genero') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección (Opcional)</label>
            <textarea name="direccion" id="direccion" rows="3"
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('direccion') border-red-500 @enderror">{{ old('direccion', $miembro->direccion ?? '') }}</textarea>
            @error('direccion') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Columna 3 --}}
    <div class="md:col-span-1 space-y-6">
        <div>
            <label for="sucursal_predeterminada_id" class="block text-sm font-medium text-gray-700">Sucursal Predeterminada</label>
            <select name="sucursal_predeterminada_id" id="sucursal_predeterminada_id" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('sucursal_predeterminada_id') border-red-500 @enderror">
                <option value="">Seleccione una sucursal</option>
                @foreach($sucursales as $sucursal)
                    <option value="{{ $sucursal->id }}" {{ old('sucursal_predeterminada_id', $miembro->sucursal_predeterminada_id ?? '') == $sucursal->id ? 'selected' : '' }}>
                        {{ $sucursal->nombre }}
                    </option>
                @endforeach
            </select>
            @error('sucursal_predeterminada_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="fecha_registro" class="block text-sm font-medium text-gray-700">Fecha de Registro</label>
            <input type="date" name="fecha_registro" id="fecha_registro" value="{{ old('fecha_registro', isset($miembro) && $miembro->fecha_registro ? $miembro->fecha_registro->format('Y-m-d') : date('Y-m-d')) }}" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('fecha_registro') border-red-500 @enderror">
            @error('fecha_registro') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="foto_perfil" class="block text-sm font-medium text-gray-700">Foto de Perfil (Opcional)</label>
            <input type="file" name="foto_perfil" id="foto_perfil"
                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('foto_perfil') border-red-500 @enderror">
            @error('foto_perfil') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            @if(isset($miembro) && $miembro->foto_perfil_url)
                <div class="mt-2">
                    <img src="{{ $miembro->foto_perfil_url }}" alt="Foto de perfil actual" class="h-20 w-20 object-cover rounded-full">
                    <p class="text-xs text-gray-500 mt-1">Foto actual. Subir una nueva la reemplazará.</p>
                </div>
            @endif
        </div>

        <div class="pt-5">
             <label for="notas_adicionales" class="block text-sm font-medium text-gray-700">Notas Adicionales (Opcional)</label>
            <textarea name="notas_adicionales" id="notas_adicionales" rows="3"
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('notas_adicionales') border-red-500 @enderror">{{ old('notas_adicionales', $miembro->notas_adicionales ?? '') }}</textarea>
            @error('notas_adicionales') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>


        <div class="flex items-center mt-1">
            <input type="checkbox" name="activo" id="activo" value="1"
                   @if(old('activo', isset($miembro) ? $miembro->activo : true)) checked @endif
                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
            <label for="activo" class="ml-2 block text-sm font-medium text-gray-700">Activo</label>
        </div>
    </div>
</div>

<div class="mt-8 flex justify-end">
    <a href="{{ route('admin.miembros.index') }}" class="mr-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        Cancelar
    </a>
    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        {{ isset($miembro) ? 'Actualizar Miembro' : 'Guardar Miembro' }}
    </button>
</div>
