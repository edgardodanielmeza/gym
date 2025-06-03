<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Miembro;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class MiembroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request): View
    {
        $query = Miembro::with('sucursalPredeterminada')->latest();

        if ($request->filled('nombre')) {
            $query->where(function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->nombre . '%')
                  ->orWhere('apellidos', 'like', '%' . $request->nombre . '%');
            });
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->filled('sucursal_id')) {
            $query->where('sucursal_predeterminada_id', $request->sucursal_id);
        }

        $miembros = $query->paginate(10)->appends($request->query());
        $sucursales = Sucursal::orderBy('nombre')->get();

        return view('admin.miembros.index', compact('miembros', 'sucursales'));
    }

    public function create(): View
    {
        $sucursales = Sucursal::orderBy('nombre')->get();
        return view('admin.miembros.create', compact('sucursales'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'sucursal_predeterminada_id' => 'required|exists:sucursales,id',
            'numero_identificacion' => 'nullable|string|max:50|unique:miembros,numero_identificacion',
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'genero' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:100|unique:miembros,email',
            'fecha_registro' => 'required|date',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 'foto_perfil' es el name del input file
            'notas_adicionales' => 'nullable|string',
            'activo' => 'sometimes|boolean',
        ]);

        $data = $request->except('foto_perfil');
        $data['activo'] = $request->has('activo');

        if ($request->hasFile('foto_perfil')) {
            $path = $request->file('foto_perfil')->store('public/fotos_perfil');
            $data['foto_perfil_url'] = Storage::url($path); // Almacena la URL pública
        }

        Miembro::create($data);

        return redirect()->route('admin.miembros.index')
                         ->with('success', 'Miembro creado exitosamente.');
    }

    public function show(Miembro $miembro): View
    {
        $miembro->load('sucursalPredeterminada', 'membresias.tipoMembresia'); // Cargar relaciones
        return view('admin.miembros.show', compact('miembro'));
    }

    public function edit(Miembro $miembro): View
    {
        $sucursales = Sucursal::orderBy('nombre')->get();
        return view('admin.miembros.edit', compact('miembro', 'sucursales'));
    }

    public function update(Request $request, Miembro $miembro): RedirectResponse
    {
        $request->validate([
            'sucursal_predeterminada_id' => 'required|exists:sucursales,id',
            'numero_identificacion' => 'nullable|string|max:50|unique:miembros,numero_identificacion,' . $miembro->id,
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'genero' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:100|unique:miembros,email,' . $miembro->id,
            'fecha_registro' => 'required|date',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notas_adicionales' => 'nullable|string',
            'activo' => 'sometimes|boolean',
        ]);

        $data = $request->except('foto_perfil');
        $data['activo'] = $request->has('activo');

        if ($request->hasFile('foto_perfil')) {
            // Eliminar foto antigua si existe
            if ($miembro->foto_perfil_url) {
                $oldPath = str_replace(Storage::url(''), '', $miembro->foto_perfil_url);
                Storage::delete($oldPath);
            }
            $path = $request->file('foto_perfil')->store('public/fotos_perfil');
            $data['foto_perfil_url'] = Storage::url($path);
        }

        $miembro->update($data);

        return redirect()->route('admin.miembros.index')
                         ->with('success', 'Miembro actualizado exitosamente.');
    }

    public function destroy(Miembro $miembro): RedirectResponse
    {
        if ($miembro->foto_perfil_url) {
            $oldPath = str_replace(Storage::url(''), '', $miembro->foto_perfil_url);
            Storage::delete($oldPath);
        }

        // Considerar lógica adicional, como membresías activas, antes de eliminar.
        // Por ejemplo, no permitir eliminar si tiene membresías activas o anonimizar datos.
        $miembro->delete();

        return redirect()->route('admin.miembros.index')
                         ->with('success', 'Miembro eliminado exitosamente.');
    }
}
