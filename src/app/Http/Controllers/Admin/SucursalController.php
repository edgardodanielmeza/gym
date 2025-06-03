<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SucursalController extends Controller
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
        $sucursales = Sucursal::latest()->paginate(10); // Example pagination
        return view('admin.sucursales.index', compact('sucursales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.sucursales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:sucursales,nombre',
            'direccion' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'horario_apertura' => 'nullable|date_format:H:i', // o H:i:s si se usan segundos
            'horario_cierre' => 'nullable|date_format:H:i', // o H:i:s si se usan segundos
        ]);

        Sucursal::create($request->all());

        return redirect()->route('admin.sucursales.index')
                         ->with('success', 'Sucursal creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sucursal $sucursal): View
    {
        return view('admin.sucursales.show', compact('sucursal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sucursal $sucursal): View
    {
        return view('admin.sucursales.edit', compact('sucursal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sucursal $sucursal): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:sucursales,nombre,' . $sucursal->id,
            'direccion' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'horario_apertura' => 'nullable|date_format:H:i',
            'horario_cierre' => 'nullable|date_format:H:i',
        ]);

        $sucursal->update($request->all());

        return redirect()->route('admin.sucursales.index')
                         ->with('success', 'Sucursal actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sucursal $sucursal): RedirectResponse
    {
        $sucursal->delete();

        return redirect()->route('admin.sucursales.index')
                         ->with('success', 'Sucursal eliminada exitosamente.');
    }
}
