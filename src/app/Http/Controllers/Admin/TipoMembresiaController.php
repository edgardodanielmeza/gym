<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoMembresia;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TipoMembresiaController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $tiposMembresia = TipoMembresia::latest()->paginate(10);
        return view('admin.tipos_membresia.index', compact('tiposMembresia'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.tipos_membresia.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100|unique:tipos_membresia,nombre',
            'descripcion' => 'nullable|string',
            'duracion_dias' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'activa' => 'sometimes|boolean',
        ]);

        // Ensure 'activa' is present in the data, defaulting to false if not checked
        $validatedData['activa'] = $request->has('activa');

        TipoMembresia::create($validatedData);

        return redirect()->route('admin.tipos-membresia.index')
                         ->with('success', 'Tipo de membresía creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoMembresia $tipoMembresia): View
    {
        return view('admin.tipos_membresia.show', compact('tipoMembresia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoMembresia $tipoMembresia): View
    {
        return view('admin.tipos_membresia.edit', compact('tipoMembresia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoMembresia $tipoMembresia): RedirectResponse
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100|unique:tipos_membresia,nombre,' . $tipoMembresia->id,
            'descripcion' => 'nullable|string',
            'duracion_dias' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'activa' => 'sometimes|boolean',
        ]);

        $validatedData['activa'] = $request->has('activa');

        $tipoMembresia->update($validatedData);

        return redirect()->route('admin.tipos-membresia.index')
                         ->with('success', 'Tipo de membresía actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoMembresia $tipoMembresia): RedirectResponse
    {
        // Consider checking if any active membresias use this type before deleting
        $tipoMembresia->delete();

        return redirect()->route('admin.tipos-membresia.index')
                         ->with('success', 'Tipo de membresía eliminado exitosamente.');
    }
}
