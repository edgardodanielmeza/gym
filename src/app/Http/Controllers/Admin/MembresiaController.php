<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membresia;
use App\Models\Miembro;
use App\Models\TipoMembresia;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;

class MembresiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request): View
    {
        $query = Membresia::with(['miembro', 'tipoMembresia'])->latest();

        if ($request->filled('miembro_id_filter')) {
            $query->where('miembro_id', $request->miembro_id_filter);
        }
        if ($request->filled('tipo_membresia_id_filter')) {
            $query->where('tipo_membresia_id', $request->tipo_membresia_id_filter);
        }
        if ($request->filled('estado_filter')) {
            $query->where('estado', $request->estado_filter);
        }
        // Add more filters as needed, e.g., date ranges

        $membresias = $query->paginate(15)->appends($request->query());

        // For filter dropdowns
        $miembros = Miembro::orderBy('apellidos')->orderBy('nombre')->get(['id', 'nombre', 'apellidos']);
        $tiposMembresia = TipoMembresia::orderBy('nombre')->get(['id', 'nombre']);
        $estados = [Membresia::ESTADO_ACTIVA, Membresia::ESTADO_PENDIENTE, Membresia::ESTADO_VENCIDA, Membresia::ESTADO_CANCELADA];


        return view('admin.membresias.index', compact('membresias', 'miembros', 'tiposMembresia', 'estados'));
    }

    public function create(Miembro $miembro): View
    {
        $tiposMembresia = TipoMembresia::where('activa', true)->orderBy('nombre')->get();
        return view('admin.membresias.create', compact('miembro', 'tiposMembresia'));
    }

    public function store(Request $request, Miembro $miembro): RedirectResponse
    {
        $request->validate([
            'tipo_membresia_id' => 'required|exists:tipos_membresia,id',
            'fecha_inicio' => 'required|date',
            'precio_pagado' => 'nullable|numeric|min:0',
            'notas' => 'nullable|string',
            'renovacion_automatica' => 'sometimes|boolean',
        ]);

        $tipoMembresia = TipoMembresia::findOrFail($request->tipo_membresia_id);
        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = $fechaInicio->copy()->addDays($tipoMembresia->duracion_dias);

        $data = $request->all();
        $data['miembro_id'] = $miembro->id;
        $data['fecha_fin'] = $fechaFin;
        // Default estado if not explicitly set or based on payment (e.g. 'Pendiente de Pago' from migration default)
        // For now, let's assume if we are creating it via admin, it becomes active or based on payment.
        // If precio_pagado is present and > 0, or if tipo has 0 price, consider it Activa. Otherwise, Pendiente.
        if (($request->filled('precio_pagado') && $request->precio_pagado > 0) || $tipoMembresia->precio == 0) {
            $data['estado'] = Membresia::ESTADO_ACTIVA;
        } else {
            // Matches the migration default 'Pendiente de Pago' if we use that constant
            // Or use our defined constant if 'Pendiente de Pago' string is okay
            $data['estado'] = Membresia::ESTADO_PENDIENTE; // Or 'Pendiente de Pago' string
        }
        $data['renovacion_automatica'] = $request->has('renovacion_automatica');


        Membresia::create($data);

        return redirect()->route('admin.miembros.show', $miembro->id)
                         ->with('success', 'Membresía asignada exitosamente.');
    }

    public function show(Membresia $membresia): View
    {
        $membresia->load(['miembro', 'tipoMembresia', 'facturas']);
        return view('admin.membresias.show', compact('membresia'));
    }

    // Placeholder for edit, update, destroy
    public function edit(Membresia $membresia): View
    {
        // Similar to create, but for an existing membresia
        // Needs $tiposMembresia
        $tiposMembresia = TipoMembresia::where('activa', true)->orderBy('nombre')->get();
        return view('admin.membresias.edit', compact('membresia', 'tiposMembresia'));
    }

    public function update(Request $request, Membresia $membresia): RedirectResponse
    {
        // Validation and update logic
        // Similar to store, but for an existing membresia
        // Be careful with fecha_fin recalculation if fecha_inicio or tipo_membresia changes
        // For now, a simple update example:
        $request->validate([
            'tipo_membresia_id' => 'required|exists:tipos_membresia,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'precio_pagado' => 'nullable|numeric|min:0',
            'estado' => 'required|string|in:'.implode(',',[Membresia::ESTADO_ACTIVA, Membresia::ESTADO_PENDIENTE, Membresia::ESTADO_VENCIDA, Membresia::ESTADO_CANCELADA]),
            'notas' => 'nullable|string',
            'renovacion_automatica' => 'sometimes|boolean',
        ]);

        $data = $request->all();
        $data['renovacion_automatica'] = $request->has('renovacion_automatica');

        $membresia->update($data);

        return redirect()->route('admin.membresias.show', $membresia->id)
                         ->with('success', 'Membresía actualizada exitosamente.');
    }

    public function destroy(Membresia $membresia): RedirectResponse
    {
        $miembroId = $membresia->miembro_id; // Save for redirect
        $membresia->delete();
        return redirect()->route('admin.miembros.show', $miembroId) // Or admin.membresias.index
                         ->with('success', 'Membresía eliminada exitosamente.');
    }

}
